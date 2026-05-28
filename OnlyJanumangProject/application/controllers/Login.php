<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

#[AllowDynamicProperties]
class Login extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');  
        $this->load->model('Log_model');

    }

    
    public function index()
    {
        $this->isLoggedIn();
    }
    
    
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/login');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);

            //pre($result); die;
            
            if (!empty($result))
            {
                if ($result->isAdmin != SYSTEM_ADMIN && ($result->roleStatus == 2 || $result->isRoleDeleted == 1))
                {
                    $this->session->set_flashdata('error', 'The user doesn\'t have any role or the role is deactivated');
                    redirect('login');
                }

                $lastLogin = $this->login_model->lastLoginInfo($result->userId);

                $accessInfo = $this->accessInfo($result->roleId);

                $sessionArray = array(
                    
                                        'userId'=>$result->userId,
                                        'role'=>$result->roleId,
                                        'blockId'=>$result->blockId,
                                        'roleText'=>$result->role,
                                        'name'=>$result->name,
                                        'isAdmin'=>$result->isAdmin,
                                        'accessInfo'=>$accessInfo,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata($sessionArray);

                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin'], $sessionArray['accessInfo']);

                $loginInfo = array("userId"=>$result->userId, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
                 $this->login_model->lastLogin($loginInfo);
                
                // Log login activity using the new system
                $this->load->model('Log_model');
                $this->Log_model->log_activity(
                    'login',
                    'Authentication',
                    'tbl_users',
                    $result->userId,
                    $loginInfo,
                    null,
                    'User logged in successfully (Email: ' . $email . ', Name: ' . $result->name . ')',
                    $result->userId,
                    $result->name
                );
                
                // Start session tracking
                $this->Log_model->start_user_session($result->userId, $result->name, session_id());


                if ($result->isAdmin != 1) {
                redirect('/blockdashboard');
                } else {
                redirect('/dashboard');
                }

                
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                redirect('login');
            }
        }
    }

    
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo->name;
                        $data1["email"] = $userInfo->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('users/newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = strtolower($this->input->post("email"));
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password reset successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password reset failed';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }

    private function accessInfo($roleId)
    {
        $finalMatrixArray = [];
        $matrix = $this->login_model->getRoleAccessMatrix($roleId);
        
        if(!empty($matrix) && !empty($matrix->access)) {
            // Decode JSON as associative array for better compatibility
            $accessMatrix = json_decode($matrix->access, true);
            
            // If decode failed, try without associative flag (for objects)
            if (json_last_error() !== JSON_ERROR_NONE) {
                $accessMatrix = json_decode($matrix->access);
                if (is_array($accessMatrix) || is_object($accessMatrix)) {
                    foreach($accessMatrix as $moduleMatrix) {
                        $moduleArray = is_array($moduleMatrix) ? $moduleMatrix : (array) $moduleMatrix;
                        if (isset($moduleArray['module'])) {
                            $finalMatrixArray[$moduleArray['module']] = $moduleArray;
                        }
                    }
                }
            } else {
                // Successfully decoded as associative array
                if (is_array($accessMatrix)) {
                    foreach($accessMatrix as $moduleMatrix) {
                        if (isset($moduleMatrix['module']) && is_array($moduleMatrix)) {
                            $finalMatrixArray[$moduleMatrix['module']] = $moduleMatrix;
                        }
                    }
                }
            }
        }
        
        return $finalMatrixArray;
    }
}

?>