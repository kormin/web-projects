<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 * http://stackoverflow.com/questions/20881213/converting-json-object-into-javascript-array
 * 
 * 
 */

// require_once(__DIR__.'/assets/constants.php');
require_once('../assets/index.php');
define('TITLE', 'Calculators');
define('DESCR', "<br>Description taken from wikipedia.org");
define('OPT', "Calculator");
define('OPT1', "Converter");
// $input = array(
// 	array('fname', 'lname', 'num', 'addr'),
// 	array('Enter first name: ', 'Enter last name: ', 'Enter number: ', 'Enter address: '),
// 	array('text', 'text', 'number', 'text')
// );
$rdio = array(
	"basic" => "Standard",
	"sci" => "Scientific",
	"prog" => "Programmer",
	"datc" => "Date Calculation"
);
$rdio1 = array(
	"vol" => "Volume",
	"len" => "Length",
	"mass" => "Weight and Mass",
	"temp" => "Temperature",
	"engy" => "Energy",
	"area" => "Area",
	"sped" => "Speed",
	"time" => "Time",
	"powr" => "Power",
	"dat" => "Data",
	"pres" => "Pressure",
	"angl" => "Angle"
);
$keys = 'keys';
$sub = 'submit';
// var_dump($input);

$done = false;
if (!empty($_GET[$sub])) {
	unset($_GET[$sub]);
	$len = count($_GET);
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
				<p><?=DESCR;?></p>
			</div>
		</div>
		<div class="container">
			<form class="form-horizontal" method="get" >
				<div class="row text-center">
					<h3><?=OPT;?></h3>
				</div>
				<div class="row form-group radio">
					<?php 
					$first = true;
					foreach ($rdio as $i => $v):
					 ?>
					<label class="col-sm-offset-4 col-sm-8 col-xs-12">
						<input id="<?=$i;?>" type="radio" name="<?=TITLE;?>" value="<?=$i;?>" <?php if($first) echo "checked"; ?> ><?=$v;?>
					</label>
					<?php $first = false; endforeach; ?>
				</div>
				<div class="row text-center">
					<h3><?=OPT1;?></h3>
				</div>
				<div class="row form-group radio">
					<?php
					foreach ($rdio1 as $i => $v):
					 ?>
					<label class="col-sm-offset-4 col-sm-8 col-xs-12">
						<input id="<?=$i;?>" type="radio" name="<?=TITLE;?>" value="<?=$i;?>"><?=$v;?>
					</label>
					<?php endforeach; ?>
				</div>
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
		<script type="text/javascript">
			// variables
			var rdio = <?php echo json_encode($rdio);?>;
			var rdio1 = <?php echo json_encode($rdio1);?>;
			var first = <?php echo json_encode($first);?>;
			var i,i1;
			window.onload = function() {
				$(document).ready(main());
			};
			function main() {
				// var tp;
				// tp = JSON.parse(rdio);
				// console.log(rdio);
				// var arr = $.map(rdio, function(el){return el}); // jquery
				var rarr = Object.keys(rdio).map(function(k) { return rdio[k] });
				var rarr1 = Object.keys(rdio1).map(function(k) { return rdio1[k] });
				var len = rarr.length;
				var len1 = rarr1.length;
				var robj = toJqryObjArr('#', Object.keys(rdio), len);
				var robj1 = toJqryObjArr('#', Object.keys(rdio1), len1);
				doClick(robj, len);
				doClick(robj1, len1);
				if(!first) { // confirms php first radio button is checked
					dispView(robj[0]);
				}
			}
			/**
			 * Converts string array to jquery id object
			 * 
			 * @param string selector sel
			 * @param string array arr
			 * @param int len
			 * @return object obj
			 */
			function toJqryObjArr(sel, arr, len) {
				var obj = [];
				for(var i=0;i<len;i++) {
					obj[i] = $(sel+arr[i]);
				}
				return obj;
			}
			/**
			 * Create jquery click event
			 * 
			 * @param string array arr
			 * @param int len
			 * @return void
			 */
			function doClick(arr, len) {
				for(var i=0;i<len;i++) {
					arr[i].click({p1: arr[i]}, disPrep);
				}
			}
			/**
			 * Prepares object for display view
			 * 
			 * @param object jobj
			 * @return void
			 */
			function disPrep(e) {
				dispView(e.data.p1);
			}
			/**
			 * Display view for jquery object
			 * 
			 * @param object jobj
			 * @return void
			 */
			function dispView(jobj) {
				var id = jobj.attr('id');
				if(jobj.is(':checked')) {
				}
			}
		</script>
	</body>
</html>