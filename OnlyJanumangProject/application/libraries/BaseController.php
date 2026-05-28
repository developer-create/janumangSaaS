<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

 
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $isAdmin = 0;
	protected $accessInfo = [];
	protected $global = array ();
	protected $lastLogin = '';
	protected $module = '';

 
	public function __construct() {
		parent::__construct();
	}
 
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->role = $this->session->userdata ( 'role' );
			$this->vendorId = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			$this->lastLogin = $this->session->userdata ( 'lastLogin' );
			$this->isAdmin = $this->session->userdata ( 'isAdmin' );
			$this->accessInfo = $this->session->userdata ( 'accessInfo' );
			
			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
			$this->global ['last_login'] = $this->lastLogin;
			$this->global ['is_admin'] = $this->isAdmin;
			$this->global ['access_info'] = $this->accessInfo;
			
			// Add pending approvals count for admin users
			if ($this->role == 1) {
				$this->load->model('Events_model');
				$this->global['pending_approvals_count'] = $this->Events_model->get_pending_count();
			} else {
				$this->global['pending_approvals_count'] = 0;
			}
		}
	}
	
 
	function isAdmin() {
		// Check if user has admin role (roleId == 1) - only admin role gets all permissions
		if ($this->role == 1) {
			return true;
		} else {
			return false;
		}
	}

 
	protected function hasListAccess() {
		// Admin role (roleId == 1) has all permissions
		if ($this->isAdmin()) {
			return true;
		}
		// Check access matrix for non-admin users - safely check array structure
		if (!empty($this->accessInfo) && is_array($this->accessInfo) && array_key_exists($this->module, $this->accessInfo)) {
			$moduleAccess = $this->accessInfo[$this->module];
			if (is_array($moduleAccess) && 
				((isset($moduleAccess['list']) && $moduleAccess['list'] == 1) 
				|| (isset($moduleAccess['total_access']) && $moduleAccess['total_access'] == 1))) {
				return true;
			}
		}
		return false;
	}

	 
	protected function hasCreateAccess() {
		// Admin role (roleId == 1) has all permissions
		if ($this->isAdmin()) {
			return true;
		}
		// Check access matrix for non-admin users - safely check array structure
		if (!empty($this->accessInfo) && is_array($this->accessInfo) && array_key_exists($this->module, $this->accessInfo)) {
			$moduleAccess = $this->accessInfo[$this->module];
			if (is_array($moduleAccess) && 
				((isset($moduleAccess['create_records']) && $moduleAccess['create_records'] == 1) 
				|| (isset($moduleAccess['total_access']) && $moduleAccess['total_access'] == 1))) {
				return true;
			}
		}
		return false;
	}

 
	protected function hasUpdateAccess() {
		// Admin role (roleId == 1) has all permissions
		if ($this->isAdmin()) {
			return true;
		}
		// Check access matrix for non-admin users - safely check array structure
		if (!empty($this->accessInfo) && is_array($this->accessInfo) && array_key_exists($this->module, $this->accessInfo)) {
			$moduleAccess = $this->accessInfo[$this->module];
			if (is_array($moduleAccess) && 
				((isset($moduleAccess['edit_records']) && $moduleAccess['edit_records'] == 1) 
				|| (isset($moduleAccess['total_access']) && $moduleAccess['total_access'] == 1))) {
				return true;
			}
		}
		return false;
	}

 
	protected function hasDeleteAccess() {
		// Admin role (roleId == 1) has all permissions
		if ($this->isAdmin()) {
			return true;
		}
		// Check access matrix for non-admin users - safely check array structure
		if (!empty($this->accessInfo) && is_array($this->accessInfo) && array_key_exists($this->module, $this->accessInfo)) {
			$moduleAccess = $this->accessInfo[$this->module];
			if (is_array($moduleAccess) && 
				((isset($moduleAccess['delete_records']) && $moduleAccess['delete_records'] == 1) 
				|| (isset($moduleAccess['total_access']) && $moduleAccess['total_access'] == 1))) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if user has Events-Approval permission
	 */
	protected function hasApprovalAccess() {
		// Admin role (roleId == 1) has all permissions
		if ($this->isAdmin()) {
			return true;
		}
		// Check access matrix for Events-Approval module
		if (!empty($this->accessInfo) && is_array($this->accessInfo) && array_key_exists('Events-Approval', $this->accessInfo)) {
			$moduleAccess = $this->accessInfo['Events-Approval'];
			if (is_array($moduleAccess) && 
				((isset($moduleAccess['list']) && $moduleAccess['list'] == 1) 
				|| (isset($moduleAccess['total_access']) && $moduleAccess['total_access'] == 1))) {
				return true;
			}
		}
		return false;
	}

 
	function loadThis() {
		$this->global ['pageTitle'] = 'CodeInsect : Access Denied';
		
		$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'general/access' );
		$this->load->view ( 'includes/footer' );
	}
	 
	function logout() {
		// Log logout activity before destroying session
		$userId = $this->session->userdata('userId');
		$userName = $this->session->userdata('name');
		
		if ($userId) {
			if (!isset($this->Log_model)) {
				$this->load->model('Log_model');
			}
			$this->Log_model->log_activity(
				'logout',
				'Login',
				'tbl_user',
				$userId,
				null,
				null,
				'User logged out successfully (Name: ' . $userName . ')',
				$userId,
				$userName
			);
		}
		
		$this->session->sess_destroy ();
		redirect ( 'login' );
	}

 
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }
	
 
	function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = $segment;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( $segment );
	
		return array (
			"page" => $page,
			"segment" => $segment
		);
	}
	
	/**
	 * Helper method to log user activity
	 * This method can be called from any controller that extends BaseController
	 * 
	 * @param string $action - Action type: 'add', 'edit', 'delete', 'download', 'view'
	 * @param string $table_name - Database table name
	 * @param int $record_id - ID of the affected record
	 * @param array $record_data - Current record data (for add/edit)
	 * @param array $old_data - Old record data (for edit, to show what changed)
	 * @param string $details - Additional details about the action
	 */
	protected function logActivity($action, $table_name = null, $record_id = null, $record_data = null, $old_data = null, $details = null) {
		// Load Log_model if not already loaded
		if (!isset($this->Log_model)) {
			$this->load->model('Log_model');
		}
		
		// Use current module name, or try to get from class name
		$module = $this->module;
		if (empty($module)) {
			$module = str_replace('Controller', '', get_class($this));
		}
		
		// Call the model's log_activity method
		$this->Log_model->log_activity(
			$action,
			$module,
			$table_name,
			$record_id,
			$record_data,
			$old_data,
			$details,
			$this->vendorId,
			$this->name
		);
	}
}