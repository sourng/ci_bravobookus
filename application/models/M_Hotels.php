<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Hotels extends CI_Model{
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('v_list_hotels');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('h_name',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('h_name',$params['search']['sortBy']);
        }else{
            $this->db->order_by('star_rating','desc');
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function FindRows($params = array()){

       // $order_by=$params['start'];

        $this->db->select('*');
        $this->db->from('v_list_hotels');

        //$this->db->join('hotel_rooms AS hr','h.hotel_id=hotel_rooms.hotel_id','left');
        if(array_key_exists("starorder",$params)){
            $this->db->where('star_rating',$params['starorder']);
        }else{
            //$this->db->where('star_rating',4);
        }
        $this->db->where('destinations',$params['find']);

       // $this->db->order_by('star_rating','desc');
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        //$query = $this->db->get();
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
    

function get($limit=5, $start=0, $orderby="id", $order="ASC"){
             $this->db->select('*');
             $this->db->from('v_list_hotels');
        
		//$this->db->select('item_id as id, items.name as name, models.name as model, brands.name as brand, created_at as date_added');
		//$this->db->from('items');
		//$this->db->join('models', 'items.model_id = models.model_id');
		//$this->db->join('brands', 'items.brand_id = brands.brand_id');
		$this->db->limit($limit, $start);
		//$this->db->order_by($orderby, $order);
		$query = $this->db->get();
		return $query->result_array();
    }
    
    function itemsCount(){
		return $this->db->count_all_results('items');
    }




    //Count all student records
     public function HotelsCount()
     {
        return $this->db->count_all_results('v_list_hotels');
     }
     
     //Get students
     public function getHotels ($limit,$offset)
     {
         $this->db->select('*');
         $this->db->from('v_list_hotels');

       $this->db->limit($limit, $offset);
        //$this->db->order_by($orderby, $order);
        $query = $this->db->get();
        return $query->result_array();
     }


public function InsertData($table,$data)
    {
        $this->db->insert($table,$data);
        return $insert_id = $this->db->insert_id();
    }



     /*
     * Paginations
    */
    public function paginations($pages, $current_page)
    {
        $view=NULL;
        $view .='<ul class="pagination" id="pagination">';
        
            if ($pages > 1)
            {
                //Previous
                if($current_page == 1)
                {
                    $view .='<li><a  onclick="pagination();" rel="'. $current_page .'">&lsaquo;&lsaquo; Previous</a></li>';
                }
                else
                {
                    $previous=$current_page-1;
                    $view .='<li><a  onclick="pagination();" rel="'. $previous .'">&lsaquo;&lsaquo; Previous</a></li>';
                }
                
                //First = num 1 
                if($current_page>6)
                    $view .= '<li><a  onclick="pagination();" rel="1">1...</a></li>';
                
                $num_links  = 5;
                $start = (($current_page - $num_links) > 0) ? $current_page - ($num_links - 1) : 1;
                $end   = (($current_page + $num_links) < $pages) ? $current_page + $num_links : $pages;
                if($start==1) 
                    $start=$start; 
                else 
                    $start=$start-1;
                    
                //Loop pages
                for($i=$start; $i<=$end; $i++)
                {
                    if($i == $current_page)
                    $view .='<li><a href="" class="current" rel="'. $i .'">'. $i .'</a></li>';
                    else
                    $view .='<li><a href="" rel="'. $i .'">'. $i .'</a></li>';
                }
                
                //Last = num of last page   
                if($current_page<$pages-5)
                    $view .= '<li><a  href="" rel="'.$pages.'">...'.$pages.'</a></li>';
                
                //Next
                if($current_page == $pages) 
                {
                    $view .='<li><a  href="" rel="'. $pages .'">Next &rsaquo;&rsaquo;</a></li>';
                }
                else
                {
                    $next=$current_page+1;
                    $view .='<li><a  href="" rel="'. $next .'">Next &rsaquo;&rsaquo;</a></li>';
                }
            }
        $view .='</ul>';
        
        return $view;
    }
    
}