<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 24, 2016
 * Description: 
 * Resources: 
 */

// require_once(__DIR__.'/assets/constants.php');
require_once('../../assets/index.php');
define('TITLE', 'Geometry Calculator');
$div = 'shapesDiv';
$div1 = 'optionsDiv';
$div2 = 'valueDiv';
$div3 = 'valueDivParent';
$div4 = 'submit';
$ans = 'answer';
$path = 'shapes.php';
$val = 'values';

$done = false;
if (!empty($_GET['submit'])) {
	$ini = parse_ini_file("config.ini", true, INI_SCANNER_RAW);
	// $iniOpt = 'options';
	// var_dump($ini);
	$id=0;
	$first = true;
	foreach ($ini as $i => $v) {
		if($first) {
			$first = false;
			$opt = $i;
		}
		foreach ($v as $i1 => $v1) {
			// echo count($v);
			if (count($v)<2 && $_GET[$opt]!=0) { // for missing entry
				$id++;
			}
			if($i==$_GET[$val] && $id++==$_GET[$opt]) { // get formula
				$oper = $i1;
				$exp = $v1;
				// echo "<br>$i1 $v1";
				break;
			}
			
		}
	}
	// echo $id.'<br>';
	$tp = rmvSame($exp);
	$id=0;
	$uin = array();
	// echo "$oper $exp <br>";
	foreach ($tp as $i => $v) {
		$uin[$id++] = $_GET[$v];
	}
	// var_dump($exp);
	$str = replaceVar($tp, $uin, $exp);
	// var_dump($str);
	// change ASAP
	$ans = eval('return '.$str.';');
	// echo $ans;
	$done = true;
}

function replaceVar($var, $val, $str) {
	$len = strlen($str);
	$len1 = count($var);
	$str1 = '';
	$stat = false;
	for($i1=0;$i1<$len;$i1++) {
		for($i=0;$i<$len1;$i++) {
			if($str[$i1]==$var[$i]) {
				$str1 .= $val[$i];
				$stat = true;
				break;
			}else{
				$stat = false;
			}
		}
		if (!$stat) {
			$stat = false;
			$str1 .= $str[$i1];
		}
	}
	return $str1;
}

function rmvSame($str) {
	$seen = array();
	$uin = array();
	for($i1=0,$id=0;$i1<strlen($str);$i1++) { // check for repeats and removes other chars
		$c = $str[$i1];
		if (empty($seen[$c]) && $str[$i1]>='a' && $str[$i1]<='z') {
			$seen[$c] = true;
			$uin[$id++] = $c;
		}
	}
	return $uin;
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
			<form class="form-horizontal" method="get" >
				<div class="row form-group radio <?=$div;?>"></div>
				<br>
				<div class="row form-group radio <?=$div1;?>"></div>
				<br>
				<div id="<?=$div3;?>"></div>
				<br>
				<div class="row form-group " id="<?=$div4;?>">
					<div class="col-xs-offset-5 col-xs-7">
						<button type="submit" id="<?=$div4;?>" class="btn btn-default" name="<?=$div4;?>" value="<?=$div4;?>">calculate</button>
					</div>
				</div>
			</form>
		</div>
		<div class="container">
			<div class="row text-center" id="<?=$ans?>">
				<?php if($done): ?>
					<h4>Answer: <?=$ans;?></h4>
				<?php endif; ?>
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY;?>" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- <script src="<?=JS; ?>/bootstrap.min.js"></script> -->
		<script type="text/javascript">
			// variables
			var optId='', valId='<?=$val;?>';
			var lbl = ['<label class="col-sm-offset-4 col-sm-8 col-xs-12" ', '</label>'];
			var subm = $('#<?=$div4;?>');
			var i=0,idx=0,shapeLen=0,j='';
			var first = true, firstItemInJson = true;
			var optArr=[],optArrId=[];
			var jsonData, radio;
			$(document).ready(main());
			function main() {
				subm.hide();
				$.getJSON('<?=$path;?>', function(data) {
					jsonData = data;
					// alert(jsonData.toSource());
					$.each(data, function(i, v) {
						if (firstItemInJson) { // options here
							optId = i;
							optArr = v;
							// alert(v.toSource());
							optArrId = Object.getOwnPropertyNames(v);
							shapeLen = Object.keys(v).length; // fx does not work for IE < 9
							var inp = '<input type="radio" name="'+optId+'" value="';
							for(var i1=0;i1<shapeLen;i1++) { // traverse arr options contents
								// (first) ? j = 'checked' : j = '';
								// first = false;
								// optArrId[i1] replace i1
								var inp1 = inp+i1+'" '+j+' id="'+optId+i1+'">';
								$('.<?=$div1;?>').append(lbl[0]+' id="lbl'+optId+i1+'">'+inp1+optArr[optArrId[i1]]+lbl[1]);
							}
							first = true;
							firstItemInJson = false;
						}else{ // shapes here
							var inp = '<input type="radio" name="'+valId+'" class="hello" value="';
							// (first) ? j = 'checked' : j = '';
							// first=false;
							var inp1 = inp+i+'" '+j+' id="'+i+'">';
							$('.<?=$div;?>').append(lbl[0]+'>'+inp1+i+lbl[1]);
						}
					});
					$(".<?=$div;?> input").change(function() {
						radio = $("input[name='"+valId+"']:checked", ".<?=$div;?>").val();
						var shapeOpt = Object.keys(data[radio]);
						var len = Object.keys(data[radio]).length;
						var cond = shapeOpt[i1]!=undefined && shapeOpt[i1]!=null;
						// display options
						for(var i1=0;i1<len;i1++) {
							if(optArrId[i1]!=undefined && shapeOpt[i1]!=null) 
								if(shapeOpt[i1]!=optArrId[i1]) {
									// $('#'+optId+i1).attr('checked', false);
									$('#lbl'+optId+i1).hide();
								}else{
									// $('#'+optId+i1).attr('checked', true);
									$('#lbl'+optId+i1).show();
								}
							
						}
						var optRadio = $("input[name='"+optId+"']:checked", ".<?=$div1;?>").val();
						var	optArr = Object.getOwnPropertyNames(jsonData[optId]);
						if(optRadio!=undefined && optRadio!=null) {
							// alert(optRadio);
							// var tp = $("input[name='"+optId+optRadio+"']:checked", ".<?=$div1;?>").val();
							parseStr(radio, optArr[optRadio]);
						}
					});
					$('.<?=$div1;?> input').change(function() {
						var optRadio = $("input[name='"+optId+"']:checked", ".<?=$div1;?>").val();
						// var shapeOpt = Object.keys(data[optRadio]);
						// var len = Object.keys(data[optRadio]).length;
						var	optArr = Object.getOwnPropertyNames(jsonData[optId]);
						// alert(optRadio);
							// var tp = $("input[name='"+optId+optRadio+"']:checked", ".<?=$div1;?>").val();
							parseStr(radio, optArr[optRadio]);
					});
				});
			}
			function parseStr(radio, radio1) { // radio is name of shape. radio1 is shapes P/A
				// var radio = $("input[name='"+optId+"']:checked", ".<?=$div1;?>").val();
				var lbl1 = ['<label class="control-label col-sm-4" for="', '">', '</label>'];
				var inp = ['<input type="number" min="0" class="form-control" id="', '" name="', '">'];
				var divinp = ['<div class="col-sm-8">', '</div>'];
				var div = ['<div class="row form-group <?=$div2;?>">', '</div>'];
				var divobj = $('.<?=$div2;?>');
				var divParnt = $('#<?=$div3;?>');
				var	foru = jsonData[radio][radio1];
				var len,id,i1;
				var uin = [], uin1 = [], seen = [];
				// alert(jsonData[radio][radio1]);
				for(i1=0,id=0,len=foru.length;i1<len;i1++) {
					if (foru[i1]>='a' && foru[i1]<='z' ) { // get available user input
						uin[id++] = foru[i1];
					}
				}
				len=uin.length;
				for(i1=0,id=0;i1<len;i1++) { // check for repeats
					var c = uin[i1];
					if (!seen[c]) {
						seen[c] = true;
						uin1[id++] = c;
					}
				}
				len=uin1.length;
				for(i1=0;i1<len;i1++) {
					divobj.remove();
					divParnt.append(div[0]+lbl1[0]+uin1[i1]+lbl1[1]+'Enter '+uin1[i1]+':'+lbl1[2]+divinp[0]+inp[0]+uin1[i1]+inp[1]+uin1[i1]+inp[2]+divinp[1]+div[1]);
				}
				subm.show();
			}
		</script>
	</body>
</html>