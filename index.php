<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 * http://getbootstrap.com/css/#forms
 * http://www.html5rocks.com/en/tutorials/file/dndfiles/
 * http://stackoverflow.com/questions/7395548/js-and-type-match-as-file-mime-type-need-advice
 * http://stackoverflow.com/questions/14446447/javascript-read-local-text-file
 * http://stackoverflow.com/questions/27522979/read-a-local-textfile-using-javascript
 * http://stackoverflow.com/questions/3582671/how-to-open-a-local-disk-file-with-javascript
 * http://stackoverflow.com/questions/24245105/how-to-get-the-filename-from-the-javascript-filereader
 * http://php.net/manual/en/function.readfile.php
 * http://www.media-division.com/the-right-way-to-handle-file-downloads-in-php/
 * http://stackoverflow.com/questions/11315951/using-the-browser-prompt-to-download-a-file
 * 
 */

// require_once(__DIR__.'/assets/constants.php');
require_once('../assets/index.php');
define('TITLE', 'Text Editor');
// $input = array(
//  array('fname', 'lname', 'num', 'addr'),
//  array('Enter first name: ', 'Enter last name: ', 'Enter number: ', 'Enter address: '),
//  array('text', 'text', 'number', 'text')
// );
$input = array(
	'flname',
	'Enter name: ',
	'txt',
	'Enter text: '
);
$txt = array(20);
$sub = 'save';
$opn = 'open';
$opnid = $opn.'_file';
$saveUrl = '';
// var_dump($input);

$done = false;
if (!empty($_GET[$sub])) {
	unset($_GET[$sub]);
	$fname = $_GET[$input[0]];
	$fcont = $_GET[$input[2]];
	$res = file_put_contents($fname, $fcont); // delete after
	if ($res!=false && file_exists($fname)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header("Content-Type: application/download");
		header('Content-Disposition: attachment; filename="'.basename($fname).'"');
		header('Expires: 0');
		header('Content-Length: '.filesize($fname));
		// below is for IE6
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Pragma: public');

		readfile($fname);

		unlink($fname);
		exit;
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
						<input type="file" id="<?=$opnid;?>" style="display: none;">
						<button type="button" id="<?=$opn;?>" class="btn btn-default" onclick="document.getElementById('<?=$opnid;?>').click()">
						<?=$opn;?></button>
					</div>
				</div>
				<div class="row form-group ">
					<label for="<?=$input[0];?>" class="control-label col-sm-4"><?=$input[1];?></label>
					<input type="text" id="<?=$input[0];?>" name="<?=$input[0];?>" class="form-control" >
				</div>
				<div class="row form-group ">
					<label for="<?=$input[2];?>" class="control-label col-sm-4"><?=$input[3];?></label>
					<textarea id="<?=$input[2];?>" name="<?=$input[2];?>" class="form-control" rows="<?=$txt[0];?>"></textarea>
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
			var finp, fdsp, fnme;
			var url = "";
			window.onload = function() {
				$(document).ready(main());
			}
			function main() {
				finp = document.getElementById('<?=$opnid;?>');
				var input = document.getElementsByTagName('input')[0];
				fnme = $('#<?=$input[0];?>');
				fdsp = $('#<?=$input[2];?>');
				// fnme = document.getElementById('<?=$input[0];?>');
				// fdsp = document.getElementById('<?=$input[2];?>');
				input.onclick = function () {
				// for when same file is opened many times
						this.value = null;
				};
				finp.addEventListener('change', fileRead, false);
				// getTxt(url);
			}

			function fileRead(e) {
				// var file = finp.files[0];
				var file = e.target.files[0];
				if (!file) {
					return;
				}
				// var txt = /text.*/;
				// if(file.type.match(txt)) {
					var reader = new FileReader();
				var name = file.name;
				// fnme.innerHTML = name;
				fnme.val(name);
					reader.onload = function(e) {
						var contents = e.target.result;
						// fdsp.innerHTML = contents;
						fdsp.val(contents);
						// disp(contents);
						// fdsp = reader.result;
					};
					reader.readAsText(file);
				// }else{
				// 	fdsp.innerHTML = "File not supported";
				// }
			}

			function getTxt(url) {
				// uses xmlhttprequest
				var rawfile = new XMLHttpRequest();
				rawfile.open("GET", url, true);
				rawfile.onreadystatechange = function () {
					if(rawfile.readyState === 4) {
						// alert("in");
						if (rawfile.status == 200) //  || rawFile.status == 0 )
						{
							var txt = rawfile.responseText;
							document.getElementById("<?=$input[2];?>").innerHTML = txt;
							// document.write(txt);
						}
					}
				}
				rawfile.send(null);
			}
		</script>
	</body>
</html>