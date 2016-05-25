<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 */

// require_once(__DIR__.'/assets/constants.php');
require_once(dirname(__DIR__).'/assets/index.php');
define('TITLE', 'Geometry Calculator');
$div = 'shapesDiv';
$div1 = 'optionsDiv';

// if (!empty($_GET['submit'])) {
// }else{
// }
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
			<form class="form-horizontal" method="get" id="geom">
				<div class="row form-group radio <?=$div;?>"></div>
				<div class="row form-group radio <?=$div1;?>"></div>
				<br>
				<div class="row form-group">
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="submit" class="btn btn-default" name="submit" value="submit">calculate</button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row">
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY;?>" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?=JS; ?>/bootstrap.min.js"></script> -->
		<script type="text/javascript">
			// variables
			var i=0,idx=0,shapeLen=0,j='',optArr=[],optId='options',optArrId=[];
			var lbl = ['<label class="col-sm-offset-4 col-sm-8 col-xs-12" ', '</label>'];
			var first = true;
			$(document).ready(main());
			function main() {

				var opts = $('.<?=$div1;?>');

				$.getJSON('shapes.php', function(data) {
					$.each(data, function(i, v) {
						if (i==optId) {
							var inp = '<input type="radio" name="'+optId+'" value="';
							optArr = v;
							optArrId = Object.getOwnPropertyNames(v);
							shapeLen = Object.keys(v).length; // fx does not work for IE < 9
							for(var i1=0;i1<shapeLen;i1++) {
								(first) ? j = 'checked' : j = '';
								first = false;
								var inp1 = inp+i1+'" '+j+' id="'+optId+i1+'">';
								opts.append(lbl[0]+' id="lbl'+optId+i1+'">'+inp1+optArr[optArrId[i1]]+lbl[1]);
							}
							first = true;
						}else{
							var inp = '<input type="radio" name="values" value="';
							(first) ? j = 'checked' : j = '';
							first=false;
							var inp1 = inp+i+'" '+j+' id="'+i+'">';
							$('.<?=$div;?>').append(lbl[0]+'>'+inp1+i+lbl[1]);
						}
					});
					$('.<?=$div;?> input').change(function() {	
						var radio = $("input[name='values']:checked", ".<?=$div;?>").val();
						var shapeOpt = Object.keys(data[radio]);
						var len = Object.keys(data[radio]).length;
						for(var i1=0;i1<len;i1++) {
							if(shapeOpt[i1]!=undefined && shapeOpt[i1]!=null)
								if(shapeOpt[i1]!=optArrId[i1]) {
									// alert(i1);
									$('#'+optId+i1).attr('checked', false);
									$('#lbl'+optId+i1).hide();
								}else{
									$('#'+optId+i1).attr('checked', true);
									$('#lbl'+optId+i1).show();
								}
						}
					});

				});
			}
		</script>
	</body>
</html>