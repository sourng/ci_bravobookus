<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_impact', '', true);
		$this->load->model('m_user', '', true);			

        $this->load->model('Crud_model','m_crud',True);
	}
	
	/*
	**Default
	*/
	function index()
	{
	//	if($this->session->userdata('name'))
	//	redirect(site_url().'admin/c_main', 'location', 302);
					
	//	$this->load->view('admin/v_login');

		// if($this->session->userdata('name'))
		// 	redirect(site_url().'c_main', 'location', 302);	
		// 	$this->load->view('v_login');
		  $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

		if($this->session->userdata('is_logged_in')){
			redirect('admin/dashboard', 'location', 302);
        }else{
        	$data['head_login']='admin/head/v_head_login';
        	$data['footer']="admin/footer/v_footer_login";
        	$data['main_content']="admin/login/v_login";
        	$this->load->view('admin/v_template',$data);	
        }


	}

	// Signup

function signup()
	{

		  $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
	//	if($this->session->userdata('name'))
	//	redirect(site_url().'admin/c_main', 'location', 302);
					
	//	$this->load->view('admin/v_login');

		// if($this->session->userdata('name'))
		// 	redirect(site_url().'c_main', 'location', 302);	
		// 	$this->load->view('v_login');

		if($this->session->userdata('is_logged_in')){
			redirect('admin/dashboard', 'location', 302);
        }else{
        	$data['head_login']='admin/head/v_head_login';
        	$data['footer']="admin/footer/v_footer_login";
        	$data['main_content']="admin/login/v_signup";
        	$this->load->view('admin/v_template',$data);	
        }


	}
	//End Signup
	/*
	**Login
	*/
	/*function verifylogin(){
		$password = $this->input->post('password');
		$email 	  = $this->input->post('email');
		
		$result = $this->m_user->login($email,'');
		
		// check for result 
		if (sizeof($result) > 0) {
			$salt = $result[0]['salt'];
			$encrypted_password = $result[0]['encrypted_password'];
			$hash = $this->m_user->checkhashSSHA($salt, $password);
			// check for password equality
			if ($encrypted_password == $hash) {
				// user authentication details are correct
				//return $result;
				//add all data to session
				 $newdata = array(
							'gro_id'			=> $result[0]['gro_id'],
							'group_level'		=> $result[0]['level'],
							'uid' 				=> $result[0]['uid'],
							'name' 				=> $result[0]['name'],
							'email'     		=> $result[0]['email'],
							'logged_in' 		=> TRUE
					   );
				$this->session->set_userdata($newdata);
				
				redirect(site_url().'admin/c_main', 'location', 302);
			}else{
				//message
				$this->session->set_userdata('message', $this->connect->message("Invalid password!", "error"));
				$this->index();
			}
		} else {
			//message
			$this->session->set_userdata('message', $this->connect->message("Invalid email and password!", "error"));
			$this->index();
		}
 	}*/

 //---------- Start Create User-----------------//
 /*
 Insert data to table locations
 */
 //---------- End Create User-------------------//
 //----------Start Register Login---------------//
 //----------End Register Login ----------------//
	
	function verifylogin(){
		$password = md5($this->input->post('password'));
		$email 	  = $this->input->post('email');
		
		$result = $this->m_user->login($email,'');
		
		// check for result 
		if (sizeof($result) > 0) {
			$encrypted_password = $result[0]['encrypted_password'];
			// check for password equality
			if ($encrypted_password == $password) {
				// user authentication details are correct
				//return $result;
				//add all data to session
				 $newdata = array(
							'gro_id'			=> $result[0]['gro_id'],
							'group_level'		=> $result[0]['level'],
							'uid' 				=> $result[0]['uid'],
							'name' 				=> $result[0]['name'],
							'email'     		=> $result[0]['email'],
							'image'     		=> $result[0]['image'],
							'company_id'     		=> $result[0]['company_id'],
							'is_logged_in' 		=> TRUE
					   );
				$this->session->set_userdata($newdata);
				
				redirect(site_url().'admin/dashboard', 'location', 302);
			}else{
				//message
				$this->session->set_userdata('message', $this->connect->message("Invalid password!", "error"));
				$this->index();
			}
		} else {
			//message
			$this->session->set_userdata('message', $this->connect->message("Invalid email and password!", "error"));
			$this->index();
		}
 	}
	
	/*
	check user email
	*/
	function check_user()
	{
		$usr=$this->input->post('email');
		$result=$this->m_user->check_user_exist($usr);
		if($result)
		{
			echo "false";
			
		}
		else{
			
			echo "true";
		}
	}
	
	/*
	Destroy session
	*/
	function logout()
	{
		$newdata = array(	'gro_id'			=> '',
							'group_level'		=> '',
							'uid' 				=> '',
							'cus_id' 			=> '',
							'name' 				=> '',
							'email'     		=> '',
							'is_logged_in' 		=> FALSE
					   );

		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect(site_url().'admin', 'location', 302);
	}

/* Register User */
function guest_register(){ 
if($this->check_user()==false){
	$d=date('dd');
	$m=date('mm');
	$y=date('yy');
	$h=time('h');
	$mn=time('m');
$un=$d."".$m."".$y."".$h."".$mn;

	$user_name=$this->input->post('name');
	$email=$this->input->post('email');
	$pwd=$this->input->post('pwd');
	$pwd_confirm=$this->input->post('pwd_confirm');
	if($pwd_confirm==$pwd){
		$encrypted_password=md5($this->input->post('pwd'));
		$pass=true;
	}else{
		$pass=false;
	}

$now = new DateTime();
$now->setTimezone(new DateTimezone('Asia/Bangkok'));
$current_date= $now->format('Y-m-d H:i:s');


	if($user_name!="" && $email!="" && $pass==true){
		$data_arr = array(
		//'cat_id'	=> $this->input->post('cat_id'),
		//'gro_id'	=> $this->input->post('gro_id'),
		'gro_id'	=> '3',
		'unique_id'		=> $un,
		'name'		=> $user_name,
		'email' 			=> $email, 
		'encrypted_password'=>$encrypted_password,
		'salt'				=> $un, //$this->input->post('salt'),
		'status' 			=> '1', 
		'note'				=> 'Register Online',//$this->input->post('note'),
		'user_create'		=> '3',
		'created_date'		=> $current_date,
		'user_update' 		=> '3', 
		'updated_date'		=> $current_date,		
		);

			 $result =	$this->m_impact->insert('users', $data_arr, '');
			 if($result){
				 $this->session->set_userdata('message', $this->connect->message("Gust Register has been created!", "success"));
			 }else{
				 $this->session->set_userdata('message', $this->connect->message("Error!", "warning"));
			 }	 
				// redirect(site_url().'admin/', 'login', 302);
			 //redirect(site_url().'admin/index', 'login.html', 302);
	}else{
		//message
			$this->session->set_userdata('message', $this->connect->message("Invalid email and password!", "error"));
			$this->index();

		redirect(site_url().'signup.html');
	}
	//echo "Login";
	}	 
 }
/* End Register User */

/*User Profile */

/*End User Profile */

}
/* End of file welcome.php */
/* Location: ./application/controllers/login.php */





