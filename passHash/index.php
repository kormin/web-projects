<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 23, 2016
 * Description: 
 * Resources: 
 * http://stackoverflow.com/questions/573184/java-convert-string-to-valid-uri-object
 * http://php.net/manual/en/function.urlencode.php
 * http://stackoverflow.com/questions/11024225/open-url-with-php
 */

require_once('../../assets/index.php');

if (!empty($_GET['submit'])) {
	$passw = $_GET['passw'];
	echo password_hash($passw, PASSWORD_BCRYPT);
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Password Hash</title>

		<meta name="description" content="Program to display capital cities">
		<meta name="keywords" content="php,html5,forms,inputs">
		<link rel="author" href="https://github.com/kormin">
		<link href="<?=TWBS; ?>" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<h1>PASSWORD_BCRYPT</h1>
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="passw" class="control-label col-sm-4">Enter password: </label>
					<div class="col-sm-8">
						<input type="text" id="passw" class="form-control" name="passw">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" id="submit" class="btn btn-default" name="submit" value="submit">search</button>
					</div>
				</div>
			</form>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- <script src="<?=JQRY; ?>" type="text/javascript"></script> -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?=TWBS_JS; ?>"></script> -->
		<script type="text/javascript">
			// variables
		</script>
	</body>
</html>