<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Management class created by CodexWorld
 */
class Home extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('Crud_model','m_crud');
        $this->load->database();
        // $this->load->library('Ajax_pagination');
        // $this->perPage = 2;
        $this->load->helper('url');
    }
    
    public function index(){

     
      $data = array();
      // Add Style Home
      $data['header_top']="inc/v_header_top";
	  $data['nav']="inc/v_nav";
       // $data['nav']=null;
      $data['style_home']="inc/v_style_home";


      $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
     
      $data['service']="home/v_services";
        // $data['service']=NULL;
    // recent_view
    // $data['recent_view']="home/v_recent_view";
    $data['recent_view']=NULL;

     $data['last_minute_deals']="home/v_last_minute_deals";
    // $data['last_minute_deals']=NULL;

     
     $sql_deal="SELECT 
            distinct  d.dest_id,d.destinations,d.dest_landmark,d.country
            ,h.hotel_id,h.h_name,h.h_slug,h.h_feature_image,h.h_description,h.h_address,h.star_rating,
            hr.hroom_id,hr.hr_name,hr.hr_image,hr.hr_max,min(hr.hr_base_rate) as base_rate
            FROM destinations as d LEFT JOIN hotels as h on h.dest_id=d.dest_id
            INNER JOIN hotel_rooms as hr ON h.hotel_id=hr.hotel_id
            GROUP BY h.hotel_id";
     $data['last_minute_deals_data']=$this->m_crud->get_by_sql($sql_deal);

      $data['footer']="inc/v_footer";
      $data['script_footer_home']="inc/v_script_footer_home";

      $data['services']=$this->m_crud->get_by_sql("SELECT * FROM services");


     /*   
        //total rows count
        $totalRec = count($this->post->getRows());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'posts/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->post->getRows(array('limit'=>$this->perPage));
        
        //load the view
        $this->load->view('posts/index', $data);

        */
        // Call Page

        $data['page']="home/v_home_front";
        // v_hotel_search_result.php
         // $data['page']="hotels/v_hotel_search_result";


        $this->load->view('v_template',$data);


    }
    
    function ajaxPaginationData(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->post->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'posts/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->post->getRows($conditions);
        
        //load the view
        $this->load->view('posts/ajax-pagination-data', $data, false);
    }
}