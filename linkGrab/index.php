<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 16, 2016
 * Description:
 * This program will ask for the url and return a list of links found in that url
 * Resources: 
 * https://en.wikipedia.org/wiki/Web_scraping
 */

require_once('fx.php');


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Page Scraper</title>

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
					<label for="link" class="control-label col-sm-4">Enter URL: </label>
					<div class="col-sm-8">
						<input type="text" id="link" class="form-control" name="link">
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
							<th>Anchor</th>
							<th>Links</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (!empty($_GET)):
							$url = $_GET['link'];
							$anc = getAnc($url);
							$lnk = getLnk($anc);
							$i=0;
						foreach ($anc as $i1 => $v1): 
						?>
						<tr id="">
							<th ><?php echo $i+1; ?></th>
							<td class=""><?php echo $v1; ?></td>
							<td class=""><?php echo $lnk[$i++]; ?></td>
						</tr>
						<?php endforeach; endif; ?>
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