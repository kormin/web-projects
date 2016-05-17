<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 16, 2016
 * Description: 
 * Resources: 
 * https://wiki.apache.org/couchdb/SchemaForToDoList
 http://getbootstrap.com/javascript/#modals-related-target
 * Attributes: 
 * Id, Todo, Details, Status, Date Created, Date Due, Category
 */

require_once('constants.php');
require_once('dbUtil.php');

$db = dbConf();
// add($db);

if (!empty($_GET)) {
	$vals = array();
	$cols = array();
	$i1 = 0;
	$opt = $_GET['submit'];
	foreach ($_GET as $i => $v) {
		if(!empty($v)) {
			$vals[$i] = $v;
			if($i!='submit') $cols[$i1++] = $i;
		}
	}
	if ($opt == 'add') {
		add($db, $vals, $cols, $i1);
	}
	// var_dump($cols);
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Todo List</title>

		<meta name="description" content="programming challenge taken from /r/dailyprogrammer subreddit">
		<meta name="keywords" content="php,html5,forms,inputs">
		<link rel="author" href="https://github.com/kormin">
		<link href="<?php echo PATH.CSS; ?>/bootstrap.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<ul class="nav navbar-nav">
						<li class="col-xs-3">
							<a class="navbar-brand" href="#" style="padding:0px; padding-right: 10px;">
							<img class="" alt="icon" src="note.png"></a>
						</li>
						<li class="col-xs-2 col-md-3"><a href="" data-toggle="modal" data-target="#todoForm" id="add" >Add</a></li>
						<li class="col-xs-2 col-md-3"><a href="#dbCont" id="edit">Edit</a></li>
						<li class="col-xs-4 col-md-3"><a href="#dbCont" id="delete">Delete</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- <div class="container">
			<form class="form-horizontal" method="get">
				<div class="row form-group">
					<label for="name" class="control-label col-sm-4">Enter title: </label>
					<div class="col-sm-8">
						<input type="text" id="name" class="form-control" name="name">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" id="submit" class="btn btn-default" >Send</button>
					</div>
				</div>
			</form>
		</div> -->
		<!-- view goes here -->
		<br><br>
		<div class="container" id="dbCont">
			<div id="db" class=" row">
				<h2>To-do List</h2>
				<table class="table table-responsive table-striped table-hover" id="dbTable">
					<thead class="thead-inverse">
						<tr>
							<th>Entry</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						// <a href=""  style="text-decoration: inherit; color: inherit;">
							$res = srch($db);
							// var_dump($res);
							$i1 = 0;
							foreach ($res as $i => $v):
						?>
						<tr style="cursor: pointer; " data-toggle="modal" data-target="#todoForm">
							<th id="todo-<?php echo $i1++; ?>" style="<?php if ($v['status']==0)echo 'text-decoration:line-through;'; ?>"><?php echo $v['title']; ?></th>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="todoForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding:0px;">
			<div class="modal-dialog modal-sm modal-lg" role="document">
				<div class="modal-content">
				<form class=" " method="get">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Todo Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body ">
						<div class="form-group">
							<label for="title" class="control-label">Title: </label>
							<input type="text" class="form-control" name="title" id="title">
						</div>
						<div class="form-group">
							<label for="details" class="control-label">Details (optional): </label>
							<input type="text" class="form-control" name="details" id="details">
						</div>
						<div class="form-group">
							<label for="dateDue" class="control-label">Date Due (optional): </label>
							<input type="date" class="form-control" id="dateDue" name="dateDue">
						</div>
						<div class="form-group">
							<label for="category" class="control-label">Category (optional): </label>
							<input type="text" class="form-control" name="category" id="category">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">close</button>
						<!-- <span class="glyphicon glyphicon-ok"></span> -->
						<button type="submit" class="btn btn-primary" id="submit" name="submit" value="submit">Save</button>
					</div>
				</form>
				</div>
			</div>
		</div>

		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo PATH.JS; ?>/jquery-2.2.3.min.js" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo PATH.JS; ?>/bootstrap.min.js"></script>
		<script type="text/javascript">
			// variables
			var txt = ['add','edit','delete'];
			var len = txt.length;
			var sub;
			$(document).ready(main());
			function main() {
				var todoLen = <?php echo json_decode($i1); ?>;
				var todo = [];
				sub = $('#submit');
				for(var i=0;i<len;i++) {
					$('#'+txt[i]).click({p1: txt[i]}, disPrp );
				}
				for(var i=0;i<todoLen;i++) {
					var x = 'todo-'+i;
					$('#'+x).click({p1: x}, chkStat);
				}
			}
			function disPrp(e) {
				var x = $(this);
				sub.prop('value', e.data.p1); // set value of submit button
				sub.text(e.data.p1);
				switch(e.data.p1){
					case txt[0]: add(x);
						break;
					case txt[1]: 
						break;
					case txt[2]: 
						break;
					// default: alert('Error.');
				}
			}
			function chkStat(e) {
				sub.prop('value', 'status'); // set value of submit button
				// sub.text('status');
				var tp = $("<span class=\"glyphicon glyphicon-ok\"></span>");
				sub.text('');
				sub.append(tp);
			}
			function add(x) {

			}
			function edit() {

			}
			function delVal() {

			}
		</script>
	</body>
</html>