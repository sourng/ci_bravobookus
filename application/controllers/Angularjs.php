<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Angularjs extends CI_Controller {
    function __construct() {
      parent::__construct();
      $this->load->model('M_Hotels','mh',TRUE);
       $this->load->model('M_Admin','M_Admin',TRUE);
      $this->load->model('M_Sourng','m_sourng',True);
      $this->load->library('Ajax_pagination');
      $this->load->helper('text');
      $this->load->database();
      $this->perPage = 5;
     // $this->starOrder=4;

      $this->load->model('Crud_model','m_crud',True); 
  }
 
    public function index()
    {
   $data=array();
      $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $uid=$this->session->userdata('uid');
      $gro_id=$this->session->userdata('gro_id');
      $data['uid']=$uid;
      $data['gro_id']=$gro_id;
      $data['currency_name']="$";

      $data['sidebar_menu']=$this->m_crud->get_by_sql("SELECT * FROM tbl_controllers where uid=$uid");
      // v_ticket
      // if($gro_id==1){
      //   if($param1 !=''){
      //      $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket WHERE status='".$param1."'");
      //   }else{
      //      $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket");
      //   }       

      // }else{
      //   $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket where u_id=$uid AND status='".$param1."'");
      // }

      $data['v_ticket']=$this->M_Admin->get_by_sql("SELECT * FROM tbl_ticket ORDER BY booking_code DESC");      
      // $data['v_ticket']=$this->M_Admin->getAllTicket();

      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='All Bookings';
      $data['head']='admin/head/v_head_table';
      $data['footer']='admin/footer/v_footer_table';
      $data['sidebar']='admin/inc/v_sidebar';
      $data['sidebar_right']='admin/inc/v_sidebar_right';
      $data['header']='admin/inc/v_header';
      
      $data['main_content']='admin/booking/v_booking';
      // $data['main_content']='admin/booking/v_list';
          //load the view
      $this->load->view('admin/v_admin_template', $data);    
          //echo "Admin Dashboard";
    }
    
    public function get_list() {
        $this->load->model(array('M_Admin'));
        $data = $this->M_Admin->getAll();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    // Booking
  public function booking($param1='',$param2=''){      
      $data=array();
      $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $uid=$this->session->userdata('uid');
      $gro_id=$this->session->userdata('gro_id');
      $data['uid']=$uid;
      $data['gro_id']=$gro_id;
      $data['currency_name']="$";

      $data['sidebar_menu']=$this->m_crud->get_by_sql("SELECT * FROM tbl_controllers where uid=$uid");
      // v_ticket
      if($gro_id==1){
        if($param1 !=''){
           $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket WHERE status='".$param1."'");
        }else{
           $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket");
        }       

      }else{
        $data['v_ticket']=$this->m_crud->get_by_sql("SELECT * FROM v_ticket where u_id=$uid AND status='".$param1."'");
      }

      

      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='All Bookings';
      $data['head']='admin/head/v_head_table';
      $data['footer']='admin/footer/v_footer_table';
      $data['sidebar']='admin/inc/v_sidebar';
      $data['sidebar_right']='admin/inc/v_sidebar_right';
      $data['header']='admin/inc/v_header';
          // $data['main_content']='admin/booking/v_booking';
      $data['main_content']='admin/booking/v_list';
          //load the view
      $this->load->view('admin/v_admin_template', $data);    
          //echo "Admin Dashboard";
  }


  function replaceAll($text) { 
      $text = strtolower(htmlentities($text)); 
      $text = str_replace(get_html_translation_table(), "-", $text);
      $text = str_replace(" ", "-", $text);
      $text = preg_replace("/[-]+/i", " ", $text);
      $text=substr($text, 0, -5 );
      return ucfirst($text);
  }

  function url_changed($text) { 
      $text = strtolower(htmlentities($text)); 
      $text = str_replace(get_html_translation_table(), "-", $text);
      $text = str_replace(" ", "-", $text);
      $text = preg_replace("/[-]+/i", "-", $text);
      return $text;
  }

}