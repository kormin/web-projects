<?php
/**
* Database Connection Information Class
* Author: Tom Abao
* Date Created: May 2, 2016
* Good practice: http://php.net/manual/en/pdo.prepared-statements.php
*/

require_once('../../assets/index.php');

class PdoDb
{
	private $dbInfo = array();
	private $cols;
	private $colsPlace;
	private $colsLen;
	private $dsn;
	private $opts = array();
	private $sqlChk = "/\s|=/";
	public $dbh;
	function __construct($dbInfo, $opts) {
		$this->setDbInfo($dbInfo);
		$this->setDsn();
		$this->setOpts($opts);
	}
	function dbConf($dbInfo, $opts=null, $sqlFile, $sqlRegexCheck){
		$opts = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false
		];
	}
	function setDbInfo($dbInfo) {
		foreach ($dbInfo as $key => $value) {
			if (!preg_match($this->sqlChk, $value)) {
				$this->dbInfo[$key] = $value;
			}else{
				echo "Error. Database information is invalid on line: ".__LINE__." at key: ".$key;
				break;
			}
		}
	}
	function setDsnNoDbname() {
		if ($this->dbInfo['driver'] == 'mysql') {
			$this->dsn = "mysql:host=".$this->dbInfo['host'].";charset=".$this->dbInfo['charset'];
		}
	}
	function setDsn() {
		if ($this->dbInfo['driver'] == 'mysql') {
			$this->dsn = "mysql:host=".$this->dbInfo['host'].";dbname=".$this->dbInfo['dbname'].";charset=".$this->dbInfo['charset'];
		}else if($this->dbInfo['driver'] == 'sqlite') {
			$this->dsn = "sqlite:".$this->dbInfo['path'].$this->dbInfo['dbname'].".sqlite3";
		}else if($this->dbInfo['driver'] == 'pgsql') {
			$this->dsn = "pgsql:host=".$this->dbInfo['host'].";port=".$this->dbInfo['port'].";dbname=".$this->dbInfo['dbname'].";user=".$this->dbInfo['user'].";password=".$this->dbInfo['pass'].";";
		}else{
			echo "Your database driver is unavailable.";
		}
	}
	function setOpts($opts) {
		$this->opts = $opts;
	}
	function setSqlChk($sqlChk) {
		$this->sqlChk = $sqlChk;
	}
	function toColStr($cols, $len, $opt) { // $opt = 1 is column, 2 is named placeholder
		$col = "";
		if ($len < 0) {
			echo "Error. Column length is invalid on line: ".__LINE__;
			return -1;
		}
		if($opt==1) {
			$chc = $chc1 = "`";
		}else if($opt==2) {
			$chc = ":";
			$chc1 = "";
		}else{
			echo "Error. Column option is invalid on line: ".__LINE__." at loop: ".$i;
			return -2;
		}
		for($i=0;$i<$len;$i++) {
			if (!preg_match($this->sqlChk, $cols[$i])) { // check if column name is safe
				$col .= $chc.$cols[$i].$chc1;
				if($i+1 != $len) {
					$col .= ",";
				}
			}else{
				echo "Error. Column names are invalid on line: ".__LINE__." at loop: ".$i;
				return -3;
			}
		}
		return $col;
	}
	function setColReq($cols, $len) { // append to end of string
		$this->cols .= ",".$this->toColStr($cols, $len, 1);
		$this->colsPlace .= ",".$this->toColStr($cols, $len, 2);
	}
	function setCol($cols, $len) {
		$this->cols = $this->toColStr($cols, $len, 1);
		$this->colsPlace = $this->toColStr($cols, $len, 2);
	}
	function setColLen($colsLen) {
		$this->colsLen = $colsLen;
	}
	function getCol() {
		return $this->cols;
	}
	function getColPlace() {
		return $this->colsPlace;
	}
	function getDsn() {
		return $this->dsn;
	}
	function getUser() {
		return $this->dbInfo['user'];
	}
	function getPass() {
		return $this->dbInfo['pass'];
	}
	function getOpts() {
		return $this->opts;
	}
	function getPdo() {
		try {
			$dbh = new PDO($this->getDsn(), $this->getUser(), $this->getPass(), $this->getOpts());
			return $dbh;
		} catch (PDOException $e) {
			if ($e->getCode() == 1049) {
				return $e;
			}else{
				echo $e->getMessage();
			}
		}
	}
	function setConn() {
		$this->dbh = $this->getPdo();
		if ($this->dbh instanceof PDOException) {
			if($this->dbh->getCode() == 1049) {
				$this->setDsnNoDbname();
				$this->dbh = $this->getPdo();
			}
		}
	}
	function execSql($loc) {
		$sql = file_get_contents($loc);
		if ($sql === false) {
			echo "Sql file not found";
		}
		try {
			if(!file_exists($loc)) { // execs when file does not exist
				$res = $this->dbh->exec($sql);
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	function createDb() {
		// if( 1== 1049) {
		// 	$tp = $this->dbInfo['dbname'];
		// 	$this->dbInfo['dbname'] = null;
		// 	$this->setDsn();
		// 	$this->dbInfo['dbname'] = $tp;
		// }
		$str = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbInfo['dbname'].'`;';
		$this->dbh->exec($str);
		// $sth = $this->dbh->prepare($str);
		// $sth->execute();
	}
	function createTable($cols) {
	/*
		$str = "CREATE TABLE IF NOT EXISTS
			`table`
			(`col1`, `col2`)
		;";
	*/
		$str = 'CREATE TABLE IF NOT EXISTS `'.$dbInfo['table'].'` ('.$cols.');';
		$sth = $this->dbh->prepare($str);
		$sth->execute();
	}
	function select($opt=null) {
		$sql = "SELECT 
			".$this->cols."
			FROM
			`".$this->dbInfo['table']."`
			".$opt."
		;";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth;
	}
	function insert($val, $cols, $len) {
		$sql = "
			INSERT INTO 
				`".$this->dbInfo['table']."`
				(".$this->cols.")
				VALUES
				(".$this->colsPlace.")
		;";
		$sth = $this->dbh->prepare($sql);
		for($i=0;$i<$len;$i++) {
			// echo "$i&nbsp;".$cols[$i]."&nbsp;".$val[$i]."<br>";
			$sth->bindParam(":".$cols[$i], $val[$i]);
		}
		$v = 1; // default status value
		$sth->bindParam(":status", $v);
		$a = date('Y-m-d'); // default dateMade value
		$sth->bindParam(":dateMade", $a);
		$sth->execute();
	}
	function update($val, $cond) {
		$str = "UPDATE `".$this->dbInfo['table']."` SET ".$val." WHERE ".$cond.";";
		$sth = $this->dbh->prepare($str);
		$sth->execute();
	}
	function delete($cond) {
		$str = "DELETE FROM `".$this->dbInfo['table']."` WHERE ".$cond.";";
		$sth = $this->dbh->prepare($str);
		$sth->execute();
	}
	function getSqlFile($file) {
		$str = PATH.'/'.$file;
		$sth = file_get_contents($str);
		$this->dbh->exec($sth);
	}
}


function srch($dbconn) {
	$cols = array("id","title","details","status","dateMade","dateDue","category");
	$len = count($cols);
	$dbconn->setCol($cols, $len);
	$sth = $dbconn->select();
	$arr = $sth->fetchAll(PDO::FETCH_ASSOC);
	return $arr;
}

function add($dbconn, $val) {
	$cols = array();
	$valu = array();
	$len = count($val);
	$i1=0;
	foreach ($val as $i => $v) {
		$cols[$i1] = $i;
		$valu[$i1++] = $v;
	}
	$dbconn->setCol($cols, $len);
	$colReq = array("status","dateMade");
	$dbconn->setColReq($colReq, 2);
	$dbconn->setColLen($len+2);
	// var_dump($dbconn->getCol());
	// var_dump($dbconn->getColPlace());
	$dbconn->insert($valu, $cols, $len);
}

function edit($dbconn, $val, $cond) {
	$valu="";
	$i1 = 0;
	$len = count($val);
	foreach ($val as $i => $v) {
		$valu .= "`".$i."` = '".$v."'";
		if(++$i1 != $len) {
			$valu .= ",";
		}
	}
	$dbconn->update($valu, $cond);
}