<?php
/*
 * Author: https://github.com/kormin
 * Date Created: October 3, 2016
 * Description: 
 * Resources: 
 * http://php.net/manual/en/function.exif-read-data.php
 * 
 */
 
require_once('../../assets/index.php');

function exifReadData() {
    // echo "test1.jpg:<br />\n";
    // $exif = exif_read_data("D:/School/Programs/5th Yr/1_CpE 429E/pics/Cacanog Quitten/IMG_5964.jpg", 'IFD0');
    // echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";

    $exif = exif_read_data("D:/School/Programs/5th Yr/1_CpE 429E/pics/Cacanog Quitten/IMG_5964.jpg", 0, true);
    foreach ($exif as $key => $section) {
        foreach ($section as $name => $val) {
            echo $key." ".$name.": ";
            print_r($val);
            // echo "$key.$name: $val";
            echo "<br>";
        }
    }
}

exifReadData();

echo "End";

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
