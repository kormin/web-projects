<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 23, 2016
 * Description: 
 * Resources: 
 * http://stackoverflow.com/questions/573184/java-convert-string-to-valid-uri-object
 * http://php.net/manual/en/function.urlencode.php
 * http://stackoverflow.com/questions/11024225/open-url-with-php
 */

require_once('../../assets/index.php');

$srchEng = array(
	"Google" => "https://www.google.com.ph/search?q=",
	"Bing" => "http://www.bing.com/search?q=",
	"Yahoo!" => "https://search.yahoo.com/search?ei=UTF-8&fr=crmas&p=",
	"Yandex" => "https://www.yandex.com/search/?text=",
	"DuckDuckGo" => "https://duckduckgo.com/?q=",
	"Faroo" => "http://www.faroo.com/#q=",
	"Torrentz" => "https://torrentz.eu/search?q=",
	"Kickass" => "https://kat.cr/usearch/?q=",
	"Isohunt" => "https://isohunt.to/torrents/?ihq=",
	"Stackoverflow" => "http://stackoverflow.com/search?q=",
	"Reddit" => "https://www.reddit.com/search?q="
);

if (!empty($_GET['submit'])) {
	$str = $_GET['search'];
	$eng = $_GET['engine'];
	// $ar = str_replace(' ', '+', $str);
	$qry = urlencode($str);
	foreach ($srchEng as $i => $v) {
		if ($i == $eng) {
			$url = $v.$qry;
			// echo "<script type='text/javascript'>window.open('".$url."');</script>";
			break;
		}
	}

}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Web Search</title>

		<meta name="description" content="Program to display capital cities">
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
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="search" class="control-label col-sm-4">Enter search query: </label>
					<div class="col-sm-8">
						<input type="text" id="search" class="form-control" name="search">
					</div>
				</div>
				<div class="row form-group radio">
					<?php 
					$first = true;
					foreach ($srchEng as $i => $v):
					 ?>
					<label class="col-sm-offset-4 col-sm-8 col-xs-12">
						<input type="radio" name="engine" value="<?=$i;?>" <?php if($first) echo "checked"; ?> ><?=$i;?>
					</label>
					<?php $first = false; endforeach; ?>
				</div>
				<br>
				<div class="row form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" id="submit" class="btn btn-default" name="submit" value="submit">search</button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row col-sm-offset-4 col-sm-8">
				<a id="link" href="<?=$url;?>" target="_blank" hidden>Search Result</a>
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
				// opens new tab with search query when submit button is clicked
				var url = "<?php echo $url; ?>";
				// $('<a>').attr('href', url).attr('target','_blank')[0].click();
				if (url!=undefined && url!=null) {
					$('#link').removeAttr('hidden');
					$('#link')[0].click();
				}
			}
			function openTab(url) {
				var atag = document.createElement('a');
				atag.target="_blank";
				atag.href = url;
				document.body.appendChild(atag);
				atag.click();
				atag.parentNode.removeChild(atag);
			}
		</script>
	</body>
</html>