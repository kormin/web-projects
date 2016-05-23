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

// require_once(__DIR__.'/assets/constants.php');
require_once(dirname(__DIR__).'/assets/constants.php');

$dist = 140;
$_SESSION['state'] = 'Error';
session_start();

function getPrng($dist) {
	do{
		$max = rand();
		$min = rand(0, $dist);
		$tp = $max - $min;
	}while($tp > $dist || $min > $max || $max < $dist);
	$rnd = rand($min, $max);
	$_SESSION['max'] = $max;
	return $rnd;
}

function status($num) {
	if ($num == $_SESSION['num']) {
		$state = 'correct';
	}elseif ($num > $_SESSION['num']) {
		$state = 'too high';
	}else{
		$state = 'too low';
	}
	return $state;
}

$cond = !empty($_GET['submit']);
if ($cond) {
	$num = $_GET['number'];
	$_SESSION['state'] = status($num);
	echo $_SESSION['num'];
}else{
	echo $_SESSION['num'] = getPrng($dist);
	$_SESSION['state'] = 'Error';
}
// if ($_SESSION['state']=='correct') { // redirect after 3 seconds
// 	sleep(3);
// 	$loc = '/'.basename(dirname(__DIR__)).'/'.basename(__DIR__).'/'.basename(__FILE__);
// 	header("Location: ".$loc);
// }

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Guess My Number</title>

		<meta name="description" content="Program to display capital cities">
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
			<div class="row text-center">
				<h3>Guess My Number</h3>
				<p>The number is between 0 and <?=$_SESSION['max']?>.</p>
				<p>
					<?php if($cond) echo "Your number is ".$_SESSION['state']."."; 
					if($_SESSION['state'] == 'correct') echo "<br>You will be redirected in 1 sec.";
					?>
				</p>
			</div>
		</div>
		<div class="container">
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="search" class="control-label col-xs-5 col-md-4">Enter Guess: </label>
					<div class="col-xs-7 col-md-5">
						<input type="number" id="number" class="form-control" name="number">
					</div>
				</div>
				<br>
				<div class="row form-group">
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="submit" class="btn btn-default" name="submit" value="submit">search</button>
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
				var state = '<?php echo $_SESSION['state']; ?>';
				if (state == 'correct') {
					window.setTimeout(function(){
						window.location.href = "index.php";
					}, 1000); // 1000 ms
				}
			}
		</script>
	</body>
</html>