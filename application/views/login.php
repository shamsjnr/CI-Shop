<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/toaster/toast.style.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/login.css'); ?>">
<link rel="icon" type="image" href="<?= base_url('assets/images/favicon.png'); ?>" />
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= base_url('assets/toaster/toast.script.js') ?>" defer></script>
<script type="text/javascript" src="<?= base_url('assets/js/login.js') ?>" defer></script>
<style>
</style>
<title>YFarms</title>
</head>
<body>
  
<div id="overlay"></div>
<div id="feed"></div>
<div style="display: flex; justify-content: center; align-items: center; position: absolute; top: 0; bottom: 0; left: 0; right: 0;">
  <div class="container" style="max-width: 420px;">
    <?= form_open('login', ['class'=>'myForm', 'id'=>'myForm', 'autocomplete'=>'off']); ?>
    <div class="group hide"><input type="text" class="input" name="miuser" id="user" required/><label class="mb-0" for="user">username </label></div>
    <div class="group hide"><input type="password" class="input" name="mipass" id="pass" required/><label class="mb-0" for="pass">password </label></div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <button class="btn" id="submit" data-ref="<?= base_url('signin') ?>">Login</button>
    </div>
    <?= form_close(); ?>
  </div>
  <div style="text-align: center; color: #ccc; font-size: .9rem; position: absolute; bottom: 0; padding: 12px 0">
     <em>Powered by</em> <a href="https://ionicbitz.net" target="_blank" style="text-decoration: none; color: rgba(63,63,55,1);">ionicBitz</a>
  </div>
</div>
</body>
</html>
