<?php
/**
* Database Connection Information Class
* Author: Tom Abao
* Date Created: May 2, 2016
* Good practice: http://php.net/manual/en/pdo.prepared-statements.php
*/

require_once('constants.php');

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
	function setCol($cols, $len) {
		$flag = 0;
		for($i=0;$i<$len;$i++) {
			if (!preg_match($this->sqlChk, $cols[$i])) { // check if column name is safe
				$this->cols .= "`".$cols[$i]."`";
				$this->colsPlace .= ":".$cols[$i];
				if($i+1 != $len) {
					$this->cols .= ",";
					$this->colsPlace .= ",";
				}
			}else{
				echo "Error. Column names are invalid on line: ".__LINE__." at loop: ".$i;
				$flag = 1;
				break;
			}
		}
		// echo $this->cols;
		if ($flag==0 && $len > 0) {
			$this->colsLen = $len;
		}
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
	function select($cols, $opt=null) {
	
		// $str = "SELECT 
		// 	(".$this->cols.")
		// 	FROM
		// 	".$this->dbInfo['table']."
		// 	(".$this->colsPlace.")
		// ;";
	
		$str = 'SELECT '.$cols.' FROM `'.$this->dbInfo['table'].'` '.$opt.';';
		$sth = $this->dbh->query($str);
		return $sth;
	}
	function insert($val, $len) {
	
		$sql = "
			INSERT INTO 
				".$this->dbInfo['table']."
				(".$this->cols.")
				VALUES
				(".$this->colsPlace.")
		;";
		$sth = $this->dbh->prepare($sql);
		for($i=0;$i<$len;$i++) {
			$sth->bindParam($i+1, $val[$i]);
		}
		$sth->execute();
	
		// $str = 'INSERT INTO `'.$this->dbInfo['table'].'` ('.$cols.') '.'VALUES ('.$val.');';
		// // echo "<br>$str<br>";
		// $sth = $this->dbh->prepare($str);
		// $sth->execute();
	}
	function update($colVal, $cond) {
		$str = 'UPDATE `'.$this->dbInfo['table'].'` SET '.$colVal.' WHERE '.$cond.';';
		// echo "<br>$str<br>";
		$sth = $this->dbh->prepare($str);
		$sth->execute();
	}
	function delete($cond) {
		$str = 'DELETE FROM `'.$this->dbInfo['table'].'` WHERE '.$cond.';';
		$sth = $this->dbh->prepare($str);
		$sth->execute();
	}
	function getSqlFile($file) {
		$str = PATH.'/'.$file;
		$sth = file_get_contents($str);
		$this->dbh->exec($sth);
	}
}

function dbConf(){
	$dbInfo['host'] = 'localhost';
	$dbInfo['dbname'] = 'todolist';
	$dbInfo['charset'] ='utf8mb4';
	$dbInfo['user'] = '';
	$dbInfo['pass'] = '';
	$dbInfo['driver'] = 'sqlite';
	$dbInfo['table'] = 'notes';
	$dbInfo['path'] = '';
	$cols = array("title","details","status","dateMade","dateDue","category");
	$sqlFile = 'init.sql';
	$opts = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
	];
	$dbconn = new PdoDb($dbInfo, $opts);
	$dbconn->setConn();
	// $dbconn->execSql($sqlFile);
	$dbconn->setCol($cols, 6);
	return $dbconn;
}

function srch($dbconn) {
	$sth = $dbconn->select("`title`,`details`,`status`,`dateMade`,`dateDue`,`category`");
	$arr = $sth->fetchAll(PDO::FETCH_ASSOC);
	return $arr;
	foreach ($arr as $i => $val) {
		foreach ($val as $i1 => $val2) {
			echo "<p>$val2</p>";
		}
	}
	// print_r($arr);
}

function add($dbconn) {
	// INSERT INTO `notes` (`title`,`status`,`dateMade`) VALUES ("Hello world",1,date('now'));
	$dbconn->insert("\"Hello world\",1,date('now')");
	// $dbconn->insert($cols, $val);
}
