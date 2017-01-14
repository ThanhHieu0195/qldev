<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_EMPLOYEES, F_EMPLOYEES_ORGCHART, TRUE );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Sơ đồ nhân viên</title>
        <!-- css -->
        
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
        <?php require_once '../part/cssjs.php'; ?>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <?php
            require_once '../part/menu.php';
            ?>

            <div id="main-content"> <!-- Main Content Section with everything -->
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <div class="content-box column-left scroll" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Thêm thợ làm tranh</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">
							<div class="myScreen">
								<canvas id="myCanvas" width="4000" height="4000"></canvas>
							</div>
							<div id="over"></div>
							<!-- box -->
							<!-- box chức năng -->
							<div class="boxfunc boxfixed">
								<a class="btn btn-large btn-block btn-default" href="#" role="button" id="fadd">Thêm</a>
								<a class="btn btn-large btn-block btn-default" href="#" role="button" id="fmove">Chuyển</a>
								<a class="btn btn-large btn-block btn-default" href="#" role="button" id="fedit">Chỉnh sửa</a>
								<a class="btn btn-large btn-block btn-default" href="#" role="button" id="fdelete">Xóa</a>
								<a class="btn btn-large btn-block btn-default" href="#" role="button" onclick="myHide(['boxfunc']);">Thoát</a>
							</div>
							<!-- box hiện thông tin node -->
							<div class="box info">
								<p class="iname"></p>
								<p class="iid"></p>
								<p class="ictn"></p>
								<p class="iuid"></p>
							</div>
							<!-- box thêm node -->
							<div class="addbox boxfixed">
								<form action="" method="POST" role="form">
									<legend>Thêm vị trí mới</legend>
									<div class="form-group hide">
										<label for="">Key</label>
										<input type="text" class="form-control" id="addkey" placeholder="Input field" readonly>
									</div>
									<div class="form-group">
										<label for="">Mã nhân viên</label>
										<select  id="addmanv" class="form-control" required="required">
										</select>
									</div>
									<div class="form-group">
										<label for="">Mô tả</label>
										<select  id="addcontent" class="form-control" required="required">
										</select>
									</div>
									<div class="form-group hide">
										<label for="">uid</label>
										<input type="text" class="form-control" id="adduid" placeholder="Input field" readonly>
									</div>
									<button type="button" class="btn btn-primary" id="add">Thêm</button>
									<button type="button" class="btn btn-primary" onclick="myHide(['addbox']);">Thoát</button>
								</form>
							</div>
							
							<div class="movebox boxfixed">
								<form action="" method="POST" role="form">
									<legend>Thay đổi vị trí</legend>
									<div class="form-group hide">
										<label for="">Key</label>
										<input type="text" class="form-control" id="movekey" placeholder="Input field" hidden="true">
									</div>
									<div class="form-group hide">
										<label for="">uid</label>
										<input type="text" class="form-control" id="moveuid" placeholder="Input field" readonly>
									</div>
									<div class="form-group">
										<label for="">Đến ví trí</label>
										<select  id="movetouid" class="form-control" required="required">
										</select>
									</div>
									<button type="button" class="btn btn-primary" id="move">Chuyển</button>
									<button type="button" class="btn btn-primary" onclick="myHide(['movebox']);">Thoát</button>
								</form>
							</div>

							<div class="editbox boxfixed">
								<form action="" method="POST" role="form">
									<legend>Thay đổi mô tả</legend>
									<div class="form-group hide">
										<label for="">Key</label>
										<input type="text" class="form-control" id="editkey" placeholder="Input field" hidden="true">
									</div>

									<div class="form-group">
										<label for="">Thay đổi mô tả</label>
										<select  id="ectn" class="form-control" required="required">
										</select>
									</div>
									<button type="button" class="btn btn-primary" id="edit">Thay đổi</button>
									<button type="button" class="btn btn-primary" onclick="myHide(['editbox']);">Thoát</button>
								</form>
							</div>

							<div class="delbox boxfixed">
								<form action="" method="POST" role="form">
									<legend>Xóa vị trí</legend>
									<div class="form-group hide">
										<label for="">Key</label>
										<input type="text" class="form-control" id="delkey" placeholder="Input field" hidden="true">
									</div>

									<div class="form-group">
										<label for="">Các ví trí bị ảnh hưởng</label>
										<select  id="delkeys" class="form-control" required="required">
										</select>
									</div>

									<button type="button" class="btn btn-primary" id="del">Xóa</button>
									<button type="button" class="btn btn-primary" onclick="myHide(['delbox']);">Thoát</button>
								</form>
							</div>

							<div id="loading">
								<img src="../resources/images/loadig_big.gif" alt="loading" />
							</div>
                        <!-- end -->
					</div>
                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>
            </div> <!-- End #main-content -->
        </div>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jcanvas.min.js"></script>

		<script type="text/javascript" src="js/orgchart.js"></script>
		<script type="text/javascript" src="js/chartstaff_server.js"></script>

		<script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
		
		<script type="text/javascript" src="js/chartstaff.js">
		</script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
