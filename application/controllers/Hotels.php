<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Management class created by CodexWorld
 */
class Hotels extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load->helper('text');

        $this->load->model('Crud_model','m_crud');
        $this->load->database();
        
         
        $this->load->model('M_Hotels','mh',TRUE);
        $this->load->model('M_Sourng','m_sourng',True);
        //load pagination class
       $this->load->library('pagination');


        $this->load->library('Ajax_pagination');

        // $this->load->model('post');
        // $this->load->library('Ajax_pagination');
        // $this->perPage = 2;
        $this->perPage = 2;   
        $this->load->helper('url');
    }
    
   public function index($offset = 0){     
        $data = array();
        $data['breadcrumb_1']="index";
        $data['breadcrumb_2']="Hotels";
        $data['breadcrumb_3']="Europe";
        $data['breadcrumb_4']="Netherlands";
        $data['title']="Hotel List Search Result";
//---------------------------------------------------------
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");      
      	$data['style_home']="inc/v_style_home";
      	$data['header_top']="inc/v_header_top";
      	$data['nav']="inc/v_nav";
        $data['change_search']="hotels_layout/v_change_search";
         // $data['change_search']=NULL;
        // $data['menu_left_hotel']="hotels_layout/v_menu_left_hotels";
        $data['menu_left_hotel']=NULL;
//configuration variables for pagination 
        $config['base_url']   = site_url('hotels/listhotel');
        //Get the total student count
        $config['total_rows'] = $this->mh->HotelsCount();

        $config['per_page'] = 2;
        $config["uri_segment"] = 3;
          
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
             
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="firstlink">';
        $config['first_tag_close'] = '</span>';
             
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<span class="lastlink">';
        $config['last_tag_close'] = '</span>';
             
        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<span class="next">';
        $config['next_tag_close'] = '</span>';
          
        $config['prev_link'] = 'Prev Page';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';
          
        $config['cur_tag_open'] = '<span class="curlink">';
        $config['cur_tag_close'] = '</span>';
          
        $config['num_tag_open'] = '<span class="numlink">';
        $config['num_tag_close'] = '</span>';        
        $this->pagination->initialize($config);            
        //get student records
        $data['hotels'] = $this->mh->getHotels($config['per_page'],$this->uri->segment(1));
        // $data['hotels']=$this->m_crud->get_by_sql("SELECT * FROM v_list_hotels");
        // End Pagination
        // $data['hotels']=$this->m_crud->get_by_sql("SELECT * FROM v_list_hotels");
		$data['page']="hotels/v_hotels";
        $data['footer']="inc/v_footer";
		$data['script_footer_home']="inc/v_script_footer_home";
        $this->load->view('v_template_hotels',$data);
}

    public function listhotel(){     
        $data = array();
        $dest_id=$_GET['destination'];
        $data['breadcrumb_1']="index";
        $data['breadcrumb_2']="Hotels";
        $data['breadcrumb_3']="Europe";
        $data['breadcrumb_4']="Netherlands";
        $data['title']="Hotel List Search Result";
        //---------------------------------------------------------
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['change_search']="hotels_layout/v_change_search";
         // $data['change_search']=NULL;
        $data['menu_left_hotel']="hotels_layout/v_menu_left_hotels";
//configuration variables for pagination 
        $config['base_url']   = site_url('hotels/listhotel/'. $dest_id .'/');
        //Get the total student count
        $config['total_rows'] = $this->mh->HotelsCount();     
        $config['per_page'] = 2;
        $config["uri_segment"] = 3;          
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';             
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="firstlink">';
        $config['first_tag_close'] = '</span>';             
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<span class="lastlink">';
        $config['last_tag_close'] = '</span>';             
        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<span class="next">';
        $config['next_tag_close'] = '</span>';          
        $config['prev_link'] = 'Prev Page';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';          
        $config['cur_tag_open'] = '<span class="curlink">';
        $config['cur_tag_close'] = '</span>';          
        $config['num_tag_open'] = '<span class="numlink">';
        $config['num_tag_close'] = '</span>';
        $this->pagination->initialize($config);
         // $data['paginations']=$this->mh->paginations(1,5);//->initialize($config);            
        //get student records
        $data['hotels'] = $this->mh->getHotels($config['per_page'],$this->uri->segment(4));
        // $data['hotels']=$this->m_crud->get_by_sql("SELECT * FROM v_list_hotels");
        // End Pagination
        // $data['hotels']=$this->m_crud->get_by_sql("SELECT * FROM v_list_hotels");
        $data['page']="hotels/v_hotels";

        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";
        $this->load->view('v_template_hotels',$data);
    }
    
    public function hotels_details(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['slide']="hotels_layout/v_slide_hotels_details";
        $data['exeptional']="hotels_layout/v_exeptional_hotels_details";
        $data['available_room']="hotels_layout/v_hotels_available_room";
        $data['review']="hotels_layout/v_hotels_review";
        $data['hotels_near']="hotels_layout/v_hotels_near";
        $data['write_review']="hotels_layout/v_write_review";
        $data['page']="hotels/v_hotels_details";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";
        $data['showfacil']=$this->m_crud->get_by_sql("SELECT * FROM test_add where id=17");
        $this->load->view('v_template_hotels',$data);       
    }

    public function payment(){
        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";        
        $data['paypal']="hotels_layout/v_payment_paypal_left";
        $data['payment_form']="hotels_layout/v_payment_form_middle";
        $data['payment_right']="hotels_layout/v_payment_form_right";
        $data['page']="hotels/v_hotels_payment";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";
        $this->load->view('v_template_hotels',$data);        
    }

    public function payment_registered(){
        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        
        $data['paypal']="hotels_layout/v_payment_paypal_left";
        $data['registered_middle']="hotels_layout/v_payment_registered_form_middle";
        $data['payment_form']="hotels_layout/v_payment_form_middle";
        $data['payment_right']="hotels_layout/v_payment_form_right";


        $data['page']="hotels/v_hotels_payment_registered_card";

        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_hotels',$data);
        
    }
    
    public function payment_unregistered(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        
        $data['costomer']="hotels_layout/v_payment_unregistered_costomer_form";
        $data['paypal']="hotels_layout/v_payment_paypal_left";
        $data['payment_form']="hotels_layout/v_payment_form_middle";
        $data['payment_right']="hotels_layout/v_payment_form_right";

        $data['page']="hotels/v_hotels_payment_unregistered";

        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_hotels',$data);
        
    }

    public function search(){
       $data = array();
       $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");

        $keyword = $this->input->get('destination');
        $data['title']                  = 'Search Results';
        $config['per_page']         = 2;
        $config['uri_segment']          = 2;
        $config['full_tag_open']        = '<nav class="pagination"><ul>';
        $config['full_tag_close']       = '</ul></nav>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']        = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="'.site_url(uri_string()).'">';
        $config['cur_tag_close']        = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open']        = '<li>';
        $config['prev_tag_close']       = '</li>';
        $config['next_tag_open']        = '<li>';
        $config['next_tag_close']       = '</li>';
        $config['first_link']           = '&laquo;';
        $config['prev_link']            = '&lsaquo;';
        $config['last_link']            = '&raquo;';
        $config['next_link']            = '&rsaquo;';
        $config['first_tag_open']       = '<li>';
        $config['first_tag_close']      = '</li>';
        $config['last_tag_open']        = '<li>';
        $config['last_tag_close']       = '</li>';
        $config['page_query_string']    = TRUE;
        $config['query_string_segment']= 'page';
        $config['base_url']         = site_url('search?s='.$keyword);
        $config['total_rows']           = $this->m_home->count_search_produk($keyword);
        $this->pagination->initialize($config);
        $page = (empty($_GET['page'])) ? 0 : $_GET['page'];
        $data['results']                = $this->m_home->search_produk($keyword, $config['per_page'], $page);
        $data['pagination']         = $this->pagination->create_links();
        $data['total']                  = $this->m_home->count_search_produk($keyword);
   

        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        
        
        $data['page']="hotels/v_hotels_search";

        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_hotels',$data);
    }
    
    public function search_results(){

        $data = array();
        $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
       
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";

        $data['menu_left_hotel']="hotels_layout/v_menu_left_hotels";
        
        $data['page']="hotels/v_hotels_search_results";

        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_hotels',$data);
        
    }
    
}