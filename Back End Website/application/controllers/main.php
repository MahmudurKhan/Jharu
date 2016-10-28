<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class main extends CI_Controller {
		public function index()
    		{
			if($this->session->userdata('admin_login') == '1')
			{
			    $this->load->view('map_view');
			}
			else
			{
			    redirect(base_url().'index.php/login/','refresh');
			}
    		}

		public function advance_map()
		{

			$this->load->view('advance_map');
		}

		public function insert_geolocation($lat,$lng)
		{
			header('Access-Control-Allow-Origin:*');

			$this->load->model('map_model','m');

			$data = array('lat'=>$lat,'lng'=>$lng);

			if($this->m->insert_data($data))
			{
				echo '1';
			}
			else{
				echo '0';
			}
		}

		public function generating_xml()
		{
			$this->load->model("map_model",'m');

			$data = $this->m->get_data();

			if(sizeof($data) > 0)
			{
				header("Content-type:text/xml");

				$str = '<?xml version="1.0" encoding="utf-8" ?>';
				$str = $str.'<main>';
				$min = '';

				foreach ($data as $d) {
					$min = $min.'<point id="'.$d['id'].'" lat="'.$d['lat'].'"  long="'.$d['lng'].'"></point>';
				}

				$str = $str.$min.'</main>';

				echo $str;
			}
		}

		public function deleting_point($id)
		{
			$this->load->model('map_model','m');

			if($this->m->delete_data($id))
			{
				redirect(base_url().'index.php/main','refresh');
			}
			else
			{
				echo "error on the server";
			}
		}
	}

?>
