<?php
if(isset($_POST['name']) and $_POST['name']!=''){
	require_once('dbconf.php');
	$stmt = $db->prepare("INSERT INTO `livepitchuser`(`name`, `company`, `emailid`,contact) VALUES (:name, :company, :emailid, :contact)");
	$stmt->execute(array(':name'=>$_POST['name'], ':company'=>$_POST['companyname'], ':emailid'=>$_POST['emailid'], ':contact'=>$_POST['contactno']));

	$lid = $db->lastInsertId();
	$id = $_GET['id'];
	header("location:conferenceview.php?id=$id&lid=$lid"); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />
<link rel="shortcut icon" href="img/kurento.png" type="image/png" />


<title>Conference</title>
<style>
	body {
	margin: 0px;
	background-color: #000000;
	position: fixed;
	width: 100%;
	height: 100%;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 14px;
  line-height: 1.42857;
  background:#535353;
 }
 .form-box {
	 margin: 150px auto 0;
		width: 700px;
	}
	.form-box .header {
    background: #0099cc none repeat scroll 0 0;
    border-radius: 4px 4px 0 0;
    color: #fff;
    font-size: 20px;
    font-weight: 300;
    padding: 25px 10px;
    text-align: center;
	}
	.form-box .body, .form-box .footer {
    background-color: #fff;
    color: #444;
    padding: 10px 20px;
	}
	.bg-gray {
    background-color: #eaeaec !important;
	}

	.form-box .body > .btn, .form-box .footer > .btn {
    margin-bottom: 10px;
	}
	.btn {
			border: 1px solid transparent;
			border-radius: 3px;
			box-shadow: 0 -1px 0 0 rgba(0, 0, 0, 0.09) inset;
			font-weight: 500;
	}
	.bg-blue {
			background-color: #0073b7 !important;
	}
	.form-box .body > .form-group, .form-box .footer > .form-group {
    margin-top: 20px;
	}
	.form-group {
			margin-bottom: 15px;
	}
	.form-box .body > .btn, .form-box .footer > .btn {
    margin-bottom: 10px;
	}
	.bg-red, .bg-yellow, .bg-aqua, .bg-blue, .bg-light-blue, .bg-green, .bg-navy, .bg-teal, .bg-olive, .bg-lime, .bg-orange, .bg-fuchsia, .bg-purple, .bg-maroon, .bg-black {
    color: #f9f9f9 !important;
	}
	.btn-block {
    display: block;
    width: 100%;
	}
	.btn {
			-moz-user-select: none;
			background-image: none;
			border: 1px solid transparent;
			border-radius: 4px;
			cursor: pointer;
			display: inline-block;
			font-size: 14px;
			font-weight: 400;
			line-height: 1.42857;
			margin-bottom: 0;
			padding: 6px 12px;
			text-align: center;
			vertical-align: middle;
			white-space: nowrap;
	}
	.form-box .body > .form-group > input, .form-box .footer > .form-group > input {
    border: medium none #fff;
	}
.form-control {
    border-radius: 0 !important;
    box-shadow: none;
}
.form-control {
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
	button, input, select, textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
	}
	input {
			line-height: normal;
	}
	button, input, optgroup, select, textarea {
			color: inherit;
			font: inherit;
			margin: 0;
	}
	* {
			box-sizing: border-box;
	}
	.form-control::-moz-placeholder {
			color: #999;
			opacity: 1;
	}
	.text-center {
			text-align:center;
	}
	#btnlogin { width:100px; background:#ff8c1a; color:#fff; margin-top:10px;float:left;display:block;}
	.formfill label { color:#777; }
	.addbtm20px { margin-bottom:20px; }
	.addtop20px { margin-top:20px; }
</style>
</head>
<body>
<form method="post" action="" id="frmsave">
	<div class="form-box" id="login-box">
		<div class="header">This Presentation has ended.</div>
		<div class="body formfill">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row addtop20px">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<p style="font-size:15px;margin-top:5px;">For further details or to view the presentation again, contact</p>
							<?php
								require_once('dbconf.php');
								$stmt = $db->prepare("select uid,id,(select concat(name,' ',lastname) as name from users where id=livepitch.uid) as name,(select email from users where id=livepitch.uid) as email,(select mobile from users where id=livepitch.uid) as mobile from livepitch where id=:id");
								$stmt->execute(array(':id'=>$_GET['id']));
								$details = $stmt->fetch(PDO::FETCH_ASSOC);
							?>
							<span style="display:block;"><?php echo $details['name']; ?></span>
							<span style="display:block;"><?php echo $details['mobile']; ?></span>
							<span style="display:block;"><?php echo $details['email']; ?></span>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><br><br>
							<span style="color:#777;margin-left:-55px;">Powered by</span><br>
							<a href="https://www.trainybee.com" target="_blank" class=""><img src="images/index.png" style="width:135px;"></a>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div  style="margin-top:60px;border-top:1px solid #999;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer text-center">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<span style="color:#0099cc;display:block;float:left;font-size:14px;"><strong>Get Smarter, Start using Trainybee</strong></span>
					<span style="display:block;float:left;">Know who read your documents, time spent on each page &amp; whom they shared it with.</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<a href="javascript:void(0)" id="" class="" style="border-radius:2px;background:#ff8c1a; color:#fff;float:left;padding:5px 10px;display:block;margin-bottom:10px;margin-top:5px;text-decoration:none;">Get Started</a>
				</div>
			</div>
		</div>
	</div>
</form>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
$('#btnlogin').click(function(){
	if($('#name').val()==''){ alert("Enter your Name !"); $('#name').focus(); return false; }
	if($('#compamyname').val()==''){ alert("Enter your company Name !"); $('#compamyname').focus(); return false; }
	if($('#emailid').val()==''){ alert("Enter your Email id !"); $('#emailid').focus(); return false; }
	if($('#accesscode').val()==''){ alert("Enter contact number !"); $('#accesscode').focus(); return false; }
	$('#frmsave').submit();
});
</script>

