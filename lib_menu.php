<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_menu {
	protected $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}

	private function run_array_parent($array, $parent){  
        $post_db = array();    
        foreach(@$array as $head => $body)
        {
            if(isset($body->children))
            {
                $head++;
                $post_db[$body->id] = ['parent'=>$parent,'order'=>$head];
                $post_db            = $post_db + $this->run_array_parent($body->children, $body->id);
            } else {
                $head++;
                $post_db[$body->id] = ['parent'=>$parent,'order'=>$head];
            }
        }
        return $post_db;
    }

	public function updatestructure($param = 0)
    {
        //Creating from_db unnested array
        $from_db = array();
        $query = $this->CI->db->query("SELECT * FROM menu WHERE menu_parent != '0'");
        foreach($query->result() as $row):
            $from_db[$row->id_menu] = ['parent'=>$row->menu_parent,'order'=>$row->posisi];
        endforeach;
        //Creating the post_db unnested array
        $post_db = array();
        $array = json_decode($_POST['output']);
        $post_db = $this->run_array_parent($array,'0');
        //Comparing the arrays and adding changed values to $to_db
        $to_db =array();
        foreach($post_db as $key => $value):
        
            if( !array_key_exists($key,$from_db) || ($from_db[$key]['parent'] != $value['parent']) || ($from_db[$key]['order'] !=$value['order']))
            {
                $to_db[$key] = $value;
            }  
       endforeach;
        // Generate Query
        if (count($to_db) > 0)
        {
            $query          = "UPDATE menu";
            $query_parent   = " SET menu_parent = CASE id_menu";
            $query_order    = " posisi = CASE id_menu";
            $query_ids      = " WHERE id_menu IN (".implode(", ",array_keys($to_db)).")";
            foreach ($to_db as $id => $value):
                $query_parent .= " WHEN ".$id." THEN ".$value['parent'];
                $query_order  .= " WHEN ".$id." THEN ".$value['order'];
            endforeach;
            $query_parent .= " END,";
            $query_order  .= " END";
            $query = $query.$query_parent.$query_order.$query_ids;
            //Executing query
            $this->CI->db->query($query);
        }
    }
}