<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact extends CI_Controller
{
	public function index()
	{
		$this->load->view('contact');
	}


/*   mail   */
    public function sending()
    {

        $data = json_decode($this->input->post('trozan'),true);

        $this->load->model('contact_model','l');

        $msg = '<div>Email:'.$data['email'].'</div><div>message:'.$data['msg'].'</div>';

        $flag = $this->l->send_mail('mahmudur@itechoid.com','message from visitor',$msg);

        if($flag)
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
}

?>