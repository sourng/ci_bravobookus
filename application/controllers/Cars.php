<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Management class created by CodexWorld
 */
class Cars extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model','m_crud');
        $this->load->database();
        
        $this->load->helper('url');
    }
    
    public function index(){

        $data = array();
       $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";

        
        $data['cars_search_change']="cars/inc/v_cars_search_change";
        $data['car_menuleft']="cars/inc/v_cars_menuleft";
        $data['page']="cars/v_cars";
        $data['cars_count_page']="cars/inc/v_cars_count_page";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_details(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_details";
        $data['cars_location']="cars/inc/v_cars_location";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_payment(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_payment";
        $data['cars_cost']="cars/inc/v_cars_cost";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_payment_registered_card(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_payment_registered_card";
        $data['cars_cost']="cars/inc/v_cars_cost";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_payment_unregistered(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_payment_unregistered";
        $data['cars_cost']="cars/inc/v_cars_cost";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_search(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_search";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
    public function cars_results(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="cars/v_cars_results";
        $data['cars_search_change']="cars/inc/v_cars_search_change";
        $data['cars_date']="cars/inc/v_cars_date";
        $data['car_menuleft']="cars/inc/v_cars_menuleft";
        $data['cars_count_page']="cars/inc/v_cars_count_page";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_cars',$data);
    }
}

    ?>
  