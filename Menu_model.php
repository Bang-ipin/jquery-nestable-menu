<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {
  
	public function get_all_menu_parent(){
		return $this->db->order_by('id','asc')
					->get('menu_parent')
					->result_array();
	}
	public function get_all_menu(){
		return $this->db->order_by('id_menu','asc')
					->get('menu')
					->result_array();
	}
	
	public function dd_parent(){
	$this->db->where('id_parent',0);
	$this->db->order_by('id_menu');
	$query=$this->db->get('menu');
	$dd['0']='Menu&nbsp;Root';
	if($query->num_rows()>0){
		foreach($query->result() as $row){
			$dd[$row->id_menu]= $row->nama_menu;
			}
		}
		return $dd;
	}
	
	function add($data){
		$query=$this->db->insert('menu',$data);
		return $query;
	}
	
	function update($id,$data){
	$this->db->where('id_menu',$id);
	$this->db->update('menu',$data);
	}
	
	function hapus($id) {
		$this->db->where('id_menu',$id);
		$this->db->delete('menu');
	}
	
	function updateposisi($id) {
		$this->db->where('menu_parent',$id);
		$this->db->set('menu_parent',0);
		$this->db->update('menu');
	}
	public function get_all_kategori_blog(){
		return $this->db->get("kategori")
						->result_array();
	}
	public function get_all_kategori_produk(){
		return $this->db->where('parent_id',0)
						->where('status',1)
						->get("kategori_produk")
						->result_array();
	}
	public function get_all_pages(){
		return $this->db->order_by('id','asc')
					->get('laman')
					->result_array();
	}
}
