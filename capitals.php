<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 12, 2016
 * Description: This program will find the capital or country depending on user's input
 * Resources: 
 * https://en.wikipedia.org/wiki/List_of_national_capitals_in_alphabetical_order
 */

require_once('parser.php');



$title = "List of national capitals in alphabetical order";
$pageid = 33728;
$file = 'countries';
$cptFl = 'capitals';
$section = 0;
$url = getUrl($title, $section);
if (!chkFile($file.JSN)) {
	$jstr = getFile($url); // get json from wiki
	setFile($file.JSN, $jstr); // place json in file
}else{
	$jstr = getFile($file.JSN); // get json from file
}
$pars = getParsedJson($jstr); // get parsed json
$cont = getContents($pars); // get contents of json; store string
// var_dump($jstr);
// Country
$arr = search($jstr, "{{flaglist\|[a-zA-Z0-9'\\\\ ]+");
// $arr = search($cont, '{{flaglist\|[a-zA-z ]+'); // search for countries and store in arr
$cntry = strmv("{{flaglist|", $arr); // remove useless chars and store in arr

// $arr = search($cont, '{{[a-zA-z ]+'); // 264 results
// $arr = search($cont, '{{[a-zA-z ]+\|[a-zA-z ]+'); // 258 results
// $cntry1 = strmv("{{flaglist|", $arr);
// $cntry1 = file($file.TXT, FILE_IGNORE_NEW_LINES); // get txt file

// Capital
$cptl = file($cptFl.TXT, FILE_IGNORE_NEW_LINES); // get txt file and store in arr

if (!empty($_GET)) {
	$chc = $_GET['location'];
	$stat = status($chc, $cntry, $cptl);
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Capital Cities</title>

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
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="location" class="control-label col-sm-4">Enter Capital or Country: </label>
					<div class="col-sm-8">
						<input type="text" id="location" class="form-control" name="location">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" id="submit" class="btn btn-default" >Enter</button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row">
				<table class="table table-responsive table-striped table-hover" id="tbl">
					<thead class="thead-inverse">
						<tr>
							<th>#</th>
							<th>Capital</th>
							<th>Country</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(empty($_GET)):
						$i=0;
						foreach ($cntry as $i1 => $v1): 
						?>
						<tr id="" style="cursor: pointer;">
							<th ><?php echo $i+1; ?></th>
							<td class="capital"><?php echo json_decode('"'.$cptl[$i++].'"'); ?></td>
							<td class="country"><?php echo json_decode('"'.$v1.'"'); ?></td>
						</tr>
						<?php endforeach; elseif($stat!=-1): ?>
						<tr id="" style="cursor: pointer;">
							<th>1</th>
							<td class="capital"><?php echo json_decode('"'.$cptl[$stat].'"'); ?></td>
							<td class="country"><?php echo json_decode('"'.$cntry[$stat].'"'); ?></td>
						</tr>
						<?php else: ?>
						<h3>Error occurred. Please try again.</h3>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
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
