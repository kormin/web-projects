<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 13, 2016
 * Description: This program will find the capital or country depending on user's input
 * Resources: 
 * http://php.net/manual/en/function.preg-grep.php
 * http://stackoverflow.com/questions/22342945/parsing-wikipedia-api-json-in-php
 * http://stackoverflow.com/questions/2560264/fetch-excerpt-from-wikipedia-article/12337968
 * http://stackoverflow.com/questions/964454/how-to-use-wikipedia-api-if-it-exists
 * https://en.wikipedia.org/wiki/Special:ApiSandbox
 */

require_once(dirname(__DIR__).'/assets/constants.php');

// https://en.wikipedia.org/w/api.php?action=query&format=jsonfm&pageids=33728&prop=revisions&rvprop=content&rvsection=0
// https://en.wikipedia.org/w/api.php?action=query&format=jsonfm&pageids=33728&prop=categories
// https://en.wikipedia.org/w/api.php?action=parse&format=jsonfm&pageid=33728&prop=links
// https://en.wikipedia.org/w/api.php?action=query&format=jsonfm&pageids=33728&prop=extracts

// STRING MANIPULATION
function rmvAcc($str) {
	$e = chr(233);
	$c = chr(231);
	$o = chr(244);
	$o1 = chr(243);
	$a = chr(224);
	$a1 = chr(227);
	$a2 = chr(229);
	$i = chr(237);
	$n = chr(241);
	$comma = chr(699);
	$len = strlen($str);
	echo $e.$c.$o.$o1.$a.$a1.$a2.$i.$n.$comma;
	for($i=0;$i<$len;$i++) {
		switch ($str[$i]) {
			case $a:
			case $a1:
			case $a2: $str[$i] = 'a';
				break;
			case $e: $str[$i] = 'e';
				break;
			case $c: $str[$i] = 'c';
				break;
			case $o:
			case $o1: $str[$i] = 'o';
				break;
			case $i: $str[$i] = 'i'; break;
			case $n: $str[$i] = 'n'; break;
			case $comma: $str[$i] = "\'"; break;
		}
	}
	return $str;
}

function status($str, $cntry, $cptl) {
	$str = strtolower($str);
	foreach ($cntry as $i1 => $v1) { // str is a country
		$v1 = json_decode('"'.$v1.'"');
		$v1 = iconv('utf-8', 'ascii//TRANSLIT', $v1);
		$v1 = strtolower($v1);
		if($str == $v1) {
			return $i1;
		}
	}
	foreach ($cptl as $i2 => $v2) { // str is a capital
		$v2 = iconv('utf-8', 'ascii//TRANSLIT', $v2);
		$v2 = strtolower($v2);
		if($str == $v2) {
			return $i2;
		}
	}
	return -1;
}

function search($src, $key) {
	// {{flaglist\|[a-zA-Z0-9'\\\\ ]+ // country
	// \| *\[\[[a-zA-z0-9'\\ ]+\]\] // capital

	preg_match_all('/'.$key.'/', $src, $match);
	return $match[0]; // returns 1d array
}

function strmv($val, $arr) {
	$ar = str_replace($val, '', $arr);
	return $ar;
}

// FILE HANDLING
function setFile($dest, $src) {
	file_put_contents($dest, $src);
}

function getFile($url) {
	$str = file_get_contents($url);
	return $str;
}

function chkFile($loc) {
	if(file_exists($loc)) {
		return true;
	}else{
		return false;
	}
}

// JSON PARSING
function getUrl($title, $section) {
	$ttl = str_replace(' ', '%20', $title);
	$sec = '';
	if (isset($section)) {
		$sec = '&rvsection='.$section;
	}
	$url = "https://en.wikipedia.org/w/api.php?action=query&format=json&prop=revisions&rvprop=content&titles=".$ttl.$sec;
	return $url;
}


function getParsedJson($json_str) {
	// $parsed = json_decode($json_str);
	$parsed = json_decode($json_str, true); // array
	return $parsed;
}

function getContents($v) {
	// foreach($v->query->pages as $k) { // used for extract api
	// 	echo $k->extract;
	// }
	// foreach($v->query->pages->revisions as $k) {
	// 	echo $k->*;
	// }
	// var_dump($v);
	foreach ($v['query']['pages'] as $page) { // traverses array
		// print_r($page['revisions'][0]['*']);
		$str = $page['revisions'][0]['*'];
	}
	return $str;
}


