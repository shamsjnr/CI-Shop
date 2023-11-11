<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['signin']                    = 'login/signin';
$route['upanel']                    = 'rgm';
$route['upanel/(:any)']             = 'rgm/navigator/$1';
$route['pull/(:any)']               = 'rgm/pullup/$1';
$route['pull/(:any)/(:any)']        = 'rgm/pullup/$1/$2';
$route['pull/(:any)/(:any)/(:any)'] = 'rgm/pullup/$1/$2/$3';
$route['password']                  = 'rgm/password';
$route['sys/(:any)']                = 'admin/$1';
$route['sys/(:any)/(:any)']         = 'admin/$1/$2';
$route['drop/(:any)/(:any)']        = 'admin/popdata/$1/$2';
$route['register']                  = 'rgm/register';
$route['signout']                   = 'login/signout';
$route['change_pass/(:any)']        = 'signin/password/$1';

