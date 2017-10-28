<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('M_Hotels','mh',TRUE);
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

     $data['form_title']=$this->replaceAll($this->uri->segment(1));

        $data['head']='admin/inc/v_dashboard_head';
        $data['footer']='admin/inc/v_dashboard_footer';
        $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';
        

        $data['header']='admin/inc/v_header';
        $data['main_content']='admin/dashboard/v_dashboard';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }
// Booking
public function booking()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
     $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='All Bookings';

        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['main_content']='admin/booking/v_booking';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }
// List Hotel

public function list_hotels()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']=$this->uri->segment(1);

        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['main_content']='admin/hotels/v_list';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }


    // Guests
public function guests()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='All Guests';


        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['main_content']='admin/guests/v_guests';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }


// Profile
public function profile()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='User Profile';

        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['main_content']='admin/users/v_profile';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }
// End Profile

// Invoice Print
public function invoice_print()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='User Profile';

        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          // $data['sidebar']='admin/inc/v_sidebar';
        $data['sidebar']=null;
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['main_content']='admin/inc/v_invoice_print';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }
// End Invoice Print
    
// Hotel Managment
// Add New Hotel
    public function add_hotels()
    {
      
      $data=array();
 $data['settings']=$this->m_crud->get_by_sql("SELECT * FROM settings");
      $data['form_title']=$this->replaceAll($this->uri->segment(1));
      $data['panel_title']='User Profile';

        $data['head']='admin/head/v_head_table';
        $data['footer']='admin/footer/v_footer_table';

          $data['sidebar']='admin/inc/v_sidebar';
          $data['sidebar_right']='admin/inc/v_sidebar_right';        

        $data['header']='admin/inc/v_header';

        $data['facilities']=$this->m_crud->get_by_sql("SELECT * FROM facilities");
         $data['showfacil']=$this->m_crud->get_by_sql("SELECT * FROM test_add where id=15 ");


        $data['main_content']='admin/hotels/v_add';
        //load the view
        $this->load->view('admin/v_admin_template', $data);

        echo "Admin Dashboard";
    }


     /****MANAGE HOTELs*****/
    function new_hotel($param1 = '', $param2 = '')
    {
        // if ($this->session->userdata('admin_login') != 1)
        //     redirect(base_url(), 'refresh');
      
      // foreach ($facilities as $value) {
      //   $value.=$value;
      // }



        if ($param1 == 'create') {
            $data['field1']         = $this->input->post('name1');
            $data['field2'] = substr(implode('', $this->input->post('facilities')), 0);
            $data['field3']   = $this->input->post('name3');
            $this->db->insert('test_add', $data);

            // $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'add-hotels.html', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            $data['name_numeric'] = $this->input->post('name_numeric');
            $data['teacher_id']   = $this->input->post('teacher_id');

            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'add-hotels.html', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        // $page_data['classes']    = $this->db->get('class')->result_array();
        // $page_data['page_name']  = 'class';
        // $page_data['page_title'] = get_phrase('manage_class');
        // $this->load->view('backend/index', $page_data);
    }





// End Hotel Management
















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