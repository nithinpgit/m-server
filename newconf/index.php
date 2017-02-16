<?php session_start();
require_once('dbconf.php');
if(isset($_POST['presentnotes']) and $_POST['presentnotes']!=''){
	$qrry = $db->prepare("delete from conferencenotes where pid=:pid");
	$qrry->execute(array(':pid'=>$_GET['room']));
	$qry = $db->prepare("insert into conferencenotes(pid,notes) values(:pid,:notes)");
	$qry->execute(array(':pid'=>$_GET['room'],':notes'=>$_POST['presentnotes']));
	$id = $_GET['room'];
	header("location:../liveanalytics.php?id=$id");
} ?>
			<input type="hidden" id="newpptid" value="<?php echo $_GET['pptid']; ?>">
			<input type="hidden" id="checktime" value="">

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <title>Conference</title>
        <script src="https://swww.tokbox.com/v2/js/opentok.min.js"></script>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/opentok-layout.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600' rel='stylesheet' type='text/css'>
        <script src="assets/js/jquery.modal.min.js"></script>
        <script type="text/javascript" src="assets/js/easyrtc.js?t=567"></script>
        <script type="text/javascript" src="assets/js/socket.io.js"></script>

				<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css?t=sd">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="assets/css/fontello.css">
        <link rel="stylesheet" href="assets/css/jquery.modal.css" />
        <script type="text/javascript" src="assets/js/demo_multiparty.js?t=234"></script>
        <script type="text/javascript" src="assets/js/whiteboard.js?n=112"></script>
        <!-- Mixed content -->
        <script type="text/javascript" src="https://malsup.github.io/jquery.blockUI.js"> </script>
				<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <style type="text/css" media="screen">
            body {
                background-color: #535353 !important;
                font-family: Arial, Helvetica, sans-serif;
            }
            video{
                display: inline-block;
                background-color: #000000;
                transition-property: all;
                transition-duration: 0.5s;
            }
            #trash-videos{
                position: fixed;
                opacity: 0;
                visibility: hidden;
            }
            .footer{
              left: 0px;
              right: 0px;
              height: 50px;
              position: fixed;
              bottom: 0px;
            }
            .btn-round{
                font-size: 20px !important;
                height: 40px !important;
                width: 40px !important;
                margin-right: 4px !important;
                margin-top: 4px !important;
                background-color: #4584a0 !important;
                border-color: #4584a0 !important;
            }
            .ctrl-holdrs{
                width: 241px;
                margin: 2px auto;
                padding-left: 5px;
                border-radius: 50px;
                background-color: #282828;
                height: 48px;
            }
            #chat-holder{
                top:45px;
                bottom:53px;
                width: 230px;
                position: fixed;
                right: 0px;
                background-color: #fff;
            }
            #layout {
                top: 0px;
                left: 0px;
                right: 230px;
                bottom: 53px;
                background-color: #000;

            }
            .presentation-active{
                top:0px;
                bottom: 53px;
                width: 500px;
                position: fixed;
                background-color: #fff;
            }
            #currentSlide {
              width: 100%;
              height:auto;
            }
            .novideo-slide {
              height: 100% !important;
              max-width: 100% !important;
            }
            .widthCtrl{
              width: 193px !important;
            }
            .widthCtrl1{
              width: 145px !important;
            }
            #previous{
                position: absolute;
                bottom: 0px;
            }
            #next{
                position: absolute;
                bottom: 0px;
            }
            .pagelabal{
                width: 100px;
                left: 45%;
                position: absolute;
                bottom: 6px;
            }
            .pagelabal span{
                font-weight: bold;
            }
            .text-muted {
              color: #E2E2E2;
          }
          a{
            color: #083942 !important;
          }
          .close-icon{
                font-size: 14px;
                line-height: 13px;
                float: left;
                margin-top: 8px;
                display: none;
                margin-left: 2px;
          }
          .close-parent{
                float: left;
                margin-left: 4px;
          }
          .close-parent-mic{
                float: left;
                margin-left: 9px;
          }
          #mic-close-but{
            margin-left: 2px;
          }
          .full-cover{
            position: fixed;
            z-index: 999999999;
            background-color: #000000;
            opacity: .7;
            width: 100%;
            height: 100%;
          }
          .inner-rect{
            background-color: #555;
            color: #ffffff;
            position: fixed;
            z-index: 99999999999;
            border-radius: 3px;
            padding: 15px;
            width: 380px;
            height: 212px;
            top: 30%;
            left: 38%;
          }
          .inner-rect button{
                width: 70px;
                margin-left: 138px;
          }
          /*
          * whiteboard styles
          */
          #wb_tools{
            height: 36px;
            width: 100%;
            background-color: #EFEFF3;
            border-bottom-color: #ccc;
            border-bottom-width: 1px;
            border-bottom-style: solid;
            padding: 4px 7px 0;
          }
          #toolbar {
            clear: both;
            margin: 0 auto;
            padding: 0;
            width: 590px;

          }
          .color_sel{
            width: 20px;
            height: 20px;
            border-radius: 20px;
            background-color: #ff0000;
            border: 1px solid #ccc;
            cursor: pointer;
          }
          .thick_sel{
            width: 20px;
            height: 20px;
            border-radius: 20px;
            background-color: #000;
            cursor: pointer;
          }
          #toolbar li {
              float: left;
              list-style: none;
              padding: 3px;
              border: 1px solid #ccc;
              background-color: #ffffff;
          }
          #toolbar li .shapes {
              height: 20px;
              width: 26px;
              background-repeat: no-repeat;
              cursor: pointer;
          }
          #toolbar li .shapes#pen {
              background-image: url('assets/images/tools/pen.png');
              background-size: 16px;
              background-position: 4px 2px;
          }
          #toolbar li .shapes#text {
              color: #4a4a4a;
              font-weight: bold;
              width: 100%;
              padding-left: 4px;
              padding-right: 4px;
          }
          #toolbar li .shapes#ellipse {
              background-image: url('assets/images/tools/elipse.png');
              background-size: 16px;
              background-position: 6px 2px;
          }
          #toolbar li .shapes#rectangle {
              background-image: url('assets/images/tools/rect.png');
              background-size: 16px;
              background-position: 6px 2px;
          }
          #toolbar li .shapes#highlighter {
              background-image: url('assets/images/tools/marker.png');
              background-size: 18px;
              background-position: 3px 1px;
          }
          #toolbar li .shapes#eraser {
              background-image: url('assets/images/tools/eraser.png');
              background-size: 16px;
              background-position: 4px 2px;
          }
          #toolbar li .shapes#clr {
              background-image: url('assets/images/tools/clearboard1.png');
              background-position: 4px 2px;
          }
          #whiteboard{
            position: absolute;
            width: 100%;
            height: 85%;
          }
          canvas{
            position: absolute;

          }

          .selected{
            background-color: #A7E7F7 !important;
          }
          .canvas-ip{
            position:absolute;
            z-index:999;
            font-family: Arial;
            font-size:18px;
            border:none;
            padding: 0;
            background:transparent;
          }
          .canvas-div{
            display: none !important;
          }
          .pres-vid-dis{
              width: auto;
              left: 0px;
          }
           .btn-control {
                        border-radius: 50px !important;
                        background-color: #4584a0 !important;
                        border-color: #4584a0 !important;
                        font-size: 13px !important;
                        height: 25px !important;
                        margin-right: 4px !important;
                        margin-top: 4px !important;
                        width: 25px !important;
                        color:#fff !important;
                        float:right;
                        text-align:center;
                        line-height:1.8;
                        }
                .adchkbox checkbox { font-size:13px; }
                .pull-right { float:right }
          input[type="checkbox"] {
            margin: 5px 5px 3px;
            margin-top: 1px \9;
            line-height: normal;
          }
          #adm_contrl{
            float: left;
            margin-left: 20px;
            margin-top:8px;
            cursor:pointer;
          }
          .arrow-device{
              margin-top: -20px;
              width: 23px;
              margin-left: 38px;
              /* margin-right: 100px; */
              transform: rotate(179deg);
          }
          .allow-dev-cont{
                width: 300px;
                z-index: 9;
                /* margin: 0px auto; */
                margin-left: 4px;
          }
          .arrow-div{
              text-align: center;
              position: absolute;
              top: 8px;
          }
          .user-list-box{
              border-bottom-color: #ababab;
              border-bottom-style: solid;
              border-bottom-width: 1px;
              display: -moz-inline-box;
              float: right;
              width: 281px;
          }
          .adcontrol{
              border-bottom-color: #ababab;
              border-bottom-style: solid;
              border-bottom-width: 1px;
              display: -moz-inline-box;
              float: right;
              margin-right: 9px;
              padding-bottom: 3px;
              width: 281px;
          }
          .chck-gap{
            margin-left: 2px !important;
            margin-right: 13px !important;
          }
          .no-part{
            margin: 63px auto 0;
            width: 172px;
          }
          .part-head{
              background-color: #444;
              color: #fff;
              font-family: inherit;
              font-size: 14px;
              padding: 4px;
              width: 100%;
          }
          #userList{
              background: #fff none repeat scroll 0 0;
              border-bottom-left-radius: 4px;
              border-bottom-right-radius: 4px;
              height: 150px;
              padding: 10px;
              width: 300px;
          }
          #close-part{
            float: right;
            color: white;
            cursor: pointer;;
          }
           #close-allow{
              color: white;
              cursor: pointer;
              float: right;
              margin-right: 4px;
          }
        .bgfooter{ bottom:0px;width: 100%;position: fixed;right: 0px;background-color: #ddd;height:52px; }
				#tot_users { float:right;margin-right:200px;line-height:3.5;color:#0099cc; }
				#chat_input { height:8%; }
				#contrlPop{position:fixed;bottom:50px;left:10px;z-index:9;display:none;}
					.newform {
						background-color: #fff;
						background-image: none;
						border: 1px solid #ccc;
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
				#smallcopylinkbtn { margin-top:5px;margin-left:10px;display:none; }
				#smallendbtn { margin-top:5px;margin-right:10px;display:none; }
				#copylinkbtn { margin-left:10px;color:#fff;line-height:3.2; }
				#dropdownthree { margin-right:50px;margin-top:6px;background:#fff;font-size:14px;border: 1px solid silver;border-radius: 0px;color: #848484;width:500px; }
        </style>
        <script>




        var QueryString = function () {
              var query_string = {};
              var query = window.location.search.substring(1);
              var vars = query.split("&");
              for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if (typeof query_string[pair[0]] === "undefined") {
                  query_string[pair[0]] = decodeURIComponent(pair[1]);
                    } else if (typeof query_string[pair[0]] === "string") {
                  var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                  query_string[pair[0]] = arr;
                    } else {
                  query_string[pair[0]].push(decodeURIComponent(pair[1]));
                }
              }
                return query_string;
            }();
            // Video ID
            	var url = window.location.href;
							var su = url.split('?');
							var ma = su[1].split('&');
							var room = ma[0].split('=');
							var pid = room[1];
							var video = ma[2].split('=');
							if(typeof(ma[3]) != "undefined" && ma[3] !== null){ var lids = ma[3].split('='); var lid = lids[1]; } else{ var lid = 0; }

            var     roomname            =  QueryString.room;
            var     user_name           = QueryString.name;
            var     myimage             = "images/avatar.png";
            var     screenenable        = QueryString.screen;
            var     presentation_active = 1;
            var micenable               = 0;
            var screenenable            = 0;
            var camAllow                = QueryString.video;
            var camenable               = 0;
            var chatenable              = QueryString.chat;
            $(document).ready(function(){
						ppt_id = $('#newpptid').val(); runtime();
						});
            var     pptRoot      =  'https://s3-ap-southeast-1.amazonaws.com/bmt.myfiles/';
            var     currentpage         = '1';
            var     totalpage           =  18;
            var     mode                = QueryString.mode;
            var socketId                = '0';

				function runtime(){
					var rectime;
					rectime = setInterval(showrecordtime,1000);
				var dur = 1;

				function showrecordtime() { $('#checktime').val(dur); dur++; }
				}

        </script>
    </head>
    <body>

			<?php
			if(isset($_GET['mode']) and $_GET['mode']>0){ ?>
			<div id="largetop" style="background:#367fa9;height:45px;">
				<a class="btn btn-default pull-right" href="javascript:void(0)" id="smallendbtn" style="">End</a>
				<a class="btn btn-default pull-right" href="javascript:void(0)" id="endbtn" style="margin-top:5px;margin-right:45px;">End Presentation</a>
				<div class="dropdown pull-right" style="">
					<a href="javascript:void(0)" class="btn btn-default btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right:50px;margin-top:6px;background:#fff;font-size:14px;border: 1px solid silver;border-radius: 0px;color: #848484;width:500px;" id="dropdownthree">
					Select Proposal
					<i class="fa fa-angle-down pull-right" style="font-size:20px;margin-top:-20px;"></i></a>
					<ul class="dropdown-menu changeli" aria-labelledby="dLabel" style="width:100%;height:300px; overflow: auto;">
						<?php
						require_once('dbconf.php');
						$stmt = $db->prepare("select uid,id,company,proposal,(select name from users where id=livepitch.uid) as name from livepitch where id=:id");
						$stmt->execute(array(':id'=>$_GET['room']));
						$details = $stmt->fetch(PDO::FETCH_ASSOC);
						$name = $details['name'];
						$room = $details['id'];


						$qry = $db->prepare("select * from proposal");
						$qry->execute();
						$i = 1;
						foreach($qry->fetchAll(PDO::FETCH_ASSOC) as $row){ ?>
							<li><a tabindex="-1" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-no="<?php echo $row['tstamp']; ?>" onclick="changeproposal(this)"><?php echo $row['name']; ?></a></li>
						<?php $i++; } ?>

						<input type="hidden" id="forwards" name="forwards" value="">
					</ul>
				</div>
				<?php
					//~ $qry = $db->prepare("select domain from enterprise where id=:pid");
					//~ $qry->execute(array(':pid'=>$_SESSION['EID']));
					//~ $mail = $qry->fetch(PDO::FETCH_ASSOC);
				?>
				<a class="btn btn-default pull-left" data-link="demo.trainybee.com/u.php?<?php echo $_GET['room']; ?>" href="javascript:void(0)" id="smallcopylinkbtn" style="">Link</a>
				<?php if(isset($_GET['qp']) and $_GET['qp']>0){
					$qry = $db->prepare("select shorturl,email from users where id=:id");
					$qry->execute(array(':id'=>$_GET['uid']));
					$mail = $qry->fetch(PDO::FETCH_ASSOC);
				?>
				<span style="" id="copylinkbtn"><strong>Presentation Link : </strong>demo.trainybee.com/<?php echo $mail['shorturl']; ?></span>
				<?php } else { ?>
				<span style="" id="copylinkbtn"><strong>Presentation Link : </strong>demo.trainybee.com/u.php?<?php echo $_GET['room']; ?></span>
				<?php } ?>
			</div>
			<?php } ?>
		<div style="position:absolute;top:45px;">
      <div id="layout"></div>
    <div id="trash-videos">
			<video id="box0" class="transit boxCommon thumbCommon easyRTCMirror" muted="muted" volume="0" ></video>
			<video id="box1" class="transit boxCommon thumbCommon"></video>
			<video id="box2" class="transit boxCommon thumbCommon"></video>
			<video id="box3" class="transit boxCommon thumbCommon"></video>
			<video id="box4" class="transit boxCommon thumbCommon"></video>
			<video id="box5" class="transit boxCommon thumbCommon"></video>
			<video id="box6" class="transit boxCommon thumbCommon"></video>
			<video id="box7" class="transit boxCommon thumbCommon"></video>
			<video id="box8" class="transit boxCommon thumbCommon"></video>
			<video id="box9" class="transit boxCommon thumbCommon"></video>
			<video id="box10" class="transit boxCommon thumbCommon"></video>
			<video id="box11" class="transit boxCommon thumbCommon"></video>
    </div>
    <div id="presentation" style="top:45px;" class="presentation-active">
       <div id="wb_tools">
         <ul id="toolbar">
              <li title="Pen" class="draw selected" onClick="changeTool(this,'pen')"><div  class="shapes" id="pen" data-shape="pen"></div></li>
               <li title="Text" class="draw" onClick="changeTool(this,'text')"><div class="shapes" id="text" data-shape="text"> T </div></li>
              <li title="Ellipse" class="draw" onClick="changeTool(this,'ellipse')"><div class="shapes" id="ellipse" data-shape="ellipse"></div></li>
              <li title="Rectangle" class="draw" onClick="changeTool(this,'rectangle')"><div class="shapes" id="rectangle" data-shape="rectangle"></div></li>
              <li title="Highlighter" class="draw" onClick="changeTool(this,'highlighter')"><div class="shapes" id="highlighter" data-shape="highlighter"></div></li>

              <li title="Eracer" class="draw" onClick="changeTool(this,'eraser')"><div class="shapes" id="eraser" data-shape="eraser"></div></li>
              <li title="Clear All" onClick="changeTool(this,'clear')"><div class="shapes" id="clr" data-shape="clear"></div></li>
              <li title="Black Color" class="color selected" onClick="changeColor(this,'black')"> <div class="color_sel" style="background-color:black;"></div></li>
              <li title="Red Color" class="color" onClick="changeColor(this,'red')"> <div class="color_sel"  style="background-color:red;"></div></li>
              <li title="Blue Color" class="color" onClick="changeColor(this,'blue')"> <div class="color_sel"  style="background-color:blue;"></div></li>
              <li title="Green Color" class="color" onClick="changeColor(this,'green')"> <div class="color_sel"  style="background-color:green;"></div></li>
              <li title="Yellow Color" class="color" onClick="changeColor(this,'yellow')"> <div class="color_sel"  style="background-color:yellow;"></div></li>
              <li title="2px" class="thick selected thicks1" style="padding: 11px 11px 10px 11px;" onClick="changeThick(this,2)"> <div class="thick_sel"  style="width:5px;height:5px;"></div></li>
              <li title="4px" class="thick thicks2" onClick="changeThick(this,4)" style="padding: 9px 9px 7px 9px;"> <div class="thick_sel" style="width:10px;height:10px;"></div></li>
              <li title="6px" class="thick thicks3" onClick="changeThick(this,6)" style="padding: 6px 6px 5px 6px;"> <div class="thick_sel" style="width:15px;height:15px;"></div></li>
              <li title="8px" class="thick thicks4" onClick="changeThick(this,8)"> <div class="thick_sel" style="width:20px;height:20px;"></div></li>
          </ul>
       </div>
       <div style="height:85%;overflow:auto;" id="slidesection">
           <img style="" id="currentSlide"/>
           <div id="whiteboard">
              <canvas id="canvas2" style="z-index: 0;"></canvas>
              <canvas id="canvas" style="z-index: 1;"></canvas>
          </div>
       </div>
       <div>
					<a style="left: 10%; width: 32px; border-radius:50%;background:#0099cc;margin-bottom:5px;" id="previous" href="#" class="btn"><i class="fa fa-step-backward" style="color:#fff;"></i></a>
					<a class="btn" href="#" id="next" style="right: 10%; width: 32px; border-radius:50%;background:#0099cc;margin-bottom:5px;"><i class="fa fa-step-forward" style="color:#fff;"></i></a>
					<div class="pagelabal">
							<span class="curpage"> </span> Out Of <span class="totalpage"> </span>
					</div>
        </div>
    </div>
    <div id="chat-holder">
          <div id="rightpart" class="box no-margin chat-wraper" style="height:100% " >
                                <div class="box-header" style="height:8%">
                                    <h3 style="font-size:18px;" class="box-title text-white"><i class="icon icon-chat"></i> Chat</h3>
                                    <div title="" data-toggle="tooltip" class="box-tools pull-right" data-original-title="Status">
                                    </div>
                                </div>

                                  <div id="chat-box" class="box-body chat" style="overflow: auto; width:100%;overflow-x: hidden;">

                            </div><!-- /.chat -->
                                <div style="" id="chat_input">
                                    <input id="message_input" style="height: 100%;" placeholder="Type message..." class="form-control">
                            </div>


        </div>
    </div>
		<div class="bgfooter">
			<span id="tot_users" style=""></span>
			<button id="adm_contrl" style="display:none;" type="button" class="btn btn-primary">Admin Controls</button>
			 <div class="ctrl-holdrs">
					<button id="mic-close" class="btn btn-info btn-round" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Microphone"><i id="mic-but" class="icon icon-mic close-parent-mic"></i><i id="mic-close-but" style="display:block" class="icon icon-cancel close-icon"></i></button>
					<button  id="cam-close" class="btn btn-info btn-round" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Webcam"><i id="vid-cam" class="icon icon-videocam close-parent"></i><i   id="cam-close-but" style="display:block" class="icon icon-cancel close-icon"></i></button>

					<button  id="chat-close" class="btn btn-info btn-round" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Webcam"><i id="chat-cam" class="icon icon-chat"></i><i   id="chat-close-but" class="icon icon-cancel close-icon"></i></button>

					<button  id="upload-ppt" class="btn btn-info btn-round" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Webcam"><i id="upload-ppt-but" class="fa fa-upload"></i><i   id="chat-close-but" class="icon icon-cancel close-icon"></i></button>

					<button id="hide-ppt" class="btn btn-info btn-round" data-toggle="tooltip" data-placement="right" title="" data-original-title="show ppt"><i class="icon icon-monitor" id="hide-ppt-but"></i><i   id="ppt-close-but" class="icon icon-cancel close-icon"></i></button>

				</div>
		</div>
    <div id="enable_device" style="position:fixed;top:10px;width:100%;z-index:9;">
            <div class="allow-dev-cont">
                <div style="background:#fff;height:151px;width:300px;padding:10px;border-radius: 4px;box-shadow:1px 0px 6px -1px;text-align:center;">
                    <strong>Give allow permission to camera and mic</strong>
                    <p style="margin-top:15px;">If your camera and mic not allowed you can enable cam and mic here. This does not publish your cam or mic to remote user.Camera/mic publish only if you click allow cam button from application</p>
                </div>
                <div class="arrow-div">
                  <img src="images/arow.png" class="arrow-device">
                </div>
            </div>
    </div>
    <div id="enable_cam" style="position:fixed;bottom:50px;width:100%;z-index:9;">
				<div style="width:300px;z-index:9;margin: 0px auto;">
					<div style="background:#444;height:20px;border-radius:4px 4px 0 0;"><span id="close-allow"><i class="fa fa-times-circle" aria-hidden="true"></i></span></div>
					<div style="background:#fff;height:100px;width:300px;padding:10px;border-radius: 0 0 4px 4px;box-shadow: 2px 0 6px -1px;text-align:center;">
							<strong>Your Camera has been Enabled</strong>
							<p style="margin-top:15px;">Click to start your webcam and audio</p>
					</div>
					<div style="text-align:center;">
					<img src="images/arow.png" style="height: 16px;margin-top: -5px;width: 18px;margin-right:100px;">
					</div>
				</div>
			</div>
      <div id="contrlPop" style="">
      <div class="part-head">
         &nbsp;<i class="fa fa-users"></i>  Participants
         <span id="close-part"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
      </div>
             <div class="adcontrol">
                    <a class="btn-control" data-toggle="tooltip" data-placement="right" title="" data-original-title="show ppt"><i class="icon icon-monitor" id="hide-ppt-but"></i><i   id="ppt-close-but" class="icon icon-cancel close-icon"></i></a>
                    <a class="btn-control" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Webcam"><i id="chat-cam" class="icon icon-chat"></i><i   id="chat-close-but" class="icon icon-cancel close-icon"></i></a>
                    <a class="btn-control" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Webcam"><i id="vid-cam" class="icon icon-videocam"></i><i   id="cam-close-but" class="icon icon-cancel close-icon"></i></a>
                    <a class="btn-control" data-toggle="tooltip" data-placement="right" title="" data-original-title="Share Microphone"><i id="mic-but" class="icon icon-mic"></i><i id="mic-close-but" class="icon icon-cancel close-icon"></i></a>
                </div>
            <div id="userList">
            </div>
            <div style="text-align:left;">
                <img src="images/arow.png" style="height: 16px;margin-top: -5px;width: 18px;margin-left: 50px;">
            </div>
        </div>
        </div>
    <!--<div id="enterName" class="full-cover" style="display: none;"></div>
    <div class="inner-rect">
       <div class="form-group">
           <label for="usr">Enter Your Room ID:</label>
           <input type="text" class="form-control" id="room">
        </div>
        <div class="form-group">
           <label for="usr">Enter Your Name:</label>
            <input type="text" class="form-control" id="name">
        </div>

        <button type="button" class="btn btn-primary" onclick="checkJoin()">Join</button>
    </div>-->
    <div id="modal" class="modal" style="display: none;"></div>

<div style="display:none;" id="endpresentation"></div>
<div style="display:none;" id="endpresent">
	<form method="post" action="../liveanalytics.php?id=<?php echo $_GET['id']; ?>" id="frmsavenotes">
	<div style="background:#0099cc; border-radius: 4px 4px 0 0;color:#fff;padding:20px 10px;"><strong>Pitch over? Add notes to your Pitch</strong></div>
	<div style="padding:5px 15px;">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			</div>
		</div>
		<div class="row addbtm10px">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Company Name</label>
				<input type="text" class="newform" value="<?php echo $details['company']; ?>">
			</div>
		</div>
		<div class="row addbtm10px">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label>Notes</label>
				<textarea class="newform" name="presentnotes" id="presentnotes" style="height:100px;resize:none;"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label>Total Viewers</label>
				<div class="dropdown" style="">
				<a href="javascript:void(0)" class="btn btn-default btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background:#fff;font-size:14px;border: 1px solid silver;border-radius: 0px;color: #848484;width:100%;" id="viewerdropdown">
				Select Viewer
				<i class="fa fa-angle-down pull-right" style="font-size:20px;margin-top:-20px;"></i></a>
				<ul class="dropdown-menu changelis" aria-labelledby="dLabel" style="width:100%;">
					<?php
					$qry = $db->prepare("select * from livepitchuser where pid=:pid");
					$qry->execute(array(':pid'=>$_GET['room']));
					foreach($qry->fetchAll(PDO::FETCH_ASSOC) as $user){
						echo '<li><a tabindex="-1" href="javascript:void(0)" data-id="'.$user['id'].'" onclick="changeuser(this)">'.$user['name'].'</a></li>';
					}
					?>
					<input type="hidden" id="" name="" value="">
				</ul>
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div id="usersdetails"></div>
			</div>
		</div>
		<div class="row addbtm10px" style="margin-top:30px;margin-bottom:15px;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<a href="javascript:void(0)" style="color:#ddd;margin-right:0px;text-decoration:none;" id="cancelend">Cancel</a>
				<a style="background:#0099cc;padding:5px 10px;border-radius:2px;color:#fff;text-decoration:none;" id="savenotes" href="javascript:void(0)" >Save Notes</a>
			</div>
		</div>
	</div>
	</form>
</div>
<script>
  var isIE8 = window.XDomainRequest ? true : false;
  var invocation = createCrossDomainRequest();
  var url = 'https://demo.trainybee.com/conference/miscellanious.php?m=newjoinees';
  function createCrossDomainRequest(url, handler) {
    var request;
    if (isIE8) {
      request = new window.XDomainRequest();
      }
      else {
        request = new XMLHttpRequest();
      }
    return request;
  }

  function callOtherDomain() {
    if (invocation) {
				$.post('../conference/miscellanious.php?m=newjoinees', { pid:pid }, function(data){
					var msg = 'Has joined the presentation';
					var myimg = "images/avatar.png";
					var chat = data.split('<br>');
					var username = chat[0];
					if(parseInt($('#ucount').html()) < chat[1]){
						$('#ucount').html('0'); } else { }
					if(username!='')
					{
						renderChat(username,msg,myimg);
						var obj         = {};
						obj['method']   = 'chat';
						obj['message']  = msg;
						obj['name']     = username;
						obj['image']    = myimg;
						//var msg         = JSON.stringify(obj);
						//sendText(msg);
            sendDataToAll(obj);
					}
				});
    }
    else {
      var text = "No Invocation TookPlace At All";
      var textNode = document.createTextNode(text);
      var textDiv = document.getElementById("textDiv");
      textDiv.appendChild(textNode);
    }
  }
setInterval(function(){
	callOtherDomain();
 }, 3000);
</script>
    </body>

    <script type="text/javascript" charset="utf-8">

    $('document').ready(function(){
        if(presentation_active == '1'){
            presentationAdded();
        }
        $('#next').click(function(){
        if(currentpage < totalpage){
           currentpage++;

           $('#currentSlide').attr('src',pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png');
           setPage();

            var obj         = {};
            obj['method']   = 'slide_switch';
            obj['slide']    = currentpage;
						obj['curslide']    = pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png';
            //var msg         = JSON.stringify(obj);
            //sendText(msg);
            sendDataToAll(obj);


					var pageURL = document.referrer;
					var curs = pageURL.split('?');
					//var curdomain = curs[0]+'slidetime.php';
					$.post('../conference/slidetime.php', { pid:pid, pptid:ppt_id, slideno:((currentpage)-1), time:$('#checktime').val() }, function(data){
						dur = 1;
					});

        }


      })
      $('#previous').click(function(){

           if(currentpage > 1){
              currentpage--;
							 $('#currentSlide').attr('src',pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png');
              setPage();

            var obj         = {};
            obj['method']   = 'slide_switch';
            obj['slide']    = currentpage;
						obj['curslide'] = pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png';
            //var msg         = JSON.stringify(obj);
            //sendText(msg);
            sendDataToAll(obj);
          var pageURL = document.referrer;
					var curs = pageURL.split('?');
					//var curdomain = curs[0]+'slidetime.php';
					$.post('../conference/slidetime.php', { pid:pid, pptid:ppt_id, slideno:((currentpage)-1), time:$('#checktime').val() }, function(data){
						dur = 1;
					});

          }
      })
    })
    function setPage(){
        $('.curpage').html(currentpage);
        $('.totalpage').html(totalpage);
    }
    function presentationAdded(){
      if(chatenable == 1){
           document.getElementById('layout').style.right = '730px';
           document.getElementById('presentation').style.right = '230px';
       }else{
        document.getElementById('layout').style.right = '500px';
        document.getElementById('presentation').style.right = '0px';
       }
       var ppt_id = $('#newpptid').val();
				if(ppt_id == '12345'){
				$('#currentSlide').attr('src',pptRoot+'1470032488').attr('style', 'width:50%;margin-top:100px;margin-left:125px;'); $('.pagelabal,#next,#previous').hide(); } else {
				$('#currentSlide').attr('src',pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png'); }
        //$('#currentSlide').attr('src',pptRoot+ppt_id+'/'+ppt_id+'_'+currentpage+'.png');

        $('#ppt-close-but').hide();
       $('#hide-ppt-but').removeClass('close-parent');
        $('#presentation').show();
        setPage();
        layout();
    }
    function presentationRemoved(){
        if(chatenable == 1){
           document.getElementById('layout').style.right = '230px';
       }else{
           document.getElementById('layout').style.right = '0px';
       }
       $('#ppt-close-but').show();
        $('#hide-ppt-but').addClass('close-parent');
       $('#presentation').hide();
       layout();
    }
    $("#message_input").keypress(function(event){
        if(event.keyCode == 13)
        {

            sendChatMsg();

        }
    });
    function sendChatMsg(){
        var message = $("#message_input").val();
        if(message!='')
        {
            renderChat(user_name,message,myimage);
            $("#message_input").val('');
            var obj         = {};
            obj['method']   = 'chat';
            obj['message']  = message;
            obj['name']     = user_name;
            obj['image']    = myimage;
            //var msg         = JSON.stringify(obj);
            //sendText(msg);
            sendDataToAll(obj);
            //alert("pid "+pid+", pptid "+ppt_id+", Slide "+currentpage);
            $.post('../conference/miscellanious.php?m=savechat', { pid:pid, msg:message, pptid:ppt_id, slide:currentpage, lid:lid }, function(data){

						});
        }
    }
    function renderChat(name,message,image){

        var chat_html  = '<div class="item">';
        chat_html += '<img class="online" alt="user image" src="'+image+'">';
        chat_html += '<p class="message">';
        chat_html += '<a class="name" href="#">';
        chat_html += '<small class="text-muted pull-right">';
        chat_html += '<i class="fa fa-clock-o"></i> '+getTime()+'</small>';
        chat_html += name+'</a>';
        chat_html += message+'</p>';
        chat_html += '</div>';
        $('#chat-box').append(chat_html);
        $("#chat-box").scrollTop($("#chat-box").prop("scrollHeight"));
    }
    function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    return h + ":" + m + ":" + s;

}


    setTimeout(checkVideoInTrash,1000);


function checkVideoInTrash(){

        var d = document.getElementById("trash-videos");
        var s = document.getElementById("layout");
        var loc = window.location;
        if (d)
        {

            for(var i = 0; i < d.childNodes.length; i++)
            {
                 var source = d.childNodes[i].src;
                 if (d.childNodes[i].mozSrcObject !== undefined) {
                     source= d.childNodes[i].mozSrcObject;
                 }

                 if(source && source != loc){
                     s.appendChild(d.childNodes[i]);
                     layout();
                 }

            }
            var vid = $("video");
                    $.map( vid, function( n, i ) {
                          n.play();
                    });

        }
        if (s)
        {
            for(var i = 0; i < s.childNodes.length; i++)
            {
                 var source = s.childNodes[i].src;
                 if (s.childNodes[i].mozSrcObject !== undefined) {
                     source= s.childNodes[i].mozSrcObject;
                 }

                 if(source && source != loc){

                 }else{
                    d.appendChild(s.childNodes[i]);
                     layout();
                 }

            }

        }
        setTimeout(checkVideoInTrash,2000);
    }
        var layoutEl = document.getElementById("layout");
        var layout = initLayoutContainer(layoutEl, {
            animate: {
                duration: 500,
                easing: "swing"
            },
            bigFixedRatio: false
        }).layout;

        function addElement() {
            var el = document.createElement("div");


            layoutEl.appendChild(el);
            el.innerHTML='<video></video>';
            layout();
        }
        var resizeTimeout;
        window.onresize = function() {
          clearTimeout(resizeTimeout);
          resizeTimeout = setTimeout(function () {
            layout();
          }, 20);
        };
/*
        $("#layout").live("dblclick", function () {
            if ($(this).hasClass("OT_big")) {
                $(this).removeClass("OT_big");
            } else {
                $(this).addClass("OT_big");
            }
            layout();
        });*/

$(document).ready(function(){
	$.post('../conference/miscellanious.php?m=showchat', { pid:pid }, function(data){
		var chat = data.split('<br>');
		$('#chat-box').append(chat[0]);
		if(chat[1]>0){
		$('#tot_users').append('Total Viewers : <span id="ucount">0</span>'); } else {
			 $('#tot_users').html('Total Viewers :<span id="ucount">0</span>');
		}
		$("#chat-box").scrollTop($("#chat-box").prop("scrollHeight"));
	});
});
$('#smallendbtn').click(function(){
	$('#endbtn').click();
});
$('#endbtn').click(function(){
	$('#endpresentation').attr('style','position:absolute;width:100%;height:'+$(window).height()+'px;top:0px;left:0px;background:#535353;opacity:0.53;').show();
	var width = $(window).width();
	var left = (parseInt(width)-700)/2;
	$('#endpresent').attr('style','position:absolute;top:100px;left:'+left+'px;width:700px;background:#fff; border-radius: 4px 4px 0 0;').show();
});
$('#cancelend').click(function(){
	$('#endpresent,#endpresentation').hide();
});
$('#dropdownthree').click(function(){
	$('ul.changeli').toggle();
});
function dropthree(e){
	$('#dropdownthree').html($(e).html()+'<i class="fa fa-angle-down pull-right" style="font-size:20px;margin-top:-20px;"></i>');
	$('#forwards').val($(e).data('id')); $('ul.changeli').hide();
	if($(e).html()=='Allow to forward'){
		$('#checkboxone').removeAttr('disabled');
	} else { $('#checkboxone').removeAttr('checked'); $('#checkboxone').attr('disabled',true); }
}
$('div.bodymain').click(function(){
	$('ul.changeli').hide();
});
function changeproposal(e){
	var ppt =$(e).data('no');
	var uid = <?php echo $_SESSION['UID']; ?>;
	var pptid = uid+'_'+ppt;
	$("#newpptid").val(pptid);

	var id = $(e).data('id');
	var lid = <?php echo $_GET['room']; ?>;
	type = $(e).html();
	$('ul.changeli').hide();
	$('#dropdownthree').html(type+'<i class="fa fa-angle-down pull-right" style="font-size:20px;margin-top:-20px;"></i>');
	//~ var url = $('#adminiframe').attr('src');
	//~ var url1 = url.split('&');
	//~ $('#adminiframe').attr('src', url1[0]+'&'+url1[1]+'&pptid='+pptid+'');

	$.post('../conference/miscellanious.php?m=addproposal',{ lid:lid,pptid:pptid }, function(data){

	});
	ppt_id = $('#newpptid').val();  presentationAdded();
}
$(document).ready(function(){
	var width = $(window).height()-50;
	$('#adminiframe').attr('style','width:100%;height:'+width+'px;border:2px solid #535353;');
});
$('#viewerdropdown').click(function(){
	$('ul.changelis').toggle();
});
function changeuser(e){
	$('ul.changelis').hide();
	$('#viewerdropdown').html($(e).html()+'<i class="fa fa-angle-down pull-right" style="font-size:20px;margin-top:-20px;"></i>');
	$.post('../conference/miscellanious.php?m=viewusrdetails', { pid:<?php echo $_GET['room']; ?>, uid:($(e).data('id')) }, function(data){
		$('#usersdetails').html(data);
	});
}
$('#savenotes').click(function(){
	$('#frmsavenotes').submit();
});
    </script>
</html>

