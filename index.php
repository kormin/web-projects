<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 * http://getbootstrap.com/css/#forms
 */

// require_once(__DIR__.'/assets/constants.php');
require_once('../assets/index.php');
define('TITLE', 'Text Editor');
// $input = array(
// 	array('fname', 'lname', 'num', 'addr'),
// 	array('Enter first name: ', 'Enter last name: ', 'Enter number: ', 'Enter address: '),
// 	array('text', 'text', 'number', 'text')
// );
$input = array(
	'txt',
	'Enter text: '
);
$txt = array(20);
$sub = 'save';
$saveUrl = '';
// var_dump($input);

$done = false;
if (!empty($_GET[$sub])) {
	unset($_GET[$sub]);
	$file = 'addrBook'.TXT;
	$len = count($_GET);
	$uin = array();
	for($i=0;$i<$len;$i++) {
		$uin[$i] = $_GET[$i];
		if($i+1<$len) $uin[$i] .= ",";
		else $uin[$i] .= PHP_EOL;
	}
	// var_dump($uin);
	// file_put_contents($file, $uin, FILE_APPEND | LOCK_EX);
	$done = true;
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?=TITLE;?></title>

		<meta name="description" content="Program to display capital cities">
		<meta name="keywords" content="php,html5,forms,inputs">
		<link rel="author" href="https://github.com/kormin">
		<link href="<?=TWBS;?>" rel="stylesheet" type="text/css">

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
				<h3><?=TITLE;?></h3>
				<p>
				<?php

				?>
				</p>
			</div>
		</div>
		<div class="container">
			<form class="" method="get" >
				<div class="row form-group">
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="<?=$sub;?>" class="btn btn-default" name="<?=$sub;?>" value="<?=$sub;?>"><?=$sub;?></button>
					</div>
				</div>
				<div class="row form-group ">
					<label for="<?=$input[0];?>" class="control-label col-sm-4"><?=$input[1];?></label>
					<textarea id="<?=$input[0];?>" name="<?=$input[0];?>" class="form-control" rows="<?=$txt[0];?>"></textarea>
				</div>
				<br>
				<div class="row form-group " >
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="<?=$sub;?>" class="btn btn-default" name="<?=$sub;?>" value="<?=$sub;?>"><?=$sub;?></button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row" id="">
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY;?>" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?=JS; ?>/bootstrap.min.js"></script> -->
		<script type="text/javascript">
			// variables
			$(document).ready(main());
			function main() {
			}
		</script>
	</body>
</html>