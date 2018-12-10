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

    public function submit_personal_info()
    {
        //To be added later(when adding the state saving functionality): check if the email already exists and the active field is 0, which implies
        //that the user is still not registered.-->unpdate existing and continue.

        $this->load->library('form_validation');
        // field name, error message, validation rules
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('email_address','Email Address', 'trim|required|valid_email|max_length[200]');
        $this->form_validation->set_rules('telephone', 'Telephone number', 'trim|required|min_length[4]|max_length[22]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password_confirm', 'Password confirmation', 'trim|required|matches[password]');

        if($this->form_validation->run() === FALSE)
        {
            $data['errors'] = 'validation_error';
            $this->load->view('errors_view', $data);
        }
        else
        {
            $inputs = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email_address' => $this->input->post('email_address'),
                'telephone' => $this->input->post('telephone'),
                'password' => md5($this->input->post('password'))
            );

            $this->load->model('useraccount_model');
            if($this->useraccount_model->add_new_user($inputs) === true)
            {
                //the account creation process was successful
                $data['message'] = 'success';
                $this->load->view('ajax_success', $data);
            }
            else
            {
                $data['errors'] = 'emailexists';
                $this->load->view('errors_view', $data);
            }
        }
    }
}

?>