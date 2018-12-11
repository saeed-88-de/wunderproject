<?php

class Useraccount_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_new_user($user_inputs)
    {
        $this->db->select('id')->from('users')->where('email_address', $user_inputs['email_address'])->
        where('active', '1'); //implies: user is already registered.
        if($this->db->count_all_results() > 0)
        {
            return false;
        }
        $this->db->insert('users', $user_inputs);
        return $this->db->insert_id();
    }

    public function update_new_user($id, $reg_id, $data)
    {
        //this method to be used only for the registration process. (Not for updating an existing active user)
        $this->db->where('id', $id)->where('reg_token', $reg_id)->where('active', '0')->update('users', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function validate_login()
    {
        // to be added later.
    }
}

?>