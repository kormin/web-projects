<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 16, 2016
 * Description: 
 * Resources: 
 * 
 */

require_once(dirname(__DIR__).'/assets/constants.php');


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Home - Database Manager</title>

		<meta name="description" content="programming challenge taken from /r/dailyprogrammer subreddit">
		<meta name="keywords" content="php,html5,forms,inputs">
		<link rel="author" href="https://github.com/kormin">
		<link href="<?php echo PATH.CSS; ?>/bootstrap.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="name" class="control-label col-sm-4">Enter name: </label>
					<div class="col-sm-8">
						<input type="text" id="name" class="form-control" name="name">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" id="submit" class="btn btn-default" >Send</button>
					</div>
				</div>
			</form>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo PATH.JS; ?>/jquery-2.2.3.min.js" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?php echo PATH.JS; ?>/bootstrap.min.js"></script> -->
		<script type="text/javascript">
			// variables

			$(document).ready(main());
			function main() {
				
			}
		</script>
	</body>
</html>