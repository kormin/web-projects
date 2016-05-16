<?php

// constants
define('PATH', '/web-projects');
define('CSS', '/assets/css');
define('JS', '/assets/js');
define('JSN','.json');
define('TXT','.txt');

function search($src, $key) {
	preg_match_all('/'.$key.'/', $src, $match);
	return $match[0]; // returns 1d array
}

function strmv($val, $arr) {
	$ar = str_replace($val, '', $arr);
	return $ar;
}

function rmv($arr) {
	$ar = strmv("href=\"[#a-Z]+\"", $arr);
	$ar = strmv("href=\"javascript:[^ ]+\"", $ar);
}

function getFile($url) {
	$str = file_get_contents($url);
	return $str;
}

function getAnc($url) {
	// $txt = 'test'.TXT;
	$anc = search(getFile($url), "<a(?: [^>]*)?>(.*?)<\/a>");
	return $anc;
}

function getLnk($anc) {
	$i1 = 0;
	$lnk2 = array();
	$txt2 = array();
	foreach ($anc as $i => $v) {
		$hrf = search($v, "href=\"[^ ]+\""); // url of anchor tags
		if(!empty($hrf)) {
			$lnk1 = strmv("href=\"", $hrf[0]);
			$lnk2[$i1] = strmv("\"", $lnk1);
		}
		// $cont = search($v, ">(.*?)<\/a>"); // text of anchor tags
		// if(!empty($cont)) {
		// 	$txt1 = strmv(">", $cont[0]);
		// 	$txt2[$i1] = strmv("<\/a>", $txt1);
		// }
		$i1++;
	}
	return $lnk2;
}