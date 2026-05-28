<?php
#[AllowDynamicProperties]
class Api extends MY_Controller {
    
     public function __construct()
    {
        parent::__construct();
        ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
        
    }
        
        public function updateCurrentStage() 
    {
        $this->db->set('current_stage', 2);
        $this->db->where('jansunwai.work_status !=', 'Complete');
        $this->db->where('createdAt <', 'DATE_SUB(NOW(), INTERVAL 72 HOUR)', false);
        $this->db->where('createdAt >', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        $this->db->update('jansunwai');
        if ($this->db->affected_rows() > 0) {
            return true;  
        } else {
            return false; 
        }
    }


       public function updatelastStage() 
    {
        $this->db->set('current_stage', 3);
        $this->db->where('jansunwai.work_status !=', 'Complete');
        $this->db->where('jansunwai.createdAt <= DATE_SUB(NOW(), INTERVAL 96 HOUR)', null, false);
        $this->db->update('jansunwai');
        
        if ($this->db->affected_rows() > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    
    function default_file(){
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Headers: Origin, Content-Type ");
        header("Content-Type: application/json ");
        $this->load->model('Comman_model');
        date_default_timezone_set('Asia/Kolkata');

        // Check the Content-Type of the request
        $contentType = $this->input->server('CONTENT_TYPE');
        if (strpos($contentType, 'application/json') !== false) {
            // Handle JSON data
            $rest_json = file_get_contents("php://input");
            $_POST = json_decode($rest_json, true);
        } else if (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
            // Handle form-data (automatically handled by CodeIgniter in $_POST)
        } else if (strpos($contentType, 'multipart/form-data') !== false) {
            // Handle multipart/form-data (also automatically handled by CodeIgniter in $_POST)
        }
    }
    public function welcome()
    {
        $this->default_file();
        $response['msg']="test";
        $response['error']=FALSE;
        echo json_encode($response);
    }
        
    public function get_all_blocks() {
        $this->default_file();
        $this->db->where('id !=',6);
        $blocks = $this->Comman_model->get_all_data('block');
        
        if($blocks){
            $response['error'] = FALSE;
            $response['blocks'] = $blocks;
        } else {
            $response['error'] = TRUE;
            $response['message'] = "No blocks found.";
        }
        
        echo json_encode($response);
    }
    
    public function get_booths_by_block() {
        $this->default_file();
        $block_id = $_POST['block_id'] ?? null;
        
        if (!$block_id) {
            $response['error'] = TRUE;
            $response['message'] = "Block ID is required.";
        } else {
            $booths = $this->Comman_model->get_data_where('booth', ['blockid' => $block_id]);
            
            if($booths){
                $response['error'] = FALSE;
                $response['booths'] = $booths;
            } else {
                $response['error'] = TRUE;
                $response['message'] = "No booths found for this block.";
            }
        }
        
        echo json_encode($response);
    }
    
    public function get_panchayats_by_booth() {
        $this->default_file();
        $booth_id = $_POST['booth_id'] ?? null;
        
        if (!$booth_id) {
            $response['error'] = TRUE;
            $response['message'] = "Booth ID is required.";
        } else {
            $panchayats = $this->Comman_model->get_data_where('panchayat', ['boothid' => $booth_id]);
            
            if($panchayats){
                $response['error'] = FALSE;
                $response['panchayats'] = $panchayats;
            } else {
                $response['error'] = TRUE;
                $response['message'] = "No panchayats found for this booth.";
            }
        }
        
        echo json_encode($response);
    }
    
    public function get_villages_by_panchayat() {
        $this->default_file();
        $panchayat_id = $_POST['panchayat_id'] ?? null;
        
        if (!$panchayat_id) {
            $response['error'] = TRUE;
            $response['message'] = "Panchayat ID is required.";
        } else {
            $villages = $this->Comman_model->get_data_where('village', ['panchayatid' => $panchayat_id]);
            
            if($villages){
                $response['error'] = FALSE;
                $response['villages'] = $villages;
            } else {
                $response['error'] = TRUE;
                $response['message'] = "No villages found for this panchayat.";
            }
        }
        
        echo json_encode($response);
    }
    
        public function getAllData()
        {
    $this->default_file();
    $this->load->model('Comman_model');
    
    // Fetching all departments
    $departments = $this->Comman_model->getAllData('department', [], '');

    // Fetching all committees
    $committees = $this->Comman_model->getAllData('samiti', [], '');

    // Fetching all blocks

    // Fetching all booths

    // Fetching all parties
    $parties = $this->Comman_model->getAllData('party', [], '');

    // Preparing the response data
    $data = [
        'departments' => $departments,
        'committees' => $committees,
        'parties' => $parties,
        'msg' => 'All data fetched successfully',
        'error' => false
    ];

    // Returning the response as JSON
    echo json_encode($data);
}


        public function vibhaglist(){
        $this->default_file();
        $this->load->model('Comman_model');
        $sdata =$this->Comman_model->getAllData('department', [],'');
        $data['data']=$sdata;
        $data["msg"] = "Vibhag list";  
        $data["error"] =  true;
        echo json_encode($data);
        }
        
        public function partylist(){
        $this->default_file();
        $this->load->model('Comman_model');
        $sdata =$this->Comman_model->getAllData('party', [],'');
        $data['data']=$sdata;
        $data["msg"] = "Party list";  
        $data["error"] =  true;
        echo json_encode($data);
        }
        
        public function jansunwai() {
    $data = array(); 
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
        $data["msg"] = strip_tags($this->form_validation->error_string());
        $data["error"] = true; 
    } else {
                date_default_timezone_set('Asia/Kolkata');

        $array = array(
            "createdAt" => date('Y-m-d H:i:s'),
            'uname' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'beneficial' => $this->input->post('name'),
            'mobile' => $this->input->post('mobile'),
            'block' => $this->input->post('block'),
            'booth_name' => $this->input->post('booth'),
            'booth_no' => $this->input->post('booth_number'),
            'panchayat_name' => $this->input->post('gram_panchayat'),
            'majra_faliya' => $this->input->post('faliya'),
            'work_problem' => $this->input->post('samasya'),
            'department' => $this->input->post('vibhag'),
            'village' => $this->input->post('gram'),
            'approximate_cost' => $this->input->post('anumanit_lagat'),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'createdBy' => $this->input->post('createdBy'),
            'work_status'=>'Incomplete'
        );
        
 $lastRegQuery = $this->db->select("registration_no")
                         ->order_by("id", "DESC")
                         ->limit(1)
                         ->get("jansunwai");

$lastRegNo = $lastRegQuery->row_array();

$lastNumber =0; // Default start (so first generated will be AC/002)

if (!empty($lastRegNo)) {
    preg_match('/\d+$/', $lastRegNo['registration_no'], $matches);
    if (!empty($matches)) {
        $lastNumber = (int)$matches[0];
    }
}

// Generate registration_no like AC/002, AC/003, ...
$registration_no = "AC/" . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

$array["registration_no"] = $registration_no;

        if ($this->db->insert('jansunwai', $array)) {
            $insert_id = $this->db->insert_id();

                // Log the update action
                $this->load->model('Log_model');
                $this->Log_model->log_action('Jansunwai insert from mobile', 'jansunwai', $insert_id,$array);

            $this->db->where('id', $insert_id);  // assuming 'id' is the primary key
            $query = $this->db->get('jansunwai');
            $last_inserted_data = $query->row_array();

            $data["error"] = false; 
            $data["msg"] = 'Insert';
            $data["last_inserted_data"] = $last_inserted_data; // returning the last inserted data
        } else {
            $data["error"] = true; 
            $data["msg"] = 'Unable to insert';
        }
    }

    echo json_encode($data);
}

        
        public function login()
        {
        // $this->default_file();
        $this->load->model('login_model');
       
         $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            
            $data = $this->login_model->loginMeMobile($email, $password);
            
            
        if($data)
        {
        $response['userdata']=$data;
        $response['msg']="Sucsess";
        $response['error']=false;
        }
        else
        {
        $response['msg']="Email id & Password Don't exist";
        $response['error']=TRUE;    
        }
        
        echo json_encode($response);   
        }
        
        public function servaydata()
        {
        $this->load->model('Comman_model');
        if($this->input->post('user_id')=='')
        {
        $response['msg']="Please enter user id";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else
        {
        
        if($this->input->post('votarcode')=='')
        {
        $response['msg']="Please Enter Votar Id";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else
        {
        if($this->input->post('lat')=='' )
        {
        $response['msg']="Please Enter latitude";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else
        {
        if($this->input->post('long')=='' )
        {
        $response['msg']="Please Enter longitude";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else
        {
        $where11['votarcode']=$this->input->post('votarcode');
        $data1 =$this->Comman_model->getData('servayapp', $where11);
        // echo $this->db->last_query();die;
        if(!empty($data1))
        {
         if($this->input->post('user_id')!='')
            {
            $data['user_id']=$this->input->post('user_id');
            }
             
            if($this->input->post('block_name_number')!='')
            {
            $data['block_name_number']=$this->input->post('block_name_number');
            }
            
            if($this->input->post('boothNumber')!='')
            {
            $data['boothnumber']=$this->input->post('boothNumber');
            }
            if($this->input->post('boothName')!='')
            {
            $data['boothname']=$this->input->post('boothName');
            }
            if($this->input->post('grampanchayat')!='')
            {
            $data['grampanchayat']=$this->input->post('grampanchayat');
            }
            if($this->input->post('village')!='')
            {
            $data['village']=$this->input->post('village');
            }
            if($this->input->post('toll')!='')
            {
            $data['toll']=$this->input->post('toll');
            }
            if($this->input->post('name')!='')
            {
            $data['name']=$this->input->post('name');
            }
            if($this->input->post('fathername')!='')
            {
            $data['fathername']=$this->input->post('fathername');
            }
            if($this->input->post('jaati')!='')
            {
            $data['jaati']=$this->input->post('jaati');
            }
            if($this->input->post('age')!='')
            {
            $data['age']=$this->input->post('age');
            }
            if($this->input->post('education')!='')
            {
            $data['education']=$this->input->post('education');
            }
            if($this->input->post('mobile')!='')
            {
            $data['mobile']=$this->input->post('mobile');
            }
            
            if($this->input->post('address')!='')
            {
            $data['address']=$this->input->post('address');
            }
            if($this->input->post('gender')!='')
            {
            $data['gender']=$this->input->post('gender');
            }
            if($this->input->post('vehicle')!='')
            {
            $data['vehicle']= implode(',', $this->input->post('vehicle')) ; 
            }
            
            if($this->input->post('group')!='')
            {
            $data['group']== implode(',', $this->input->post('group')) ;
            }
            
            if($this->input->post('government_employee')!='')
            {
            $data['government_employee']=$this->input->post('government_employee');
            }
            
            if($this->input->post('parti')!='')
            {
            $data['parti']=$this->input->post('parti');
            }
            
            if($this->input->post('lat')!='')
            {
            $data['lat']=$this->input->post('lat');
            }
             if($this->input->post('long')!='')
            {
            $data['long']=$this->input->post('long');
            }
            if($this->input->post('code')!='')
            {
            $data['code']=implode(',', $this->input->post('code')) ; 
            }
            if($this->input->post('respect_for_women')!='')
            {
            $data['respect_for_women']=$this->input->post('respect_for_women');
            }
            if($this->input->post('farmer_loan_waiver')!='')
            {
            $data['farmer_loan_waiver']=$this->input->post('farmer_loan_waiver');
            }
            
            
             if($this->input->post('facebook')!='')
            {
            $data['facebook']=$this->input->post('facebook');
            }
             if($this->input->post('twitter')!='')
            {
            $data['twitter']=$this->input->post('twitter');
            }
             if($this->input->post('instagram')!='')
            {
            $data['instagram']=$this->input->post('instagram');
            }
             if($this->input->post('end_lat')!='')
            {
            $data['end_lat']=$this->input->post('end_lat');
            }
            if($this->input->post('end_long')!='')
            {
            $data['end_long']=$this->input->post('end_long');
            }
        
            if($this->input->post('enddate')!='')
            {
            $data['enddate']=$this->input->post('enddate');
            }
            if($this->input->post('startdate')!='')
            {
            $data['startdate']=$this->input->post('startdate');
            }
            
            
            if(isset($_FILES) && !empty($_FILES) && $_FILES['image']['name']!=''  ){
            $file = $this->Comman_model->updateMedia('image','userservey');
            // $data['banner_img'] =$file; 
            $data['image'] = $file; 
            }
            
            $whereww['votarcode']=$this->input->post('votarcode');
            $data['update_date']=date('Y-m-d H:i:s');
             $data['date']=date('Y-m-d');
            
            
            log_message('error', 'servaydata 1 API Data: ' . json_encode($data));
            
            
        $data2 =$this->Comman_model->UpdateRecord('servayapp', $data,$whereww);
            if($data2)
            {
                $where110['votarcode']=$this->input->post('votarcode');
                $data1p =$this->Comman_model->getData('servayapp', $where110);
            $response['userdata']=$data1p;
            $response['msg']="Sucsess";
            $response['error']=false;
            echo json_encode($response);   
            }
            else
            {
            $response['msg']="User id & Password Don't exist";
            $response['error']=TRUE;    
            echo json_encode($response);   
            }
        
        }
        else{
            if($this->input->post('user_id')!='')
            {
            $data['user_id']=$this->input->post('user_id');
            }
             if($this->input->post('votarcode')!='')
            {
            $data['votarcode']=$this->input->post('votarcode');
            }
            if($this->input->post('block_name_number')!='')
            {
            $data['block_name_number']=$this->input->post('block_name_number');
            }
            if($this->input->post('boothNumber')!='')
            {
            $data['boothnumber']=$this->input->post('boothNumber');
            }
            if($this->input->post('boothName')!='')
            {
            $data['boothname']=$this->input->post('boothName');
            }
            if($this->input->post('grampanchayat')!='')
            {
            $data['grampanchayat']=$this->input->post('grampanchayat');
            }
            if($this->input->post('village')!='')
            {
            $data['village']=$this->input->post('village');
            }
            if($this->input->post('toll')!='')
            {
            $data['toll']=$this->input->post('toll');
            }
            if($this->input->post('name')!='')
            {
            $data['name']=$this->input->post('name');
            }
            //---------------//
            if($this->input->post('fathername')!='')
            {
            $data['fathername']=$this->input->post('fathername');
            }
            if($this->input->post('jaati')!='')
            {
            $data['jaati']=$this->input->post('jaati');
            }
            if($this->input->post('age')!='')
            {
            $data['age']=$this->input->post('age');
            }
            if($this->input->post('education')!='')
            {
            $data['education']=$this->input->post('education');
            }
            if($this->input->post('mobile')!='')
            {
            $data['mobile']=$this->input->post('mobile');
            }
             if($this->input->post('lat')!='')
            {
            $data['lat']=$this->input->post('lat');
            }
             if($this->input->post('long')!='')
            {
            $data['long']=$this->input->post('long');
            }
            //ss
            if($this->input->post('address')!='')
            {
            $data['address']=$this->input->post('address');
            }
            if($this->input->post('gender')!='')
            {
            $data['gender']=$this->input->post('gender');
            }
            if($this->input->post('vehicle')!='')
            {
            $data['vehicle']= implode(',', $this->input->post('vehicle')) ;  
            }
            
            if($this->input->post('group')!='')
            {
            $data['group']= implode(',', $this->input->post('group')) ;  
            }
            
            if($this->input->post('government_employee')!='')
            {
            $data['government_employee']=$this->input->post('government_employee');
            }
            
            if($this->input->post('parti')!='')
            {
            $data['parti']=$this->input->post('parti');
            }
            
            if($this->input->post('code')!='')
            {
            $data['code']= implode(',', $this->input->post('code')) ;  
            }
              if($this->input->post('servayid')!='')
            {
            $data['servayid']== implode(',', $this->input->post('servayid')) ;
            }
            
            
            if($this->input->post('respect_for_women')!='')
            {
            $data['respect_for_women']=$this->input->post('respect_for_women');
            }
            if($this->input->post('farmer_loan_waiver')!='')
            {
            $data['farmer_loan_waiver']=$this->input->post('farmer_loan_waiver');
            }
                if($this->input->post('facebook')!='')
            {
            $data['facebook']=$this->input->post('facebook');
            }
             if($this->input->post('twitter')!='')
            {
            $data['twitter']=$this->input->post('twitter');
            }
             if($this->input->post('instagram')!='')
            {
            $data['instagram']=$this->input->post('instagram');
            }
             if($this->input->post('end_lat')!='')
            {
            $data['end_lat']=$this->input->post('end_lat');
            }
            if($this->input->post('end_long')!='')
            {
            $data['end_long']=$this->input->post('end_long');
            }
        
            if($this->input->post('enddate')!='')
            {
            $data['enddate']=$this->input->post('enddate');
            }
            if($this->input->post('startdate')!='')
            {
            $data['startdate']=$this->input->post('startdate');
            }
            
            if(isset($_FILES) && !empty($_FILES) && $_FILES['image']['name']!=''  ){
            $file = $this->Comman_model->updateMedia('image','userservey');
            // $data['banner_img'] =$file; 
            $data['image'] = $file; 
             
                
            }
                        date_default_timezone_set("Asia/kolkata");
        
            $data['create_date']=date('Y-m-d H:i:s');
            $data['date']=date('Y-m-d');
                        log_message('error', 'servaydata 2 API Data: ' . json_encode($data));

            $data1 =$this->Comman_model->insertData('servayapp', $data);
            //   echo $this->db->last_query();die;
            if($data1)
            {
                if($this->input->post('servayid')!='')
                    {
                   //sheetal
                   $data88['servaystatus']='1';
                   $data88['servayid']=$this->input->post('servayid');
                   $tt['userId']=$this->input->post('user_id');
                   $this->Comman_model->UpdateRecord('tbl_users', $data88,$tt);
                //  echo  $this->db->last_query();die;
                    }
            $response['userdata']=$data1;
            $response['msg']="Sucsess";
            $response['error']=false;
            echo json_encode($response);   
            }
            else
            {
            $response['msg']="User id & Password Does Not exist";
            $response['error']=TRUE;    
            echo json_encode($response);   
            }
        
        }
        }
        }
        
        }
        }
        
        }
        
        public function list()
        {
        // $this->default_file();
        $this->load->model('Comman_model');
        if($this->input->post('user_id')!='')
        {
        
        $ee['user_id']=$this->input->post('user_id');
        $ee['servayid!=']='own';
        
        $data1 =$this->Comman_model->getAllData('servayapp', $ee);
        //   echo $this->db->last_query();die;
        if($data1)
        {
        $response['userdata']=$data1;
        $response['totalrow']=count($data1);
        $response['msg']="Sucsess";
        $response['error']=false;
        echo json_encode($response);   
        }
        else
        {
        $response['msg']="User id & Password Don't exist";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        }
        else
        {
        
        $response['msg']="Please  Enter User Id";
        $response['error']=TRUE;    
        echo json_encode($response); 
        }
        }
        
        public function searchwithvoter()
        {
        $this->load->model('Comman_model');
        if($this->input->post('user_id')!='')
        {
        $user_id=$this->input->post('user_id');
        $servayid='own';
        $search=$this->input->post('search');
        if($this->input->post('search')!='')
        {
        $da =$this->db->query("SELECT * FROM `servayapp` WHERE `user_id`='$user_id' and `servayid`!='$servayid' and `mobile` LIKE '%$search%' OR `votarcode` LIKE '%$search%';");
        $data1= $da->result();
        if($data1)
        {
        $response['userdata']=$data1;
        $response['totalrow']=count($data1);
        $response['msg']="Sucsess";
        $response['error']=false;
        echo json_encode($response);   
        }
        else
        {
        $response['msg']="User id & Password Don't exist";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        }
        else{
        $response['msg']="Enter Search Keyword";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        }
        else
        {
        
        $response['msg']="Please  Enter User Id";
        $response['error']=TRUE;    
        echo json_encode($response); 
        }
        }
        
        public function bulkservay(){
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Headers: Origin,Content-Type ");
        $this->load->model('Comman_model');
        $this->input->post("datafrom");
        
        $dd= json_decode($this->input->post("datafrom"));
        
        
            log_message('error', 'bulk json severy API Data: ' . json_encode($this->input->post("datafrom")));




        if(!empty($dd))
        {
        foreach($dd as $k =>$val)
        {
        
        if($val->dob!=''){ $data['dob']=$val->dob; }
        if($val->dom!=''){ $data['dom']=$val->dom; }
        
                if($val->samithi!=''){ $data['samithi']=$val->samithi; }
                if($val->padvarsh!=''){ $data['padvarsh']=$val->padvarsh; }

        
        
        if($val->user_id!='')
        {
        $data['user_id']=$val->user_id;
        }
        
        if($val->boothNumber!='')
        {
        $data['boothnumber']=$val->boothNumber;
        }
        if($val->boothName!='')
        {
        $data['boothname']=$val->boothName;
        }
        if($val->block_name_number!='')
        {
        $data['block_name_number']=$val->block_name_number;
        }
        if($val->votarcode!='')
        {
        $data['votarcode']=$val->votarcode;
        }
        
        if($val->grampanchayat!='')
        {
        $data['grampanchayat']=$val->grampanchayat;
        }
        if($val->village!='')
        {
        $data['village']=$val->village;
        }
        if($val->toll!='')
        {
        $data['toll']=$val->toll;
        }
        if($val->name!='')
        {
        $data['name']=$val->name;
        }
        if($val->fathername!='')
        {
        $data['fathername']=$val->fathername;
        }
        if($val->jaati!='')
        {
        $data['jaati']=$val->jaati;
        }
        if($val->age!='')
        {
        $data['age']=$val->age;
        }
        if($val->education!='')
        {
        $data['education']=$val->education;
        }
        if($val->mobile!='')
        {
        $data['mobile']=$val->mobile;
        }
        
        if($val->lat!='')
        {
        $data['lat']=$val->lat;
        }
        
        if($val->long!='')
        {
        $data['long']=$val->long;
        }
        
        if($val->address!='')
        {
        $data['address']=$val->address;
        }
        
        if($val->gender!='')
        {
        $data['gender']=$val->gender;
        }
        
        if($val->vehicle!='')
        {
        $data['vehicle']= implode(',',  $val->vehicle) ;  
        }
        
        if($val->group!='')
        {
        $data['group']= $val->group;   
        }
        
        if($val->government_employee!='')
        {
        $data['government_employee']=$val->government_employee;
        }
        
        if($val->parti!='')
        {
        $data['parti']=$val->parti;
        }
        
        if($val->code!='')
        {
        $data['code']= implode(',', $val->code) ;   
        }
        
        if($val->servayid!='')
        {
        $data['servayid']=$val->servayid;
        }
        
        if($val->respect_for_women!='')
        {
        $data['respect_for_women']=$val->respect_for_women;
        }
        if($val->farmer_loan_waiver!='')
        {
        $data['farmer_loan_waiver']=$val->farmer_loan_waiver;
        }
        if($val->facebook!='')
        {
        $data['facebook']=$val->facebook;
        }
        if($val->twitter!='')
        {
        $data['twitter']=$val->twitter;
        }
        if($val->instagram!='')
        {
        $data['instagram']=$val->instagram;
        }
        if($val->end_lat!='')
        {
        $data['end_lat']=$val->end_lat;
        }
        if($val->end_long!='')
        {
        $data['end_long']=$val->end_long;
        }
        if($val->enddate!='')
        {
        $data['enddate']=$val->enddate;
        }
        if($val->startdate!='')
        {
        $data['startdate']=$val->startdate;
        }
        if($val->image!='')
        {
        // if(isset($_FILES) && !empty($_FILES) && $_FILES['file']['name']!=''  ){
        //         $file = $this->Comman_model->updateMedia('file','userservey');
        //         // $data['banner_img'] =$file; 
        $data['image'] = $val->image; 
        // }
        
        }
        
        // $data['image']=$_FILES['files']['name'][$k];
        date_default_timezone_set("Asia/kolkata");
        $data['create_date']=date('Y-m-d H:i:s'); 
        
        $data['date']=date('Y-m-d');
        



        $data1 =$this->Comman_model->insertData('servayapp', $data);
        }
        $response['msg']="Sucsess";
        $response['error']=false;
        echo json_encode($response); 
        }
        else{
        $response['msg']="Enter json data";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        }
        
        public function edit()
        {
        $this->load->model('Comman_model');
        if($this->input->post('user_id')=='')
        {
        $response['msg']="Please enter user id";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else{
        if($this->input->post('votarcode')=='')
        {
        $response['msg']="Please enter Votar Id";
        $response['error']=TRUE;    
        echo json_encode($response);  
        }
        else
        {
        
        if($this->input->post('id')!='')
        {
        $idsss['id']=$this->input->post('id');
        }
        if($this->input->post('user_id')!='')
        {
        $data['user_id']=$this->input->post('user_id');
        }
        if($this->input->post('votarcode')!='')
        {
        $data['votarcode']=$this->input->post('votarcode');
        }
        if($this->input->post('block_name_number')!='')
        {
        $data['block_name_number']=$this->input->post('block_name_number');
        }
        if($this->input->post('booth_name_number')!='')
        {
        $data['booth_name_number']=$this->input->post('booth_name_number');
        }
        if($this->input->post('grampanchayat')!='')
        {
        $data['grampanchayat']=$this->input->post('grampanchayat');
        }
        if($this->input->post('village')!='')
        {
        $data['village']=$this->input->post('village');
        }
        if($this->input->post('toll')!='')
        {
        $data['toll']=$this->input->post('toll');
        }
        if($this->input->post('name')!='')
        {
        $data['name']=$this->input->post('name');
        }
        //---------------//
        if($this->input->post('fathername')!='')
        {
        $data['fathername']=$this->input->post('fathername');
        }
        if($this->input->post('jaati')!='')
        {
        $data['jaati']=$this->input->post('jaati');
        }
        if($this->input->post('age')!='')
        {
        $data['age']=$this->input->post('age');
        }
        if($this->input->post('education')!='')
        {
        $data['education']=$this->input->post('education');
        }
        if($this->input->post('mobile')!='')
        {
        $data['mobile']=$this->input->post('mobile');
        }
        if($this->input->post('lat')!='')
        {
        $data['lat']=$this->input->post('lat');
        }
        if($this->input->post('long')!='')
        {
        $data['long']=$this->input->post('long');
        }
        //ss
        if($this->input->post('address')!='')
        {
        $data['address']=$this->input->post('address');
        }
        if($this->input->post('gender')!='')
        {
        $data['gender']=$this->input->post('gender');
        }
        if($this->input->post('vehicle')!='')
        {
        $data['vehicle']=$this->input->post('vehicle');
        }
        
        if($this->input->post('group')!='')
        {
        $data['group']=$this->input->post('group');
        }
        
        if($this->input->post('government_employee')!='')
        {
        $data['government_employee']=$this->input->post('government_employee');
        }
        
        if($this->input->post('parti')!='')
        {
        $data['parti']=$this->input->post('parti');
        }
        
        if($this->input->post('code')!='')
        {
        $data['code']=$this->input->post('code');
        }
        if($this->input->post('servayid')!='')
        {
        $data['servayid']=$this->input->post('servayid');
        }
        
        
        if($this->input->post('respect_for_women')!='')
        {
        $data['respect_for_women']=$this->input->post('respect_for_women');
        }
        if($this->input->post('farmer_loan_waiver')!='')
        {
        $data['farmer_loan_waiver']=$this->input->post('farmer_loan_waiver');
        }
        if($this->input->post('facebook')!='')
        {
        $data['facebook']=$this->input->post('facebook');
        }
        if($this->input->post('twitter')!='')
        {
        $data['twitter']=$this->input->post('twitter');
        }
        if($this->input->post('instagram')!='')
        {
        $data['instagram']=$this->input->post('instagram');
        }
        if(isset($_FILES) && !empty($_FILES) && $_FILES['file']['name']!=''  ){
        $file = $this->Comman_model->updateMedia('file','userservey');
        // $data['banner_img'] =$file; 
        $data['image'] = $file; 
        }
        if($this->input->post('end_lat')!='')
        {
        $data['end_lat']=$this->input->post('end_lat');
        }
        if($this->input->post('end_long')!='')
        {
        $data['end_long']=$this->input->post('end_long');
        }
        
        if($this->input->post('enddate')!='')
        {
        $data['enddate']=$this->input->post('enddate');
        }
        if($this->input->post('startdate')!='')
        {
        $data['startdate']=$this->input->post('startdate');
        }
                date_default_timezone_set("Asia/kolkata");
        
        $data['create_date']=date('Y-m-d H:i:s');
        $data['date']=date('Y-m-d');
        
        $data1 =$this->Comman_model->UpdateRecord('servayapp', $data,$idsss);
        
        
        //   echo $this->db->last_query();die;
        if($data1)
        {
        
        $response['userdata']=$data1;
        $response['msg']="Sucsess";
        $response['error']=false;
        echo json_encode($response);   
        }
        else
        {
        $response['msg']="User id & Password Don't exist";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        
        
        
        }
        }
        
        }
        
        public function  fileupload()
        {
        $this->load->model('Comman_model');
        if(isset($_FILES) && !empty($_FILES) && $_FILES['image']['name']!=''  ){
        $file = $this->Comman_model->updateMedia('image','userservey');
        // $data['banner_img'] =$file; 
        $data['image'] = $file; 
        $data1=  $this->Comman_model->insertData('photocollect', $data);
        if($data1)
        {
        
        $response['image']=$file;
        $response['msg']="Sucsess";
        $response['error']=false;
        echo json_encode($response);   
        }
        else
        {
        $response['msg']="Something want wrong";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        
        }else{
        
        
         $response['msg']="Please Select  image";
        $response['error']=TRUE;    
        echo json_encode($response);   
        }
        
        }
}
?>