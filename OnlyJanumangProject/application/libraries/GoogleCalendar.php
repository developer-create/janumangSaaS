<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google Calendar Integration Library
 * Handles Google Calendar API operations
 */
class GoogleCalendar {
    
    private $client;
    private $service;
    private $ci;
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $boundUserId = null;
    
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->config('google_calendar');
        
        // Check if Google API client library exists - try multiple paths
        // Path 1: Project root vendor (Composer installed)
        $autoloadPath = APPPATH . '../vendor/autoload.php';
        // Path 2: Third-party directory
        if (!file_exists($autoloadPath)) {
            $autoloadPath = APPPATH . 'third_party/google-api-php-client/vendor/autoload.php';
        }
        
        if (!file_exists($autoloadPath)) {
            log_message('error', 'Google API PHP Client library not found. Tried: APPPATH ../vendor/autoload.php and APPPATH third_party/...');
            $this->client = null;
            return;
        }
        
        require_once $autoloadPath;
        
        $this->clientId = $this->ci->config->item('google_client_id');
        $this->clientSecret = $this->ci->config->item('google_client_secret');
        $this->redirectUri = $this->ci->config->item('google_redirect_uri');
        
        if (empty($this->clientId) || empty($this->clientSecret)) {
            log_message('error', 'Google Calendar API credentials not configured. Client ID or Secret is missing.');
            $this->client = null;
            return;
        }
        
        try {
            if (!class_exists('Google_Client')) {
                throw new Exception('Google_Client class not found. Please ensure Google API PHP Client library is properly installed.');
            }
            
            $this->client = new Google_Client();
            $this->client->setClientId($this->clientId);
            $this->client->setClientSecret($this->clientSecret);
            $this->client->setRedirectUri($this->redirectUri);
            $this->client->setScopes(array('https://www.googleapis.com/auth/calendar'));
            $this->client->setAccessType('offline');
            $this->client->setPrompt('consent');
        } catch (Exception $e) {
            log_message('error', 'Google Calendar library initialization error: ' . $e->getMessage());
            $this->client = null;
        }
    }
    
    /**
     * Get authorization URL for OAuth
     */
    public function getAuthUrl() {
        if (!$this->client) {
            throw new Exception('Google Calendar client is not initialized. Please check if Google API PHP Client library is installed and credentials are configured.');
        }
        return $this->client->createAuthUrl();
    }
    
    /**
     * Authenticate and get access token
     */
    public function authenticate($code) {
        if (!$this->client) {
            throw new Exception('Google Calendar client is not initialized. Please check if Google API PHP Client library is installed and credentials are configured.');
        }
        
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        
        if (isset($token['error'])) {
            return false;
        }
        
        $this->client->setAccessToken($token);
        
        // Save refresh token to database
        if (isset($token['refresh_token'])) {
            $this->saveRefreshToken($token['refresh_token'], $this->boundUserId);
        }
        
        return $token;
    }
    
    /**
     * Set access token from stored refresh token
     */
    public function setAccessTokenFromRefresh($refreshToken = null, $userId = null) {
        if (!$this->client) {
            log_message('error', 'Google Calendar client is not initialized. Cannot refresh token.');
            return false;
        }

        if ($refreshToken === null) {
            $refreshToken = $this->getRefreshToken($userId);
        }
        
        if (!$refreshToken) {
            return false;
        }
        
        try {
            $this->client->refreshToken($refreshToken);
            $accessToken = $this->client->getAccessToken();
            $this->client->setAccessToken($accessToken);
            $this->service = new Google_Service_Calendar($this->client);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Google Calendar refresh token error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create event in Google Calendar. Insert into all configured calendars.
     */
    public function createEvent($eventData) {
        if (!$this->service) {
            if (!$this->setAccessTokenFromRefresh()) {
                return false;
            }
        }

        $calendarIds = $this->getCalendarIds();
        $createdIds = [];

        foreach ($calendarIds as $calendarId) {
            try {
                log_message('info', 'Google Calendar createEvent starting for event: ' . (isset($eventData['name']) ? $eventData['name'] : 'unknown') . ' on calendar ' . $calendarId);

                $event = new Google_Service_Calendar_Event();
                $event->setSummary($eventData['name']);

                // Set description
                $description = '';
                if (!empty($eventData['event_detail'])) {
                    $description .= 'Event Detail: ' . $eventData['event_detail'] . "\n";
                }
                if (!empty($eventData['location'])) {
                    $description .= 'Location: ' . $eventData['location'] . "\n";
                }
                if (!empty($eventData['address'])) {
                    $description .= 'Address: ' . $eventData['address'] . "\n";
                }
                if (!empty($eventData['contact_number'])) {
                    $description .= 'Contact: ' . $eventData['contact_number'] . "\n";
                }
                if (!empty($eventData['remark'])) {
                    $description .= 'Remarks: ' . $eventData['remark'];
                }
                $event->setDescription($description);

                $location = '';
                if (!empty($eventData['venue_city'])) {
                    $location .= $eventData['venue_city'];
                }
                if (!empty($eventData['address'])) {
                    $location .= ($location ? ', ' : '') . $eventData['address'];
                }
                if ($location) {
                    $event->setLocation($location);
                }

                $time = !empty($eventData['time']) ? $eventData['time'] : '09:00:00';
                if (strlen($time) == 5) {
                    $time .= ':00';
                }
                $startDateTime = $eventData['program_date'] . 'T' . $time;
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime($startDateTime);
                $start->setTimeZone('Asia/Kolkata');
                $event->setStart($start);

                $duration = !empty($eventData['tentative_duration']) ? (int)$eventData['tentative_duration'] : 1;
                $endDateTime = date('Y-m-d\TH:i:s', strtotime($startDateTime . ' +' . $duration . ' hours'));
                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime($endDateTime);
                $end->setTimeZone('Asia/Kolkata');
                $event->setEnd($end);

                $createdEvent = $this->service->events->insert($calendarId, $event);
                $createdIds[] = $createdEvent->getId();

                log_message('info', 'Google Calendar createEvent success: created event with ID ' . $createdEvent->getId() . ' in calendar ' . $calendarId);
            } catch (Exception $e) {
                log_message('error', 'Google Calendar create event error for calendar ' . $calendarId . ': ' . $e->getMessage());
            }
        }

        return !empty($createdIds) ? $createdIds : false;
    }
    
    /**
     * Update event in Google Calendar (all configured calendars)
     */
    public function updateEvent($googleEventIds, $eventData) {
        if (!$this->service) {
            if (!$this->setAccessTokenFromRefresh()) {
                return false;
            }
        }

        $calendarIds = $this->getCalendarIds();
        $existingIds = [];

        if (is_string($googleEventIds)) {
            $existingIds = array_filter(array_map('trim', explode(',', $googleEventIds)));
        } elseif (is_array($googleEventIds)) {
            $existingIds = array_filter(array_map('trim', $googleEventIds));
        }

        $resultIds = [];

        foreach ($calendarIds as $index => $calendarId) {
            $targetGoogleId = isset($existingIds[$index]) ? $existingIds[$index] : null;

            try {
                if ($targetGoogleId) {
                    log_message('info', 'Google Calendar updateEvent starting for googleEventId: ' . $targetGoogleId . ' on calendar ' . $calendarId);
                    $event = $this->service->events->get($calendarId, $targetGoogleId);
                } else {
                    log_message('info', 'Google Calendar updateEvent will create new event on calendar ' . $calendarId);
                    $event = new Google_Service_Calendar_Event();
                }

                $event->setSummary($eventData['name']);

                $description = '';
                if (!empty($eventData['event_detail'])) {
                    $description .= 'Event Detail: ' . $eventData['event_detail'] . "\n";
                }
                if (!empty($eventData['location'])) {
                    $description .= 'Location: ' . $eventData['location'] . "\n";
                }
                if (!empty($eventData['address'])) {
                    $description .= 'Address: ' . $eventData['address'] . "\n";
                }
                if (!empty($eventData['contact_number'])) {
                    $description .= 'Contact: ' . $eventData['contact_number'] . "\n";
                }
                if (!empty($eventData['remark'])) {
                    $description .= 'Remarks: ' . $eventData['remark'];
                }
                $event->setDescription($description);

                $location = '';
                if (!empty($eventData['venue_city'])) {
                    $location .= $eventData['venue_city'];
                }
                if (!empty($eventData['address'])) {
                    $location .= ($location ? ', ' : '') . $eventData['address'];
                }
                if ($location) {
                    $event->setLocation($location);
                }

                $time = !empty($eventData['time']) ? $eventData['time'] : '09:00:00';
                if (strlen($time) == 5) {
                    $time .= ':00';
                }
                $startDateTime = $eventData['program_date'] . 'T' . $time;
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime($startDateTime);
                $start->setTimeZone('Asia/Kolkata');
                $event->setStart($start);

                $duration = !empty($eventData['tentative_duration']) ? (int)$eventData['tentative_duration'] : 1;
                $endDateTime = date('Y-m-d\TH:i:s', strtotime($startDateTime . ' +' . $duration . ' hours'));
                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime($endDateTime);
                $end->setTimeZone('Asia/Kolkata');
                $event->setEnd($end);

                if ($targetGoogleId) {
                    $updatedEvent = $this->service->events->update($calendarId, $targetGoogleId, $event);
                    $resultIds[] = $updatedEvent->getId();
                    log_message('info', 'Google Calendar updateEvent success: updated event ' . $targetGoogleId . ' in calendar ' . $calendarId);
                } else {
                    $createdEvent = $this->service->events->insert($calendarId, $event);
                    $resultIds[] = $createdEvent->getId();
                    log_message('info', 'Google Calendar updateEvent created event ' . $createdEvent->getId() . ' in calendar ' . $calendarId);
                }
            } catch (Exception $e) {
                log_message('error', 'Google Calendar update event error for calendar ' . $calendarId . ': ' . $e->getMessage());
            }
        }

        return !empty($resultIds) ? $resultIds : false;
    }
    
    /**
     * Delete event(s) from all configured calendars.
     */
    public function deleteEvent($googleEventIds) {
        if (!$this->service) {
            if (!$this->setAccessTokenFromRefresh()) {
                return false;
            }
        }

        $calendarIds = $this->getCalendarIds();
        $ids = [];

        if (is_string($googleEventIds)) {
            $ids = array_filter(array_map('trim', explode(',', $googleEventIds)));
        } elseif (is_array($googleEventIds)) {
            $ids = array_filter(array_map('trim', $googleEventIds));
        }

        $atLeastOne = false;

        foreach ($calendarIds as $index => $calendarId) {
            $targetGoogleId = isset($ids[$index]) ? $ids[$index] : null;
            if (!$targetGoogleId) {
                continue;
            }

            try {
                log_message('info', 'Google Calendar deleteEvent starting for googleEventId: ' . $targetGoogleId . ' on calendar ' . $calendarId);
                $this->service->events->delete($calendarId, $targetGoogleId);
                log_message('info', 'Google Calendar deleteEvent success: deleted event ' . $targetGoogleId . ' from calendar ' . $calendarId);
                $atLeastOne = true;
            } catch (Exception $e) {
                log_message('error', 'Google Calendar delete event error for calendar ' . $calendarId . ': ' . $e->getMessage());
            }
        }

        return $atLeastOne;
    }
    
    /**
     * Bind operations to a specific user ID (default: system admin user). 
     */
    public function setUserId($userId) {
        $this->boundUserId = (int)$userId;
        return $this;
    }

    /**
     * Save refresh token to database (per-user if provided, otherwise admin user)
     */
    private function saveRefreshToken($refreshToken, $userId = null) {
        if ($userId === null) {
            $userId = $this->boundUserId ?: 1;
        }

        $data = array(
            'google_refresh_token' => $refreshToken,
            'google_calendar_enabled' => 1
        );

        $this->ci->db->where('userId', $userId);
        $this->ci->db->where('isDeleted', 0);
        $this->ci->db->limit(1);
        $this->ci->db->update('tbl_users', $data);
    }
    
    /**
     * Get refresh token from database (per-user if provided, otherwise admin user)
     */
    private function getRefreshToken($userId = null) {
        if ($userId === null) {
            $userId = $this->boundUserId ?: 1;
        }

        $this->ci->db->select('google_refresh_token');
        $this->ci->db->where('userId', $userId);
        $this->ci->db->where('isDeleted', 0);
        $this->ci->db->limit(1);
        $query = $this->ci->db->get('tbl_users');
        $result = $query->row();
        return $result ? $result->google_refresh_token : null;
    }
    
    /**
     * Get calendar IDs from config (comma-separated) or ['primary'] if empty
     */
    private function getCalendarIds() {
        $calendarEmail = trim($this->ci->config->item('google_calendar_email'));
        if (empty($calendarEmail)) {
            return ['primary'];
        }

        $calendars = array_map('trim', explode(',', $calendarEmail));
        $calendars = array_filter($calendars);

        return !empty($calendars) ? $calendars : ['primary'];
    }

    /**
     * Get first calendar ID string (legacy compatibility)
     */
    private function getCalendarId() {
        $calendarIds = $this->getCalendarIds();
        return reset($calendarIds);
    }
}

