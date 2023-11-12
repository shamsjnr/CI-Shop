<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $xdate = $this->session->userdata("x_{$page}");
  $ydate = $this->session->userdata("y_{$page}");
  if ($xdate != '' OR $ydate != '') {
    $dater = $xdate ? date('d F, Y', strtotime($xdate)) : 'First Usage';
    $dater .= ' &nbsp; - &nbsp; ';
    $dater .= $ydate ? date('d F, Y', strtotime($ydate)) : 'Today';
    if (date('Y-m', strtotime($xdate)) == date('Y-m', strtotime($ydate)))
      $dater = date('d', strtotime($xdate)) .'&nbsp; - &nbsp;'. date('d F, Y', strtotime($ydate));
  } else {
    require('report_date.php');
  }
?>
