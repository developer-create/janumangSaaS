<?php
require APPPATH . '/libraries/BaseController.php';

class Events extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Events_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Events';
    }

    // Display all visitors
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['events'] = $this->Events_model->get_events();
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            
            // Load districts for display
            $this->load->model('District_model');
            $data['districts'] = $this->District_model->get_districts();
            
            $this->global['pageTitle'] = 'Datacollector : Events';
            $this->loadViews("events/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new visitor
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Events';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            
            // Load districts
            $this->load->model('District_model');
            $data['districts'] = $this->District_model->get_districts();
            
            $this->loadViews("events/create", $this->global, $data, NULL);
        }
    }

    // Insert a new visitor
    // public function store() {
    //     if (!$this->hasCreateAccess()) {
    //         $this->loadThis(); // Redirect to the unauthorized access page
    //     } else {
    //         $data = array(
    //             'year' => $this->input->post('year'),
                
    //             'event_type' => $this->input->post('event_type'),
    //             'month' => $this->input->post('month'),
                
    //             'time' => $this->input->post('time'),
    //             'district' => $this->input->post('district'),
    //             'priority' => $this->input->post('priority'),
    //             'venue_city' => $this->input->post('venue_city'),
    //             'referance' => $this->input->post('referance'),
    //           'date' => date('Y-m-d', strtotime($this->input->post('date'))),
    //           'program_date' => date('Y-m-d', strtotime($this->input->post('program_date'))),
    //             'contact_number' => $this->input->post('contact_number'),
    //             'address' => $this->input->post('address'),
    //             'name' => $this->input->post('name'),
    //             'location' => $this->input->post('location'),
    //             'probability' => $this->input->post('probability'),
    //             'tentative_duration' => $this->input->post('tentative_duration'),
    //             'attended' => $this->input->post('attended'),
    //             'dispatch_date' => date('Y-m-d', strtotime($this->input->post('dispatch_date'))),
    //             'dispatch_number' => $this->input->post('dispatch_number'),
    //             'remark' => $this->input->post('remark'),
    //             'created_by' => $this->vendorId,
    //         );
    //         $id = $this->Events_model->create_event($data);
    //         $this->Log_model->log_action('create_event', 'events', $id, $data);
    //         redirect('events');
    //     }
    // }
public function store() {
    if (!$this->hasCreateAccess()) {
        $this->loadThis(); // Redirect to the unauthorized access page
    } else {
        // Custom validation for "Other" district only
        if ($this->input->post('district') === 'other') {
            $this->form_validation->set_rules('other_district_name', 'District Name', 'required|min_length[2]');
            
            if ($this->form_validation->run() == FALSE) {
                // Validation failed, reload create page with errors
                $this->create();
                return;
            }
        }
        
        $dispatch_date = $this->input->post('dispatch_date');
        $dispatch_date = !empty($dispatch_date) ? date('Y-m-d', strtotime($dispatch_date)) : NULL;

        // Generate unique ID
        $unique_id = $this->generateUniqueId();

        // Day, Month, Year from Program Date (not Received Date)
        $program_date = $this->input->post('program_date');
        $program_ts = !empty($program_date) ? strtotime($program_date) : null;
        $day = $program_ts ? date('l', $program_ts) : $this->input->post('day');
        $month = $program_ts ? date('F', $program_ts) : $this->input->post('month');
        $year = $program_ts ? date('Y', $program_ts) : $this->input->post('year');

        // Handle district - if "other" is selected, use the custom input
        $district = $this->input->post('district');
        if ($district === 'other') {
            $district = $this->input->post('other_district_name') ?: 'NA';
        }
        
        // Check if user is admin - admin events are auto-approved
        $isAdmin = ($this->role == 1);
        $status = $isAdmin ? 'approved' : 'pending';

        $data = array(
            'unique_id' => $unique_id,
            'year' => $year ?: 'NA',
            'day' => $day ?: 'NA',
            'block' => $this->input->post('block') ?: 'NA',
            'event_type' => $this->input->post('event_type') ?: 'NA',
            'month' => $month ?: 'NA',
            'time' => $this->input->post('time') ?: 'NA',
            'event_detail' => $this->input->post('event_detail') ?: 'NA',
            'district' => $district,
            'priority' => $this->input->post('priority') ?: 'NA',
            'venue_city' => $this->input->post('venue_city') ?: 'NA',
            'referance' => $this->input->post('referance') ?: 'NA',
            'date' => !empty($this->input->post('date')) ? date('Y-m-d', strtotime($this->input->post('date'))) : '0000-00-00',
            'program_date' => !empty($this->input->post('program_date')) ? date('Y-m-d', strtotime($this->input->post('program_date'))) : '0000-00-00',
            'contact_number' => $this->input->post('contact_number') ?: 'NA',
            'address' => $this->input->post('address') ?: 'NA',
            'name' => $this->input->post('name') ?: 'NA',
            'location' => $this->input->post('location') ?: 'NA',
            'probability' => $this->input->post('probability') ?: 'NA',
            'tentative_duration' => $this->input->post('tentative_duration') ?: 'NA',
            'attended' => $this->input->post('attended') ?: 'YES',
            'press' => $this->input->post('press') ?: 'NA',
            'dispatch_date' => $dispatch_date ?: '0000-00-00',
            'dispatch_number' => $this->input->post('dispatch_number') ?: 'NA',
            'remark' => $this->input->post('remark') ?: 'NA',
            'office' => $this->input->post('office') ?: 'NA',
            'status' => $status,
            'created_by' => $this->vendorId,
        );

        $id = $this->Events_model->create_event($data);
        if ($id) {
            // Log activity
            $this->logActivity('add', 'events', $id, $data, null, 'Event created with ID: ' . $id . ' (Name: ' . $data['name'] . ', Status: ' . $status . ')');
            
            // If event is pending, create notification for admins
            if ($status == 'pending') {
                $this->Events_model->create_notification($id);
                $this->session->set_flashdata('success', 'Event created successfully and sent for approval.');
            } else {
                $this->session->set_flashdata('success', 'Event created successfully.');
                
                // Sync with Google Calendar only if approved (admin created)
                $syncStatus = $this->syncToGoogleCalendar($id, $data);
                
                // Store sync result in session for feedback
                if ($syncStatus) {
                    $this->session->set_flashdata('gcal_sync_success', 'Google Calendar synchronized successfully for event: ' . $data['name']);
                } else {
                    $this->session->set_flashdata('gcal_sync_warning', 'Event created but Google Calendar sync could not be verified.');
                }
            }
        }
        redirect('events');
    }
}

    // Show a form to edit a visitor
    public function edit($id) {
        
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['event'] = $this->Events_model->get_event($id);
            
            // Trim and prepare event data for dropdown comparison
            if($data['event']) {
                $data['event']['event_type'] = trim($data['event']['event_type'] ?? '');
                $data['event']['month'] = trim($data['event']['month'] ?? '');
                $data['event']['priority'] = trim($data['event']['priority'] ?? '');
                $data['event']['probability'] = trim($data['event']['probability'] ?? '');
                $data['event']['attended'] = trim($data['event']['attended'] ?? '');
                $data['event']['block'] = !empty($data['event']['block']) ? (int)$data['event']['block'] : '';
                // Day, Month, Year should always come from Program Date (not Received Date)
                if (!empty($data['event']['program_date'])) {
                    $progTs = strtotime($data['event']['program_date']);
                    $data['event']['day'] = date('l', $progTs);
                    $data['event']['month'] = date('F', $progTs);
                    $data['event']['year'] = date('Y', $progTs);
                }
            }
            
            $this->global['pageTitle'] = 'Datacollector : Edit Events';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            
            // Load districts
            $this->load->model('District_model');
            $data['districts'] = $this->District_model->get_districts();
            
            $this->loadViews("events/edit", $this->global, $data, NULL);
        }
    }

    // Update a visitor
    // public function update($id) {
    //     if (!$this->hasUpdateAccess()) {
    //         $this->loadThis(); // Redirect to the unauthorized access page
    //     } else {
    //         $data = array(
    //             'year' => $this->input->post('year'),
                
    //             'event_type' => $this->input->post('event_type'),
    //             'month' => $this->input->post('month'),
                
    //             'time' => $this->input->post('time'),
    //             'district' => $this->input->post('district'),
    //             'priority' => $this->input->post('priority'),
    //             'venue_city' => $this->input->post('venue_city'),
    //             'referance' => $this->input->post('referance'),
    //           'date' => date('Y-m-d', strtotime($this->input->post('date'))),
    //           'program_date' => date('Y-m-d', strtotime($this->input->post('program_date'))),
    //             'contact_number' => $this->input->post('contact_number'),
    //             'address' => $this->input->post('address'),
    //             'name' => $this->input->post('name'),
    //             'location' => $this->input->post('location'),
    //             'probability' => $this->input->post('probability'),
    //             'tentative_duration' => $this->input->post('tentative_duration'),
    //             'attended' => $this->input->post('attended'),
    //             'dispatch_date' => date('Y-m-d', strtotime($this->input->post('dispatch_date'))),
    //             'dispatch_number' => $this->input->post('dispatch_number'),
    //             'remark' => $this->input->post('remark'),
               
    //             'updated_by' => $this->vendorId,
    //         );
    //         $this->Events_model->update_event($id, $data);
    //         $this->Log_model->log_action('update_event', 'events', $id, $data);
    //         redirect('events');
    //     }
    // }
public function update($id) {
    if (!$this->hasUpdateAccess()) {
        $this->loadThis(); // Redirect to the unauthorized access page
    } else {
        $dispatch_date = $this->input->post('dispatch_date');
        $dispatch_date = !empty($dispatch_date) ? date('Y-m-d', strtotime($dispatch_date)) : NULL;

        // Day, Month, Year from Program Date (not Received Date)
        $program_date = $this->input->post('program_date');
        $program_ts = !empty($program_date) ? strtotime($program_date) : null;
        $day = $program_ts ? date('l', $program_ts) : $this->input->post('day');
        $month = $program_ts ? date('F', $program_ts) : $this->input->post('month');
        $year = $program_ts ? date('Y', $program_ts) : $this->input->post('year');

        // Handle district - if "other" is selected, use the custom input
        $district = $this->input->post('district');
        if ($district === 'other') {
            $district = $this->input->post('other_district_name') ?: 'NA';
        }

        $data = array(
            'year' => $year,
            'day' => $day,
            'event_type' => $this->input->post('event_type'),
            'month' => $month,
            'time' => $this->input->post('time'),
            'district' => $district,
            'event_detail' => $this->input->post('event_detail'),
            'priority' => $this->input->post('priority'),
            'venue_city' => $this->input->post('venue_city'),
            'referance' => $this->input->post('referance'),
            'date' => date('Y-m-d', strtotime($this->input->post('date'))),
            'program_date' => date('Y-m-d', strtotime($this->input->post('program_date'))),
            'contact_number' => $this->input->post('contact_number'),
            'address' => $this->input->post('address'),
            'name' => $this->input->post('name'),
            'location' => $this->input->post('location'),
            'probability' => $this->input->post('probability'),
            'tentative_duration' => $this->input->post('tentative_duration'),
            'attended' => $this->input->post('attended'),
            'press' => $this->input->post('press'),
            'dispatch_date' => $dispatch_date, // Set to NULL if not selected
            'dispatch_number' => $this->input->post('dispatch_number'),
            'remark' => $this->input->post('remark'),
            'office' => $this->input->post('office'),
            'updated_by' => $this->vendorId,
             'block' => $this->input->post('block'),
        );

        // Get old data before update for logging
        $oldData = $this->Events_model->get_event($id);

        $this->Events_model->update_event($id, $data);
        
        // Log activity with old and new data
        $this->logActivity('edit', 'events', $id, $data, $oldData, 'Event updated with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
        
        // Sync with Google Calendar if enabled and capture status
        $syncStatus = $this->syncToGoogleCalendar($id, $data, 'update');
        
        if ($syncStatus['success']) {
            $this->session->set_flashdata('gcal_sync_success', 'Event updated and synchronized with Google Calendar: ' . $data['name']);
        } elseif ($syncStatus['status'] == 'NO_CALENDAR_CONFIGURED') {
            $this->session->set_flashdata('gcal_sync_warning', 'Event updated but Google Calendar sync is not configured.');
        }
        
        redirect('events');
    }
}

    // Delete a visitor
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get data before delete for logging
            $eventData = $this->Events_model->get_event($id);
            
            // Delete from Google Calendar if synced
            $this->syncToGoogleCalendar($id, null, 'delete');
            
            $this->Events_model->delete_event($id);
            
            // Log activity
            $this->logActivity('delete', 'events', $id, $eventData, null, 'Event deleted with ID: ' . $id . ' (Name: ' . (!empty($eventData->name) ? $eventData->name : 'N/A') . ')');
            
            redirect('events');
        }
    }
    
    /**
     * Connect to Google Calendar (OAuth) - System-wide connection
     * Only admin users can connect
     */
    public function connect_google_calendar() {
        // if (!$this->hasCreateAccess()) {
        //     $this->loadThis();
        //     return;
        // }

        $connectUserId = $this->vendorId;

        try {
            $this->load->library('GoogleCalendar');

            // Check if library initialized properly
            // if (!isset($this->googlecalendar) || !is_object($this->googlecalendar)) {
            //     $this->session->set_flashdata('error', 'Google Calendar library failed to initialize. Please ensure Google API PHP Client library is installed. See GOOGLE_CALENDAR_SETUP.md for installation instructions.');
            //     redirect('events');
            //     return;
            // }

            $this->googlecalendar->setUserId($connectUserId);
            $this->session->set_userdata('google_calendar_connect_user_id', $connectUserId);

            $authUrl = $this->googlecalendar->getAuthUrl();
            if ($authUrl) {
                redirect($authUrl);
            } else {
                $this->session->set_flashdata('error', 'Failed to generate Google Calendar authorization URL. Please check your configuration.');
                redirect('events');
            }
        } catch (Exception $e) {
           echo $errorMsg = 'Error connecting to Google Calendar: ' . $e->getMessage();
            if (strpos($e->getMessage(), 'not initialized') !== false) {
          echo      $errorMsg .= ' Please install Google API PHP Client library. See GOOGLE_CALENDAR_SETUP.md for instructions.';
            }
            $this->session->set_flashdata('error', $errorMsg);
          //  redirect('events');
        }
    }
    
    /**
     * Google Calendar OAuth callback - System-wide connection
     */
    public function google_calendar_callback() {
        $code = $this->input->get('code');
        $connectUserId = $this->session->userdata('google_calendar_connect_user_id') ?: $this->vendorId;

        if ($code) {
            $this->load->library('GoogleCalendar');
            $this->googlecalendar->setUserId($connectUserId);
            $token = $this->googlecalendar->authenticate($code);

            if ($token) {
                $this->session->set_flashdata('success', 'Successfully connected to Google Calendar! All events will now sync to the configured calendar.');
            } else {
                $this->session->set_flashdata('error', 'Failed to connect to Google Calendar. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error', 'Google Calendar authorization failed.');
        }

        $this->session->unset_userdata('google_calendar_connect_user_id');
        redirect('events');
    }
    
    /**
     * Disconnect Google Calendar - System-wide disconnection
     * Only admin users can disconnect
     */
    public function disconnect_google_calendar() {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
            return;
        }

        $userId = $this->vendorId;

        // Disconnect user-specific calendar
        $data = array(
            'google_refresh_token' => null,
            'google_calendar_enabled' => 0
        );
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->limit(1);
        $this->db->update('tbl_users', $data);

        $this->session->set_flashdata('success', 'Google Calendar disconnected successfully. All events will stop syncing for your account.');
        redirect('events');
    }
    
    /**
     * Generate unique ID for events
     */
    private function generateUniqueId() {
        // Get the latest unique_id from database
        $last_record = $this->db->select('unique_id')
                               ->from('events')
                               ->where('unique_id IS NOT NULL')
                               ->order_by('id', 'DESC')
                               ->limit(1)
                               ->get()
                               ->row();
        
        if ($last_record && $last_record->unique_id) {
            // Extract number from ET/X format
            $parts = explode('/', $last_record->unique_id);
            if (count($parts) == 2 && $parts[0] == 'ET') {
                $next_number = intval($parts[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }
        
        return 'ET/' . $next_number;
    }

    /**
     * Sync event to Google Calendar with verification
     * @return array Status array with sync success status and details
     */
    private function syncToGoogleCalendar($eventId, $eventData, $action = 'create') {
        $syncResult = [
            'success' => false,
            'verified' => false,
            'googleEventId' => null,
            'status' => 'NOT_SYNCED',
            'message' => ''
        ];
        
        // Determine event owner / user for per-user Google sync
        if ($eventData === null) {
            $eventData = $this->Events_model->get_event($eventId);
            if (!$eventData) {
                $syncResult['message'] = 'Event not found';
                log_message('error', 'Google Calendar sync failed: event not found, eventId=' . $eventId);
                return $syncResult;
            }
        }

        $eventOwnerId = isset($eventData['created_by']) ? $eventData['created_by'] : $this->vendorId;
        $calendarUser = $this->db->select('userId, name, google_calendar_enabled, google_refresh_token')->from('tbl_users')->where('userId', $eventOwnerId)->where('isDeleted', 0)->get()->row();

        if (!$calendarUser || !$calendarUser->google_calendar_enabled || empty($calendarUser->google_refresh_token)) {
            // Fallback to system-wide admin
            $calendarUser = $this->db->select('userId, name, google_calendar_enabled, google_refresh_token')->from('tbl_users')->where('roleId', 1)->where('isDeleted', 0)->get()->row();

            if (!$calendarUser || !$calendarUser->google_calendar_enabled || empty($calendarUser->google_refresh_token)) {
                $syncResult['message'] = 'No enabled calendar connection found';
                $syncResult['status'] = 'NO_CALENDAR_CONFIGURED';
                log_message('info', 'Google Calendar sync skipped: no enabled calendar connection found for eventId=' . $eventId . ', action=' . $action . ', ownerId=' . $eventOwnerId);
                return $syncResult;
            }
        }

        log_message('info', 'Google Calendar sync starting: eventId=' . $eventId . ', action=' . $action . ', calendarUserId=' . $calendarUser->userId);

        $this->load->library('GoogleCalendar');
        $this->googlecalendar->setUserId($calendarUser->userId);

        if (!$this->googlecalendar->setAccessTokenFromRefresh(null, $calendarUser->userId)) {
            $syncResult['message'] = 'Failed to refresh Google Calendar access token';
            $syncResult['status'] = 'TOKEN_REFRESH_FAILED';
            log_message('error', 'Google Calendar sync failed: could not refresh access token for userId=' . $calendarUser->userId . ', eventId=' . $eventId);
            return $syncResult;
        }

        try {
            if ($action == 'create') {
                $googleIds = $this->googlecalendar->createEvent($eventData);
                if ($googleIds) {
                    $savedIdString = is_array($googleIds) ? implode(',', $googleIds) : $googleIds;
                    $this->Events_model->update_google_event_id($eventId, $savedIdString);
                    $syncResult['success'] = true;
                    $syncResult['verified'] = true;
                    $syncResult['googleEventId'] = $savedIdString;
                    $syncResult['status'] = 'SYNCED';
                    $syncResult['message'] = 'Event created in Google Calendar';
                    log_message('info', 'Google Calendar sync success: created event, eventId=' . $eventId . ', googleEventIds=' . $savedIdString);
                } else {
                    $syncResult['message'] = 'Failed to create event in Google Calendar';
                    $syncResult['status'] = 'CREATE_FAILED';
                    log_message('error', 'Google Calendar sync failed: createEvent returned false for eventId=' . $eventId);
                }
            } elseif ($action == 'update') {
                $googleIdField = $this->Events_model->get_google_event_id($eventId);
                $googleIds = $this->googlecalendar->updateEvent($googleIdField, $eventData);

                if ($googleIds) {
                    $savedIdString = is_array($googleIds) ? implode(',', $googleIds) : $googleIds;
                    $this->Events_model->update_google_event_id($eventId, $savedIdString);
                    $syncResult['success'] = true;
                    $syncResult['verified'] = true;
                    $syncResult['googleEventId'] = $savedIdString;
                    $syncResult['status'] = 'SYNCED';
                    $syncResult['message'] = 'Event updated in Google Calendar';
                    log_message('info', 'Google Calendar sync success: updated event, eventId=' . $eventId . ', googleEventIds=' . $savedIdString);
                } else {
                    $googleIds = $this->googlecalendar->createEvent($eventData);
                    if ($googleIds) {
                        $savedIdString = is_array($googleIds) ? implode(',', $googleIds) : $googleIds;
                        $this->Events_model->update_google_event_id($eventId, $savedIdString);
                        $syncResult['success'] = true;
                        $syncResult['verified'] = true;
                        $syncResult['googleEventId'] = $savedIdString;
                        $syncResult['status'] = 'SYNCED';
                        $syncResult['message'] = 'Event created in Google Calendar';
                        log_message('info', 'Google Calendar sync success: created new event (no existing ID), eventId=' . $eventId . ', googleEventIds=' . $savedIdString);
                    } else {
                        $syncResult['message'] = 'Failed to create event in Google Calendar';
                        $syncResult['status'] = 'CREATE_FAILED';
                        log_message('error', 'Google Calendar sync failed: createEvent returned false for update action, eventId=' . $eventId);
                    }
                }
            } elseif ($action == 'delete') {
                $googleEventId = $this->Events_model->get_google_event_id($eventId);
                if ($googleEventId) {
                    $this->googlecalendar->deleteEvent($googleEventId);
                    $syncResult['success'] = true;
                    $syncResult['verified'] = true;
                    $syncResult['status'] = 'DELETED';
                    $syncResult['message'] = 'Event deleted from Google Calendar';
                    log_message('info', 'Google Calendar sync success: deleted event, eventId=' . $eventId . ', googleEventId=' . $googleEventId);
                } else {
                    $syncResult['success'] = true;
                    $syncResult['status'] = 'NOT_SYNCED';
                    $syncResult['message'] = 'No Google event found to delete';
                    log_message('info', 'Google Calendar sync skipped: no googleEventId found for delete, eventId=' . $eventId);
                }
            }
            
            return $syncResult;
        } catch (Exception $e) {
            $syncResult['message'] = 'Sync error: ' . $e->getMessage();
            $syncResult['status'] = 'ERROR';
            log_message('error', 'Google Calendar sync error: ' . $e->getMessage() . ', eventId=' . $eventId . ', action=' . $action);
            return $syncResult;
        }
    }
    
    /**
     * Check and verify Google Calendar sync status for an event
     */
    public function verify_sync($eventId = null) {
        if (!$eventId) {
            return json_encode(['error' => 'Event ID required']);
        }
        
        $event = $this->Events_model->get_event($eventId);
        if (!$event) {
            return json_encode(['error' => 'Event not found']);
        }
        
        // Check if Google event ID exists
        $googleEventId = isset($event['google_event_id']) ? $event['google_event_id'] : null;
        
        // Get event owner info
        $eventOwnerId = $event['created_by'];
        $calendarUser = $this->db->select('userId, name, email, google_calendar_enabled, google_refresh_token')
            ->from('tbl_users')
            ->where('userId', $eventOwnerId)
            ->where('isDeleted', 0)
            ->get()
            ->row();
        
        if (!$calendarUser) {
            // Fallback to admin
            $calendarUser = $this->db->select('userId, name, email, google_calendar_enabled, google_refresh_token')
                ->from('tbl_users')
                ->where('roleId', 1)
                ->where('isDeleted', 0)
                ->get()
                ->row();
        }
        
        $status = [
            'eventId' => $eventId,
            'eventName' => $event['name'],
            'googleEventId' => $googleEventId,
            'isSynced' => !empty($googleEventId),
            'calendarUser' => $calendarUser ? $calendarUser->name : 'None',
            'calendarEmail' => $calendarUser ? $calendarUser->email : 'None',
            'calendarEnabled' => $calendarUser ? (bool)$calendarUser->google_calendar_enabled : false,
            'tokenSet' => $calendarUser ? !empty($calendarUser->google_refresh_token) : false
        ];
        
        header('Content-Type: application/json');
        echo json_encode($status);
    }
    
    /**
     * Approve event (Admin only)
     */
    public function approve($id) {
        // Check if user has Events-Approval permission
        if (!$this->hasApprovalAccess()) {
            $this->session->set_flashdata('error', 'You do not have permission to approve events.');
            redirect('events');
            return;
        }
        
        $event = $this->Events_model->get_event($id);
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('events');
            return;
        }
        
        if ($event['status'] != 'pending') {
            $this->session->set_flashdata('error', 'Event is not pending approval.');
            redirect('events');
            return;
        }
        
        $result = $this->Events_model->approve_event($id, $this->vendorId);
        
        if ($result) {
            $this->Events_model->mark_notification_read($id, $this->vendorId);
            $this->logActivity('approve', 'events', $id, array('status' => 'approved'), array('status' => 'pending'), 'Event approved with ID: ' . $id);
            $this->session->set_flashdata('success', 'Event approved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve event.');
        }
        
        redirect('events/approvals');
    }
    
    /**
     * Approval page - Users with Events-Approval permission
     */
    public function approvals() {
        // Check if user has Events-Approval permission
        if (!$this->hasApprovalAccess()) {
            $this->session->set_flashdata('error', 'You do not have permission to access approval page.');
            redirect('events');
            return;
        }
        
        // Get pending events only
        $this->db->where('status', 'pending');
        $this->db->order_by('id', 'DESC');
        $data['pending_events'] = $this->db->get('events')->result_array();
        
        $query = $this->db->get('block');
        $data['blocks'] = $query->result();
        
        // Load districts for display
        $this->load->model('District_model');
        $data['districts'] = $this->District_model->get_districts();
        
        $this->global['pageTitle'] = 'Datacollector : Event Approvals';
        $this->loadViews("events/approvals", $this->global, $data, NULL);
    }
    
    /**
     * Reject event (Users with Events-Approval permission)
     */
    public function reject($id) {
        // Check if user has Events-Approval permission
        if (!$this->hasApprovalAccess()) {
            $this->session->set_flashdata('error', 'You do not have permission to reject events.');
            redirect('events');
            return;
        }
        
        $event = $this->Events_model->get_event($id);
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('events');
            return;
        }
        
        if ($event['status'] != 'pending') {
            $this->session->set_flashdata('error', 'Event is not pending approval.');
            redirect('events');
            return;
        }
        
        $reason = $this->input->post('rejection_reason') ?: 'No reason provided';
        $result = $this->Events_model->reject_event($id, $this->vendorId, $reason);
        
        if ($result) {
            $this->Events_model->mark_notification_read($id, $this->vendorId);
            $this->logActivity('reject', 'events', $id, array('status' => 'rejected', 'rejection_reason' => $reason), array('status' => 'pending'), 'Event rejected with ID: ' . $id);
            $this->session->set_flashdata('success', 'Event rejected successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject event.');
        }
        
        redirect('events/approvals');
    }

}
