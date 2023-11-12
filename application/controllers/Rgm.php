<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rgm extends CI_Controller {

	public function index()
	{
		if( ! isset($_SESSION['yf_user']))
			redirect(base_url(), 'refresh');

		$pagedata['title'] = 'Dashboard';
		$pagedata['page']  = 'dashboard';
		$this->load->view('default', $pagedata);
	}

	function navigator($page = '', $param='')
	{
		if( ! isset($_SESSION['yf_user'])) redirect(base_url(), 'refresh');

		$this->load->helper('file');
		$this->load->helper('path');
		$pager = set_realpath('application/views/admin/' . $page .'.php');
    $manager = ['dashboard', 'services', 'invoice', 'expenses', 'report_expenses', 'report_analysis', 'report_services'];
    $staff = ['dashboard', 'services', 'invoice', 'expenses'];
    $role = $this->session->userdata('yf_role');
    if (($role == 'Manager' && ! in_array($page, $manager)) OR ($role == 'Personnel' && !in_array($page, $staff)))
      redirect(base_url('not_found.aspx'), 'refresh');

		if (is_file($pager)) {
			$pagedata['title'] = $page;
			$pagedata['page']  = $page;
			$pagedata['this_id'] = $this->input->get('target');
			$this->load->view('default', $pagedata);
		} else {
			$pagedata['heading']  = 'Oops!';
			$pagedata['message']  = 'The page you tried to access does not exist.';
			$this->load->view('errors/html/error_404', $pagedata);
		}
	}

	function pullup($page, $param='', $param1='')
	{
    if ( ! $this->input->is_ajax_request()) redirect(base_url('not_found.aspx'));
    $this->load->helper('file');
    $this->load->helper('path');
    $pager = set_realpath('application/views/popups/' . $page .'.php');
    if (is_file($pager)) {
  		$page_data['this_id'] = $param;
  		$page_data['chip']    = $param1;
  		$this->load->view('popups/'.$page.'.php', $page_data);
    } else {
      exit('Oops! <br />The requested resource was not found');
    }
	}

  function password()
  {
    if ($this->session->userdata('yf_user') == '') exit('Request Failed');

    $user = $this->session->userdata('yf_user');
    $opass = $this->input->post('oldpass');
    $npass = $this->input->post('newpass');
    $cpass = $this->input->post('conpass');
    $response = '';
    if ($opass == null || $npass == null || $cpass == null) {
      exit(json_encode(['status'=>'error', 'message'=>'All fields are required']));
    } elseif ($npass !== $cpass) {
      exit(json_encode(['status'=>'error', 'message'=>'Passwords Mismatch']));
    } elseif (strlen($npass) < 6) {
      exit(json_encode(['status'=>'warning', 'message'=>'New password must have a minimum of 6 characters']));
    } elseif ($opass == $npass) {
      exit(json_encode(['status'=>'error', 'message'=>'New Password cannot be same as old one']));
    } else {
      $cpass = $this->rgm_model->find('admin', ['id'=>$user])->password ?? '';
      if ( ! password_verify('YF'.$opass, $cpass))
        exit(json_encode(['status'=>'error', 'message'=>'Old Password is incorrect']));

      $this->rgm_model->clean('admin', $user, ['password'=>password_hash('YF'.$npass, PASSWORD_DEFAULT)]);
      $this->session->set_flashdata('notetext', 'Password updated successfully');
      exit(json_encode(['status'=>'success', 'message'=>'']));
    }
  }
}