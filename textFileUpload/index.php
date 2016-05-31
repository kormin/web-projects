<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 20, 2016
 * Description: 
 * File Upload
 * In your "php.ini" file, search for the file_uploads directive, and set it to On: file_uploads = On
 * Resources: 
 * http://www.dropzonejs.com/
 http://www.w3schools.com/php/php_file_upload.asp
 */
 
require_once('../../assets/index.php');

$stat = false;
$ds = DIRECTORY_SEPARATOR;
if (!empty($_POST['submit'])) { // && $_FILES['file']['error']==0
	$tp = $_FILES['myfile']['tmp_name'];
	$path = dirname(__FILE__).$ds;
	$file = $path.$_FILES['myfile']['name'];
	if (!move_uploaded_file($tp, $file)) {
		echo "Upload file not valid.";
	}
	$stat = true;
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>String Compare</title>

		<meta name="description" content="Program to display capital cities">
		<meta name="keywords" content="php,html5,forms,inputs">
		<link rel="author" href="https://github.com/kormin">
		<link href="<?=TWBS; ?>" rel="stylesheet" type="text/css">
		<style type="text/css">
			.btn-file {
				position: relative;
				overflow: hidden;
			}
			.btn-file input[type=file] {
				position: absolute;
				top: 0;
				right: 0;
				min-width: 100%;
				min-height: 100%;
				font-size: 100px;
				text-align: right;
				filter: alpha(opacity=0);
				opacity: 0;
				outline: none;
				background: white;
				cursor: inherit;
				display: block;
			}
		</style>
		<!-- <link href="<?php echo PATH.CSS; ?>/dropzone.min.css" rel="stylesheet" type="text/css"> -->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<form class="form-horizontal " id="" method="post" enctype="multipart/form-data">
				<div class="row form-group">
					<span class="btn btn-default btn-file">
						Browse <input type="file" name="myfile" id="myfile" class="file">
					</span>
					<input type="submit" name="submit" value="Upload" class="btn btn-primary">
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row">
				<table class=" table-responsive" id="tbl">
					<thead class="thead-inverse">
						<tr>
							<th>Contents</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// ini_set('auto_detect_line_endings', true);
							if ($stat):
								$txt = file_get_contents($file);
							foreach (file($file) as $i => $v): 
						?>
						<tr id="" >
							<td><?=$v;?></td>
						</tr>
						<?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY; ?>" type="text/javascript"></script>
		<!-- <script src="<?=JS; ?>/dropzone.min.js" type="text/javascript"></script> -->
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
