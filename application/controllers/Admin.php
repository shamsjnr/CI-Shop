<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

    if ($this->session->userdata('yf_user') == '')
      redirect(base_url(), 'refresh');

		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
  }

  public function index()
  {
    // Nothing
    exit('Load Error!');
  }

  // MANAGE STAFF...
  function staff($param='')
  {
    if ( ! $this->input->is_ajax_request()) {
      http_response_code(400);
      exit('REQUEST FAILED!');
    }

    $role  = trim($this->input->post('role'));
    $name  = trim($this->input->post('title'));
    $phone = trim($this->input->post('phone'));

    if ($name == '' OR $role == '' OR $phone == '') 
      exit(json_encode(['status'=>'error', 'message'=>'All fields are required']));
      
    $data['role']  = $role;
    $data['name']  = $name;
    $data['phone'] = $phone;

    if ($param == '') {
      $uid = $this->rgm_model->find_count('admin') + 1001;
      $uid = substr($uid, 1);
      $data['username'] = "JR{$uid}";
      $data['password'] = password_hash('YFstaff', PASSWORD_DEFAULT);
      $this->rgm_model->put('admin', $data);
    } else {
      $this->rgm_model->clean('admin', $param, $data);
    }
    $this->session->set_flashdata('notetext', 'Record '. ($param == '') ? 'inserted' : 'updated');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  // MANAGE SERVICES...
  function service($param='')
  {
    if ( ! $this->input->is_ajax_request()) {
      http_response_code(400);
      exit('REQUEST FAILED!');
    }

    $more  = trim($this->input->post('description'));
    $name  = trim($this->input->post('title'));
    $price = trim($this->input->post('price'));

    if ($name == '' OR $price == '') 
      exit(json_encode(['status'=>'error', 'message'=>'Service name and price are required']));
    if ( ! is_numeric($price) OR $price < 10) exit(json_encode(['status'=>'error', 'message'=>'Enter a valid Service price']));
    $service = $this->rgm_model->find('services', ['id !='=>$param, 'name'=>$name]);
    if ($service) exit(json_encode(['status'=>'error', 'message'=>'"'.strtoupper($name).'" already exists']));
      
    $data['more']  = $more;
    $data['name']  = $name;
    $data['price'] = $price;

    if ($param == '') $this->rgm_model->put('services', $data);
    else $this->rgm_model->clean('services', $param, $data);

    $this->session->set_flashdata('notetext', 'Record '. ($param == '') ? 'inserted' : 'updated');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  // MANAGE SERVICE TASKS...
  function tasks($param='')
  {
    if ( ! $this->input->is_ajax_request()) {
      http_response_code(400);
      exit('REQUEST FAILED!');
    }

    if ($param === 'add') {
      $code = trim($this->input->post('code'));
      $service = trim($this->input->post('item'));
      $quantity = trim($this->input->post('quantity'));

      if (trim($this->input->get('voucher')) == '') exit(json_encode(['status'=>'error', 'message'=>'A fatal error occurred. <br />Please refresh']));
      if ($code == '' OR $service == '' OR $quantity == '') exit(json_encode(['status'=>'error', 'message'=>'Fill in all details']));
      $service = $this->rgm_model->find('services', ['id'=>$service]);
      if ( ! $service) exit(json_encode(['status'=>'error', 'message'=>'Invalid data received']));
        
      $data['amount'] = $service->amount;
      $data['voucher'] = $this->input->get('voucher');
      $data['task_id'] = $code;
      $data['service'] = $service->id;
      $data['quantity'] = $quantity;

      if ($param == 'add') $this->rgm_model->put('tasks', $data);
      else $this->rgm_model->clean('tasks', $param, $data);

      exit(json_encode([
        'status'=>'success', 
        'message'=>$this->load->view('popups/admin/tasks', ['uuid'=>$data['voucher']], true)
      ]));
    } elseif ($param == 'drop') {
      $task = $this->rgm_model->find('tasks', ['id'=>$this->input->get('target')]);
      if ( ! $task) exit(json_encode(['status'=>'error', 'message'=>'Failed to delete']));

      // handle payment
      $count = $this->rgm_model->find_count('tasks', ['voucher'=>$task->voucher, 'voucher !='=>'']);
      if ($count == 1) $this->rgm_model->dump('payments', ['service'=>$task->voucher]);
      // end handler

      $this->rgm_model->dump('tasks', ['id'=>$task->id]);
      exit(json_encode(['status'=>'success', 'message'=>'']));
    } elseif ($param == 'save') {
      $service = $this->rgm_model->find('tasks', ['voucher'=>$this->input->get('target')]);
      if ( ! $service) exit(json_encode(['status'=>'error', 'message'=>'Invalid data received. <br />Refresh and try again']));

      $name = trim($this->input->post('name'));
      $dated = trim($this->input->post('date')) ?: date('Y-m-d');
      $phone = trim($this->input->post('phone'));
      $remark = trim($this->input->post('remark'));

      if ($phone == '' OR $name == '') exit(json_encode(['status'=>'error', 'message'=>'Fill in service details']));
      $data = [
        'name'   => $name,
        'date'   => $dated,
        'phone'  => $phone,
        'remark' => $remark
      ];
      if ( ! $this->rgm_model->clean('tasks', ['voucher'=>$service->voucher], $data)) 
        exit(json_encode(['status'=>'error', 'message'=>'An error occurred with the update']));
    } elseif ($param == 'delete') {
      $task = $this->rgm_model->find('tasks', ['voucher'=>$this->input->get('target')]);
      if ( ! $task) exit(json_encode(['status'=>'error', 'message'=>'Failed to delete']));

      $this->rgm_model->dump('payments', ['service'=>$task->voucher]);
      $this->rgm_model->dump('tasks', ['voucher'=>$task->voucher]);
      exit(json_encode(['status'=>'success', 'message'=>'']));
    }

    $this->session->set_flashdata('notetext', 'Saved Successfully');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  // MANAGE PAYMENTS ...
  function payment($param='')
  {
    $service = trim($this->input->post('service'));
    $amount = trim(str_replace(',', '', $this->input->post('amount')));
    $amount = str_replace(' ', '', $amount);
    $dated = trim($this->input->post('dated'));
    if ( ! $this->rgm_model->find('tasks', ['voucher'=>$service])) exit(json_encode(['status'=>'error', 'message'=>'An unknown error occurred']));
    if ($dated == '' OR $amount == '') exit(json_encode(['status'=>'error', 'message'=>'Fill in all details']));
    if ($dated > date('Y-m-d')) exit(json_encode(['status'=>'error', 'message'=>'Invalid date supplied']));
    if ( ! is_numeric($amount) OR $amount < 100) exit(json_encode(['status'=>'error', 'message'=>'Payment amount is invalid']));

    $opay = $this->rgm_model->find('payments', ['id'=>$param])->amount ?? 0;
    $this->db->select_sum('amount');
    $pay = $this->rgm_model->find('payments', ['service'=>$service])->amount ?? 0;
    $pay -= $opay;
    $this->db->select('SUM(`amount` * `quantity`) AS total');
    $sum = $this->rgm_model->find('tasks', ['voucher'=>$service])->total;

    if (($pay + $amount - $sum) > 0) 
      exit(json_encode(['status'=>'warning', 'message'=>'New Payment: <b>N'. number_format($amount) .'</b> + Current Balance: <b>N'. number_format($pay) .'</b><br /> exceeds service Total of: <b>N'. number_format($sum) .'</b>']));

    $data = [
      'service' => $service,
      'amount'  => $amount,
      'date'    => $dated
    ];

    if ($param == '') $this->rgm_model->put('payments', $data);
    else $this->rgm_model->clean('payments', $param, $data);

    $this->session->set_flashdata('notetext', 'Record '. ($param == '') ? 'inserted' : 'updated');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  // MANAGE EXPENSE CATEGORIES...
  function category($param='')
  {
    if ( ! $this->input->is_ajax_request()) {
      http_response_code(400);
      exit('REQUEST FAILED!');
    }

    $more  = trim($this->input->post('description'));
    $name  = trim($this->input->post('title'));

    if ($name == '') exit(json_encode(['status'=>'error', 'message'=>'Enter Category name']));
    $cat = $this->rgm_model->find('categories', ['id !='=>$param, 'name'=>$name]);
    if ($cat) exit(json_encode(['status'=>'error', 'message'=>'"'.strtoupper($name).'" already exists']));
      
    $data['more'] = $more;
    $data['name'] = $name;

    if ($param == '') $this->rgm_model->put('categories', $data);
    else $this->rgm_model->clean('categories', $param, $data);

    $this->session->set_flashdata('notetext', 'Record '. ($param == '') ? 'inserted' : 'updated');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  // MANAGE EXPENSES...
  function expenses($param='')
  {
    if ( ! $this->input->is_ajax_request()) {
      http_response_code(400);
      exit('REQUEST FAILED!');
    }

    $cat = trim($this->input->post('category'));
    $date = trim($this->input->post('dated'));
    $descr = trim($this->input->post('description'));
    $amount = trim($this->input->post('amount'));

    if ($cat == '' OR $date == '' OR $amount == '') 
      exit(json_encode(['status'=>'error', 'message'=>'Fill in all required fields']));
    if ( ! is_numeric($amount) OR $amount < 100) exit(json_encode(['status'=>'error', 'message'=>'Enter a valid amount']));
    if ( ! $this->rgm_model->find('categories', ['id'=>$cat])) exit(json_encode(['status'=>'error', 'message'=>'Invalid data received']));
      
    $data['date'] = $date;
    $data['more'] = $descr;
    $data['amount'] = $amount;
    $data['category'] = $cat;

    if ($param == '') {
      $data['staff'] = $this->session->userdata('yf_user');
      $this->rgm_model->put('expenses', $data);
    }
    else $this->rgm_model->clean('expenses', $param, $data);

    $this->session->set_flashdata('notetext', 'Record '. ($param == '') ? 'inserted' : 'updated');
    $this->session->set_flashdata('notecolor', 'success');
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  function sess($param)
  {
    $k = $this->input->get('key');
    $v = $this->input->post('data');
    if ($param == 'set')
      $this->session->set_userdata($k, $v);
    else
      unset($_SESSION[$k]);
    echo json_encode(['status'=>'success', 'message'=>'']);
  }

  function popdata($table, $param='')
  {
    $key = $this->input->get('k');
    if (!is_array($param) && $this->rgm_model->find($table, ['id'=>$param]))
      $this->rgm_model->dump($table, ['id'=>$param]);
    elseif (is_array($param) && $this->rgm_model->find($table, $param))
      $this->rgm_model->dump($table, $param);
    elseif ($key != '' && $this->rgm_model->find($table, [$key=>$param]))
      $this->rgm_model->dump($table, [$key=>$param]);
    else
      exit('Error!');

    $this->session->set_flashdata('notecolor', 'success');
    $this->session->set_flashdata('notetext', 'Record Deleted!');
    if (strstr(current_url(), '/drop/') != '') echo json_encode(['status'=>'success', 'message'=>'']);
  }
}
