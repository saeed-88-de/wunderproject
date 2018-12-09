<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('authenticate');
		if(!$this->authenticate->is_logged_in())
		{
			redirect('user_account/login');
			die();
		}
	}
	
	public function index()
	{
		$data['title'] = 'Home';
		$data['content'] = 'Welcome! You are logged in.';
		$this->load->view('includes/header', $data);
		$this->load->view('home');
		$this->load->view('includes/footer');
	}

	public function install()
	{
		$this->load->model('install_model');
		$this->install_model->create_db();
		$this->install_model->create_tables();
	}
}
