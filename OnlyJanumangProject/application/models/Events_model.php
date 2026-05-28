<?php
class Events_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all events
 public function get_events() {
    $blockid = $this->session->userdata('blockId');
    $accessInfo = $this->session->userdata('accessInfo');
    $userId = $this->session->userdata('userId');
    $roleId = $this->session->userdata('role');
    
    // Check if user has total_access or list permission for Events
    $hasFullAccess = false;
    $isAdmin = ($roleId == 1); // Admin role
    
    if (!empty($accessInfo) && is_array($accessInfo)) {
        if (isset($accessInfo['Events'])) {
            $eventsAccess = $accessInfo['Events'];
            if ((isset($eventsAccess['total_access']) && $eventsAccess['total_access'] == 1) ||
                (isset($eventsAccess['list']) && $eventsAccess['list'] == 1)) {
                // Check if user has total_access (not just list)
                if (isset($eventsAccess['total_access']) && $eventsAccess['total_access'] == 1) {
                    $hasFullAccess = true;
                }
            }
        }
    }

    // If user doesn't have full access and has a blockId, filter by block
    if (!$hasFullAccess && $blockid != 0) {
        // Convert the comma-separated string into an array
        $blockid_array = explode(',', $blockid);

        // Apply the where_in condition before executing the query
        $this->db->where_in('block', $blockid_array);
    }
    
    // Status filter: Admin sees all, others see only approved events
    if ($isAdmin) {
        // Admin sees all events (pending, approved, rejected)
        // No status filter
    } else {
        // Non-admin users see ONLY approved events
        // Pending events are hidden until admin approves them
        $this->db->where('status', 'approved');
    }

    // Order by ID descending to show newest first
    $this->db->order_by('id', 'DESC');

    // Now get the results after applying conditions
    $query = $this->db->get('events');

    return $query->result_array();
}


    // Get a single event by ID
    public function get_event($id) {
        $query = $this->db->get_where('events', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new event
    public function create_event($data) {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }
    
    // Update Google Calendar event ID
    public function update_google_event_id($eventId, $googleEventId) {
        $this->db->where('id', $eventId);
        return $this->db->update('events', array('google_event_id' => $googleEventId));
    }
    
    // Get Google event ID
    public function get_google_event_id($eventId) {
        $query = $this->db->get_where('events', array('id' => $eventId));
        $result = $query->row_array();
        return $result ? (isset($result['google_event_id']) ? $result['google_event_id'] : null) : null;
    }

    // Update a event
    public function update_event($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('events', $data);
    }

    // Delete a event
    public function delete_event($id) {
        return $this->db->delete('events', array('id' => $id));
    }
    
    // Approve event
    public function approve_event($id, $adminId) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('events', $data);
    }
    
    // Reject event
    public function reject_event($id, $adminId, $reason = '') {
        $data = array(
            'status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => date('Y-m-d H:i:s'),
            'rejection_reason' => $reason
        );
        $this->db->where('id', $id);
        return $this->db->update('events', $data);
    }
    
    // Get pending events count for admin
    public function get_pending_count() {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('events');
    }
    
    // Create notification for admins
    public function create_notification($eventId) {
        // Get all admin users (roleId = 1)
        $this->db->select('userId');
        $this->db->from('tbl_users');
        $this->db->where('roleId', 1);
        $this->db->where('isDeleted', 0);
        $admins = $this->db->get()->result();
        
        // Insert notification for each admin
        foreach ($admins as $admin) {
            $notification = array(
                'event_id' => $eventId,
                'user_id' => $admin->userId,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('event_notifications', $notification);
        }
    }
    
    // Get unread notifications count for user
    public function get_unread_notifications_count($userId) {
        $this->db->where('user_id', $userId);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('event_notifications');
    }
    
    // Mark notification as read
    public function mark_notification_read($eventId, $userId) {
        $this->db->where('event_id', $eventId);
        $this->db->where('user_id', $userId);
        return $this->db->update('event_notifications', array('is_read' => 1));
    }
}
?>
