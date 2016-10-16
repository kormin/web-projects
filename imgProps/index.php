<?php
/*
 * Author: https://github.com/kormin
 * Date Created: October 3, 2016
 * Description: 
 * Resources: 
 * http://php.net/manual/en/function.exif-read-data.php
 * http://php.net/manual/en/function.exif-imagetype.php
 * 
 */
/*
 * http://php.net/manual/en/function.exif-imagetype.php
	Imagetype Constants
	Value	Constant
	1	IMAGETYPE_GIF
	2	IMAGETYPE_JPEG
	3	IMAGETYPE_PNG
	4	IMAGETYPE_SWF
	5	IMAGETYPE_PSD
	6	IMAGETYPE_BMP
	7	IMAGETYPE_TIFF_II (intel byte order)
	8	IMAGETYPE_TIFF_MM (motorola byte order)
	9	IMAGETYPE_JPC
	10	IMAGETYPE_JP2
	11	IMAGETYPE_JPX
	12	IMAGETYPE_JB2
	13	IMAGETYPE_SWC
	14	IMAGETYPE_IFF
	15	IMAGETYPE_WBMP
	16	IMAGETYPE_XBM
	17	IMAGETYPE_ICO
*/

/*
	Camera Maker - IFD0 Make
	Camera Model - IFD0 Model
	F-stop - COMPUTED ApertureFNumber, EXIF FNumber
	Exposure time - EXIF ExposureTime
	ISO speed - EXIF ISOSpeed Ratings
	Exposure bias - EXIF ExposureBiasValue
	Focal length - EXIF FocalLength
	Max aperture - EXIF MaxApertureValue
	Metering Mode - EXIF MeteringMode
	Flash mode - 
	Exposure program - EXIF ExposureProgram
	Saturation - 
	Sharpness - 
	White balance - EXIF WhiteBalance

	Camera Settings:
	Camera Maker
	Camera Model
	F-Stop
	Exposure Time
	ISO Speed
	Exposure bias
	Focal length
	Metering Mode
	Flash Mode
	White Balance
	Orientation
*/
 
require_once('../../assets/index.php');

function exifThumbnail() {
	if (array_key_exists('file', $_REQUEST)) {
		$image = exif_thumbnail($_REQUEST['file'], $width, $height, $type);
	} else {
		$image = false;
	}
	if ($image!==false) {
		header('Content-type: ' .image_type_to_mime_type($type));
		echo $image;
		exit;
	} else {
		// no thumbnail available, handle the error here
		echo 'No thumbnail available';
	}
}

function exifReadData($filepath, $settings) {
    // echo "test1.jpg:<br />\n";
    // $exif = exif_read_data("D:/School/Programs/5th Yr/1_CpE 429E/pics/Cacanog Quitten/IMG_5964.jpg", 'IFD0');
    // echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";

    // $exif = exif_read_data($filepath, 0, true);
    $exif = exif_read_data($filepath, 0, true);
    // $exif = exif_read_data($filepath, 'IFD0', 0);
	// $exif = exif_read_data($filepath, 'IFD0, EXIF', true);
	print_r($exif);
	// var_dump($exif);
    echo "<br>";
    echo "<br>";
    // foreach ($exif as $key => $section) {
    //     foreach ($section as $name => $val) {
    //         echo $key." ".$name.": ";
    //         print_r($val);
    //         // echo "$key.$name: $val";
    //         echo "<br>";
    //     }
    // }
	$arr = array();
	foreach ($settings as $k => $i) {
		foreach ($i as $k1 => $i1) {
			$arr[$k][$i1] = $exif[$k][$i1];
		}
	}
	print_r($arr);
}

function exifGetType($filepath) {
	$val = exif_imagetype($filepath);
	// echo $val;
	return $val;
}

function getExif($filepath) {
	$val = exifGetType($filepath);
	if ($val!=FALSE) {
		exifReadData($filepath, getCamSett());
	}
}

function getCamSett() {
	$settings = array(
		'IFD0' => array('Make', 'Model'),
		'EXIF' => array('FNumber', 'ExposureTime', 'ISOSpeedRatings',
		'ExposureBiasValue', 'FocalLength', 'MaxApertureValue',
		'MeteringMode', 'ExposureProgram', 'WhiteBalance'
		)
	);
	return $settings;
}

$filepath = "C:/Users/Tom/Documents/IMG_5964.jpg";
getExif($filepath);

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
