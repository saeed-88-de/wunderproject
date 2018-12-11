<?php

class User_account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('authenticate');
        $this->load->model('useraccount_model');
        $this->load->helper('cookie');
        if($this->authenticate->is_logged_in() === true)
        {
            redirect('home');
            die();
        }
    }

    public function personal_info()
    {
        $data['title']='Signup';
        $this->load->view('includes/header', $data);
        $this->load->view('personal_info');
        $this->load->view('includes/footer');
    }

    public function address_info()
    {
        if( !( $this->input->cookie('id') && $this->input->cookie('reg_token') ))
        {
            redirect(get_class().'/personal_info');
            die();
        }
        $data['title']='Signup - step2';
        $this->load->view('includes/header', $data);
        $this->load->view('address_info');
        $this->load->view('includes/footer');
    }

    public function submit_personal_info()
    {
        //To be added later(when adding the state saving functionality): check if the email already exists and the active field is 0, which implies
        //that the user is still not registered.-->unpdate existing and continue.

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
                'password' => md5($this->input->post('password')),
                'reg_token' => uniqid("", true) /* remove the reg_token for this user from database and from cookies after a complete regiteration.also remove id cookie. */
            );

            $insert_id = $this->useraccount_model->add_new_user($inputs);
            if($insert_id !== false)
            {
                //the account creation process was successful
                $expire = 7200;
                $data['message'] = 'success';
                set_cookie('reg_token', $inputs['reg_token'], $expire);
                set_cookie('id', $insert_id, $expire);
                $this->load->view('ajax_success', $data);
            }
            else
            {
                $data['errors'] = 'emailexists';
                $this->load->view('errors_view', $data);
            }
        }
    }

    public function submit_address_info()
    {
        $this->form_validation->set_rules('street', 'Street', 'trim|required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('house_number', 'House number', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('zip_code', 'Zip code', 'trim|required|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|min_length[2]|max_length[50]');

        if($this->form_validation->run() === FALSE)
        {
            $data['errors'] = 'validation_error';
            $this->load->view('errors_view', $data);
        }
        else
        {
            $inputs = array(
                'street' => $this->input->post('street'),
                'house_number' => $this->input->post('house_number'),
                'zip_code' => $this->input->post('zip_code'),
                'city' => $this->input->post('city')
            );

            //if($this->useraccount_model->update_user($accessToken, ))
            if($this->useraccount_model->update_new_user(get_cookie('id'), get_cookie('reg_token'), $inputs) === true)
            {
                // user update was successful
                $data['message'] = 'success';
                $this->load->view('ajax_success', $data);
            }
            else
            {
                $data['errors'] = 'A problem occured while trying to insert address information! Or no changes to update(because when there are 
                no changes to the data entries, the update() function will take no effect and therefore the affected_rows() function will retrun 0)';
                $this->load->view('errors_view', $data);
            }
            
        }
    }
}

?>