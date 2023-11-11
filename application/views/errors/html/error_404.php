<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image" href="<?= config_item('base_url') . 'assets/images/favicon.png'; ?>">
	<title>Page Not Found</title>
	<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Radio+Canada&display=swap');
	* {
		padding: 0;
		box-sizing: border-box;
	  font-family: 'Radio Canada', sans-serif;
	}
	html, body {
		margin: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .6);
	}
	body {
		display: flex;
		justify-content: center;
		align-items: center;
		color: #f2f2f2;
	}
	h1 {
		margin: 0;
		position: absolute;
		top: 0; left: 0; right: 0;
		text-align: left;
		padding: 24px;
		color: #acacac;
		background-color: rgba(0, 0, 0, .15);
		font-weight: normal;
	}
	#container {
		margin: 48px 0;
		padding: 12px 24px;
		text-align: center;
		box-shadow: 0 0 8px #222;
	}
	</style>
</head>
<body>
	<div id="container">
		<h1>Oops!</h1>
		<div>
			<h3><?= $heading; ?></h3>
			<?= $message; ?>
		</div>
	</div>
</body>
</html>
<?php exit(); ?>
