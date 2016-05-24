<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 16, 2016
 * Description: 
 * Resources: 
 * 
 */

require_once('../../assets/index.php');


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Database Manager</title>

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
			<div class="row btn-group">
				<button type="button" class="btn btn-default" id="view" name="options" value="view">View</button>
				<button type="button" class="btn btn-default" id="add" name="options" value="add" >Add</button>
				<button type="button" class="btn btn-default" id="edit" name="options" value="edit" >Edit</button>
				<button type="button" class="btn btn-default" id="delete" name="options" value="delete" >Delete</button>
			</div>
		</div>
		<!-- view goes here -->
		<div class="container">
			<div id="db" class=" row">
				<h2>Data</h2>
				<table class="table table-responsive table-striped table-hover" id="dbTable">
					<thead class="thead-inverse">
						<tr>
							<!-- Dynamify -->
						</tr>
					</thead>
					<tbody>
						<!-- Dynamify -->
					</tbody>
				</table>
			</div>
		</div>
		<!-- form submission goes here -->
		<div class="container">
			<div class="row ">
				<form class="form-horizontal" method="get">
					
					<div class="form-group col-sm-2" style="float: right;">
						<button type="submit" id="submit" class="btn bnt-default btn-block" name="submit" value="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY; ?>" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?=TWBS_JS; ?>"></script> -->
		<script type="text/javascript">
			// variables

			$(document).ready(main());
			function main() {
				
			}
		</script>
	</body>
</html>