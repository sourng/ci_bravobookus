<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Management class created by CodexWorld
 */
class Features extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    public function index(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function features_icon(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_icon";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function features_form(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_form";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function features_icon_effects(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_icon_effects";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function features_elements(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_elements";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function feature_grid(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_grid";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
     public function feature_hovers(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_hovers";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }

     public function feature_lightbox(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_lightbox";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
    public function feature_media(){

        $data = array();
      
        $data['style_home']="inc/v_style_home";
        $data['header_top']="inc/v_header_top";
        $data['nav']="inc/v_nav";
        $data['page']="features/v_features_media";
        $data['footer']="inc/v_footer";
        $data['script_footer_home']="inc/v_script_footer_home";

        $this->load->view('v_template_features',$data);
    }
}
   