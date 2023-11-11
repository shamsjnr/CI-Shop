<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Login_model extends CI_Model {

  function __construct() {
      parent::__construct();
  }

  function login($user, $password) 
  {
    $user = $this->db->get_where('rgm_admin', ['username'=>$user]);
    $pass = 'YF'.$password;
    if (!($user->num_rows() > 0) OR !password_verify($pass, $user->row('password'))) return false;
    return $user->row();
  }
}
