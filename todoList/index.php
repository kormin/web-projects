<?php
/*
 * Author: https://github.com/kormin
 * Date Created: May 16, 2016
 * Description: 
 * Resources: 
 * https://wiki.apache.org/couchdb/SchemaForToDoList
 * http://getbootstrap.com/javascript/#modals-related-target
 * http://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059
 * http://code.tutsplus.com/tutorials/php-database-access-are-you-doing-it-correctly--net-25338
 * Attributes: 
 * Id, Todo, Details, Status, Date Created, Date Due, Category
 */

require_once('dbUtil.php');

$db = dbConf();
// add($db);

if (!empty($_GET)) {
	$vals = array();
	$cols = array();
	$opt = $_GET['submit'];
	unset($_GET['submit']);
	$id = "`id`=".$_GET['post_id'];
	unset($_GET['post_id']);
	$status = $_GET['status'];
	unset($_GET['status']);
	foreach ($_GET as $i => $v) { // interates GET to retrieve all valid non-empty values
		if(!empty($v)) {
			$vals[$i] = $v;
		}
	}
	if ($opt == 'add') {
		add($db, $vals);
	}elseif ($opt == 'edit') {
		edit($db, $vals, $id);
	}elseif ($opt == 'delete') {
		$db->delete($id);
	}elseif ($opt == 'status') {
		if ($status==1) {
			$status = 0;
		}else{
			$status = 1;
		}
		$stat = array('status' => $status);
		edit($db, $stat, $id);
	}else{
		echo "Option is invalid.";
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
		<link href="<?=TWBS; ?>" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<ul class="nav navbar-nav">
						<li class="col-xs-2">
							<a class="navbar-brand" href="#" style="padding:0px; padding-right: 10px;">
							<img class="" alt="icon" src="note.png"></a>
						</li>
						<li class="col-xs-2 "><a href="" data-toggle="modal" data-target="#todoForm" id="add" >Add</a></li>
						<li class="col-xs-2 "><a href="#" id="edit">Edit</a></li>
						<li class="col-xs-2 "><a href="#" id="delete">Delete</a></li>
						<li class="col-xs-2 "><a href="" data-toggle="modal" data-target="#helpInfo" id="help">Help</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<br><br><br>
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
						<!-- Place db todo id here -->
						<input type="number" min="0" id="post_id" name="post_id" hidden></input>
						<input type="number" id="status" name="status" hidden></input>
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
		<div class="modal fade" id="helpInfo" tabindex="-1" role="dialog" aria-labelledby="helpModal" style="padding:0px;">
			<div class="modal-dialog modal-sm modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="helpModal">Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body ">
						<h4>Click a note</h4>
						<p>Click a note and a message box will appear. If you click the check mark, you signify that the note has been accomplished. Clicking the check mark when the note has already been accomplished will undo the action.</p>
						<h4>Add</h4>
						<p>Click Add and a message box will appear letting you add your note with other optional values.</p>
						<h4>Edit</h4>
						<p>Click Edit and choose a note. A message box will appear so you can start editing values.</p>
						<h4>Delete</h4>
						<p>Click Delete and choose a note. A message box will then appear prompting you if you wish to continue deleting.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=JQRY; ?>" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?=TWBS_JS; ?>"></script>
		<script type="text/javascript">
			// variables
			var txt = ['add','edit','delete'];
			var len = txt.length;
			var opt = [];
			var sub,i;
			var inpTxt = ['title','details','dateDue','category'];
			var inpLen = inpTxt.length;
			var inpt = [];
			var tdlist = <?php echo json_encode($res); ?>; // get to do list values 
			var todoLen = <?php echo json_decode($i1); ?>; // gets length of todo list
			var todo = [];
			var post_id = $('#post_id'); // post id for db handling
			var stat = $('#status'); // status for db handling
			$(document).ready(main());
			function main() {
				sub = $('#submit');
				for(i=0;i<len;i++) {
					opt[i] = $('#'+txt[i]);
					opt[i].click({p1: txt[i]}, optAct );
				}
				for(i=0;i<inpLen;i++) {
					inpt[i] = $('#'+inpTxt[i]);
				}
				for(i=0;i<todoLen;i++) {
					var x = 'todo-'+i;
					todo[i] = $('#'+x);
					todo[i].click({p1: i}, todoAct);
				}
			}
			function optAct(e) { // perform actions when opt is clicked
				var x = $(this);
				sub.prop('value', e.data.p1); // set value of submit button
				sub.text(e.data.p1);
				x.data('clicked', true);
				x.css('color','#FFC30D');
				for(i=0;i<len;i++) {
					if (e.data.p1!=txt[i]) {
						opt[i].prop('clicked', false);
						opt[i].removeAttr('style');
					}
				}
				for(i=0;i<inpLen;i++) { // disables props when delete mode
					if(e.data.p1==txt[2]) inpt[i].prop('disabled', true);
					else inpt[i].prop('disabled', false);
				}
				// switch(e.data.p1) {
				// 	case txt[1]: 
				// 	case txt[2]: 
				// 		break;
				// 	default: break;
				// }
			}
			function todoAct(e) { // perform actions when todo is clicked
				var cond = (!(opt[1].data('clicked')) && !(opt[2].data('clicked')));
				if ( cond ) {
					sub.prop('value', 'status'); // set value of submit button
					var tp = $("<span class=\"glyphicon glyphicon-ok\"></span>");
					sub.text('');
					sub.append(tp);
				}
				for(i=0;i<todoLen;i++) { // find row
					if(i==e.data.p1) { // if row == i
						post_id.val(tdlist[i]['id']); // store id to post_id for submit
						stat.val(tdlist[i]['status']); // store status to var for submit
						for(var i1=0;i1<inpLen;i1++) { // display values in modal box
							inpt[i1].val(tdlist[i][inpTxt[i1]]);
						}
						break;
					}
				}
			}
			function add(x) {
			}
			function edit(x) {
			}
			function delVal(x) {
			}
		</script>
	</body>
</html>