<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();

    if (strstr(current_url(), 'signout') == '' && $this->session->userdata('yf_user') != null)
      redirect(base_url('upanel'), 'refresh');
    $this->load->model('login_model');
  }

	public function index()
	{
		$this->load->view('login');
	}

  function signin()
  {
    if ($this->session->userdata('yf_user') != '')
      redirect(base_url(), 'refresh');

    $user = $this->input->post('miuser');
    $pass = $this->input->post('mipass');
    if ($user == null OR $pass == null) exit(json_encode(['status'=>'error', 'message'=>'Fill in both fields']));

    $login = $this->login_model->login($user, $pass);
    if (!$login) exit(json_encode(['status'=>'error', 'message'=>'No matching record for supplied login details']));

    $name = explode(' ', $login->name)[0];
    $_SESSION['yf_name'] = $name;
    if ($login->role == 'Admin') $_SESSION['yf_admin'] = true;
    // $_SESSION['yf_branch'] = $login->branch;
    $_SESSION['yf_user'] = $login->id;
    echo json_encode(['status'=>'success', 'message'=>'Logged in. Redirecting...']);
  }

  function signout()
  {
    session_destroy();
    session_unset();
    unset($_SESSION);
  }
}
