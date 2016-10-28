<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /*  login form  */
    public function index()
    {
        /*  login or not  */
        //$this->session_test();

        $this->load->view('login');
    }

    /*   logging   */
    public function entering()
    {

        $data = json_decode($this->input->post('trozan'),true);

        $this->load->model('login_model','l');

        $flag = $this->l->check_user_and_pass($data);

        if($flag)
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }

    /* forget form  */
    public function forgot()
    {
        /*  login or not  */
        $this->session_test();

        $data['page_name'] = 'forgot';

        $this->load->view('login/index',$data);
    }

    /* recovery mail  */
    public function retrive()
    {
        $this->load->model('email_model','e');
        $this->load->model('login_model','l');

        $email = $this->input->post('email');

        $data = $this->l->retrive_pass($email);

        if(sizeof($data) == '0')
        {
            echo '0';
        }
        else
        {
            $message = '<ul><li>email:'.$data['email'].'</li><li>password:'.$data['password'].'</li></ul>';

            $this->e->send_mail($data['email'],'Password Retrived',$message);

            echo '1';
        }
    }

    /*  logout    */
    public function logout()
    {
        /*$this->session->unset_userdata('admin_login');

        $cookie = array(
            'name'   => 'admin_login',
            'value'  => '1',
            'expire' => '',
            'path'   => '/',
        );

        $this->input->set_cookie($cookie);*/

        redirect(base_url().'login/','refresh');
    }

    /* session test  */
    public function session_test()
    {
        if($this->session->userdata('admin_login') == '1')
        {
            redirect(base_url().'controlle/','refresh');
        }
        else if($this->input->cookie('admin_login') == '1')
        {
            $this->session->set_userdata('admin_login',$this->input->cookie('admin_login'));
            $this->index();
        }
    }
}