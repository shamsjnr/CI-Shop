<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rgm_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function find ($tab, $arr) {
    $tab   = 'rgm_'.$tab;
    $this->db->where('deleted_at IS NULL');
    $query = $this->db->get_where($tab, $arr);
    if ( ! $query->num_rows() > 0) return false;
    return $query->row();
  }

  function find_all ($tab, $arr='') {
    $tab   = 'rgm_'.$tab;
    if (is_array($arr)) $this->db->where($arr);
    if ($arr == '' OR (is_array($arr) && ! array_key_exists('status !=', $arr))) $this->db->where('deleted_at IS NULL');
    $query = $this->db->get($tab);
    if ( ! $query->num_rows() > 0) return [];
    return $query->result_array();
  }

  function find_alls ($tab) {
    $tab = 'rgm_'.$tab;
    $query = $this->db->get($tab);
    if ( ! $query->num_rows() > 0) return [];
    return $query->result_array();
  }

  function find_count ($tab, $arr='') {
    $tab = 'rgm_'.$tab;
    if (is_array($arr)) $this->db->where($arr);
    return $this->db->count_all_results($tab);
  }

  function find_named ($tab, $arr, $chip='name') {
    $tab   = 'rgm_'.$tab;
    $this->db->where('status', 0);
    $query = $this->db->get_where($tab, $arr);
    return $query->row($chip);
  }

  function put ($tab, $data) {
    $tab  = 'rgm_'.$tab;
    $hash = md5('ISE'.time().random_bytes(4));
    $hash = [
      substr($hash, 0, 8), 
      substr($hash, 8, 4), 
      substr($hash, 12, 4), 
      substr($hash, 16, 4), 
      substr($hash, 20)
    ];
    $data['id'] = implode('-', $hash);
    if ( ! $this->db->insert($tab, $data)) return false;
    return true;
  }

  function clean ($tab, $chip, $data) {
    $tab = 'rgm_'.$tab;
    if (is_array($chip)) $this->db->where($chip);
    else $this->db->where('id', $chip);

    if ( ! $this->db->update($tab, $data)) return false;
    return true;
  }

  function dump ($tab, $where)
  {
    $tab = 'rgm_'.$tab;
    $this->db->where($where);
    if ( ! $this->db->update($tab, ['deleted_at'=>date('Y-m-d H:i:s')])) return false;
    return true;
  }
}
