<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		$this->load->model('menu/Menu_model');
		$this->load->model('settings/Config_model');
	}
	public function index(){
		
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){
			
			$config=$this->Config_model->Get_All();
			$data['logo']			=  $config['logo'];
			$data['situs']			=  $config['nama'];
			$data['author']			=  $config['pemilik'];
			$data['favicon']		=  $config['favicon'];
			$data['tema']			=  $config['tema'];
			$data['title']			=  "Semua Menu";
			
			$data['css']			= $this->load->view('css',$data,true);
			$data['js']				= $this->load->view('js',$data,true);
			$data['script']			= $this->load->view('script',$data,true);
			
			$data['content']		=  $this->load->view('list',$data,true);
			$this->load->view('admin/template',$data);
		}	
		else{
			redirect(site_url('adminweb'));
		}
	}
	public function primary(){
		
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){
			
			$config=$this->Config_model->Get_All();
			$data['logo']			=  $config['logo'];
			$data['situs']			=  $config['nama'];
			$data['author']			=  $config['pemilik'];
			$data['favicon']		=  $config['favicon'];
			$data['tema']			=  $config['tema'];
			$data['title']			=  "Primary Menu";
			$data['querypages']		=  $this->Menu_model->get_all_pages();
			$data['querykategori']	=  $this->Menu_model->get_all_kategori_blog();
			
			$data['css']			= $this->load->view('primary/css',$data,true);
			$data['js']				= $this->load->view('primary/js',$data,true);
			$data['script']			= $this->load->view('primary/script',$data,true);
			
			$data['tampilmenu']		=  $this->load->view('primary/tampilmenu',$data,true);
			$data['content']		=  $this->load->view('primary/primary',$data,true);
			$this->load->view('admin/template',$data);
		}	
		else{
			redirect(site_url('adminweb'));
		}
	}
	
	public function top(){
		
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){
			
			$config=$this->Config_model->Get_All();
			$data['logo']			=  $config['logo'];
			$data['situs']			=  $config['nama'];
			$data['author']			=  $config['pemilik'];
			$data['favicon']		=  $config['favicon'];
			$data['tema']			=  $config['tema'];
			$data['title']			=  "Top Menu ";
			$data['querypages']		=  $this->Menu_model->get_all_pages();
			$data['queryblog']		=  $this->Menu_model->get_all_kategori_blog();
			$data['queryproduk']	=  $this->Menu_model->get_all_kategori_produk();
			
			$data['css']			= $this->load->view('top/css',$data,true);
			$data['js']				= $this->load->view('top/js',$data,true);
			$data['script']			= $this->load->view('top/script',$data,true);
			
			$data['tampilmenu']		=  $this->load->view('top/tampilmenu',$data,true);
			$data['content']		=  $this->load->view('top/top',$data,true);
			$this->load->view('admin/template',$data);
		}	
		else{
			redirect(site_url('adminweb'));
		}
	}
	
	public function hapus($id) 
	{
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){
			
			$this->Menu_model->hapus($id);
			$this->session->set_flashdata('SUCCESSMSG','Menu Deleted Successfully!!');
			redirect(site_url('admin/menu'));
		}
		else{
			redirect(site_url('adminweb'));
		}
	}	
	public function hapusmenuid() 
	{
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){

			$id=$this->input->post('id');
			$this->Menu_model->hapus($id);
			$this->Menu_model->updateposisi($id);
			
		}
		else{
			redirect(site_url('adminweb'));
		}
	}	

	public function update_struktur()
	{
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){
			if(isset($_POST['output']))
			{
				$this->menu_lib->updatestructure();
			}
			else {
			    echo "ERROR!";
			}
		}
		else{
			redirect(site_url('adminweb'));
		}
	}

	function insertmenu(){
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){

			$menu 		= $this->input->post("nama");
			$type 		= $this->input->post("type");
			$url 		= $this->input->post("url");
			$menu_seo 	= slug($menu);
			
			if($this->db->query("INSERT INTO menu(nama_menu,type,url,menu_seo) VALUES ('$menu','$type','$url','$menu_seo')"))
			{
				echo json_encode(array("nama_menu"=>$menu,"type"=>$type,"url"=>$url));
			} 
			else {
				echo $this->db->error();
			}
		}
		else{
			redirect(site_url('adminweb'));
		}
		
	}

	public function addmenucustom(){
		$cek = $this->session->userdata('level')==01;
		if(!empty($cek)){

			$nama 		=$this->input->post("nama-menu-custom");
			$url 		=$this->input->post("url-menu-custom");
			$type 		=$this->input->post("type-menu-custom");
			
			$data['nama_menu']	=ucwords($nama);
			$data['type']		=$type;
			$data['menu_seo']	=slug($nama);
			if(empty($url)){
				$data['url']		= site_url();
			}else{
				$data['url']		= $url;
			}
			$this->Menu_model->add($data);

		}
		else{
			redirect(site_url('adminweb'));
		}
		
	}

	function tampilprimarymenu(){
		$this->load->view('primary/tampilmenu');
	}
	function tampiltopmenu(){
		$this->load->view('top/tampilmenu');
	}
	
}