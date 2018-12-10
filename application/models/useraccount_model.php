<?php

class Useraccount_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function add_new_user($user_inputs)
    {
        $this->db->select('id')->from('users')->where('email_address', $user_inputs['email_address'])->
        where('active', '1'); //implies: user is already registered.
        if($this->db->count_all_results() > 0)
        {
            return false;
        }
        return $this->db->insert('users', $user_inputs);
    }

    public function validate_login()
    {
        // to be added later.
    }
}

?>