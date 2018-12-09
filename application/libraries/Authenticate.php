<?php
// this is a custom created library
if( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Authenticate
{
    // if we want to pass parameters to the class we just write a constructor.
    public function __construct(/* $params */)
    {
        // do something with params (if any)
        $this->CI =& get_instance();//This is very important. Assigning by reference allows us to use the original CodeIgniter object rather than creating a copy of it.
        $this->CI->load->library('session');
    }

    public function is_logged_in()
    {
        /*To access CodeIgniter's native resources within your library use the get_instance() function. This
          function returns the CodeIgniter super object; instead of using $this $this */

          $is_logged_in = $this->CI->session->userdata('is_logged_in');

          if(!isset($is_logged_in) || $is_logged_in !== true)
          {
              return false;
          }
          return true;
    }

    public function is_admin()
    {
        // admin functionality to be added later.
    }
}

?>