<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 */

// require_once(__DIR__.'/assets/constants.php');
require_once('../assets/index.php');
define('TITLE', 'Address Book');
// $input = array(
// 	array('fname', 'lname', 'num', 'addr'),
// 	array('Enter first name: ', 'Enter last name: ', 'Enter number: ', 'Enter address: '),
// 	array('text', 'text', 'number', 'text')
// );
$input = array(
	array('fname', 'Enter first name: ', 'text'),
	array('lname', 'Enter last name: ', 'text'),
	array('num', 'Enter number: ', 'number'),
	array('addr', 'Enter address: ', 'text')
);
$file = 'addrBook'.CSV;
$sub = 'submit';
// var_dump($input);

$done = false;
if (!empty($_GET[$sub])) {
	unset($_GET[$sub]);
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
			<div class="row text-center">
				<h3>Add an entry</h3>
			</div>
			<form class="form-horizontal" method="get" >
				<?php
					$len = count($input);
					for($i=0,$i1=0;$i<$len;$i++):
				?>
				<div class="row form-group ">
					<label for="<?=$input[$i][0];?>" class="control-label col-sm-4"><?=$input[$i][1];?></label>
					<div class="col-sm-8">
						<input type="<?=$input[$i][2];?>" id="<?=$input[$i][0];?>" class="form-control" name="<?=$i;?>">
					</div>
				</div>
				<br>
				<?php endfor; ?>
				<div class="row form-group " >
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="<?=$sub;?>" class="btn btn-default" name="<?=$sub;?>" value="<?=$sub;?>">add</button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row text-center" id="">
			<table class="table table-responsive table-striped table-hover" id="tbl">
				<?php if ($done): ?>
					<thead class="thead-inverse">
						<tr>
						<?php foreach ($input as $i => $v) : ?>
							<th><?=$v[0];?></th>
						<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php
							// ini_set('auto_detect_line_endings', true);
							// $txt = file_get_contents($file);
							foreach (file($file) as $i => $v): 
						?>
						<tr id="" >
						<?php
								$len = strlen($v);
								for($i=0;$i<$len;$i++) :
									if($v[$i]!=',')
						?>
							<td>
							<?php
							$v[$i];
							?>
							</td>
						<?php endfor; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				<?php endif; ?>
			</table>
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