<?php

class User_account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('authenticate');
        if($this->authenticate->is_logged_in() === true)
        {
            redirect('home');
            die;
        }
    }

    public function personal_info()
    {
        $data['title']='Signup';
        $this->load->view('includes/header', $data);
        $this->load->view('personal_info');
        $this->load->view('includes/footer');
    }
}

?>