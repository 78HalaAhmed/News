<?php
	include_once("includes/logged.php");
	include_once("includes/conn.php");
	$status = false;
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$status = true;
	}elseif($_SERVER["REQUEST_METHOD"] === "POST"){
		$status = true;
		$id = $_POST["id"];
		$newsDate = $_POST["newsDate"];
		$title = $_POST["title"];
		$content = $_POST["content"];
		$author = $_POST["author"];
		$active = $_POST["active"];
		if(isset($active)){
			$active = 1;
		}else{
			$active = 0;
		}
		$oldImage=$_POST["oldImage"];
		include_once("includes/updateImage.php");	
		$category_id=$_POST["categoryname"];
		//Update news
		$sql = "UPDATE `news` SET `newsDate`=?,`title`=?,`content`=?,`author`=?,`active`=?,`image`=?,`category_id`=? WHERE id=?"; 
		$stmt = $conn->prepare($sql);
		$stmt->execute([$newsDate, $title, $content, $author, $active, $image_name, $category_id, $id]);
		// echo "Updated successfully";
	}
	if($status){
		try{
			$sql = "SELECT * FROM `news` WHERE id=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$id]);
			$result = $stmt->fetch();
			$id = $result["id"];
			$newsDate = $result["newsDate"];
			$title = $result["title"];
			$content = $result["content"];
			$author = $result["author"];
			$active = $result["active"];
			if($active){
				$activeNews = "checked";
			}else{
				$activeNews = "";
			}
			$image = $result["image"];
			$catID=$result["category_id"];
		}catch(PDOException $e){
			echo "Can't get news data: " . $e->getMessage();
		}
		//Select categories
		$sql = "SELECT * FROM `categories`";
		$stmtCat = $conn->prepare($sql);
		$stmtCat->execute();
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>News Admin | Edit News</title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>
<?php
	if($status){
?>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">

			<!-- start of nav page -->
		    <?php 
          		include_once("includes/nav.php");
        	?>
		  	<!-- end of nav page -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Manage News</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Edit News</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a class="dropdown-item" href="#">Settings 1</a>
												</li>
												<li><a class="dropdown-item" href="#">Settings 2</a>
												</li>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="News-date">News Date <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="date" id="News-date" required="required" class="form-control" name="newsDate" value="<?php echo $newsDate ?>">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="title" required="required" class="form-control" name="title" value="<?php echo $title ?>">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="content">Content <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="content" name="content" required="required" class="form-control"><?php echo $content ?></textarea>
											</div>
										</div>
										<div class="item form-group">
											<label for="author" class="col-form-label col-md-3 col-sm-3 label-align">Author <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="author" class="form-control" type="text" name="author" value="<?php echo $author ?>" required="required">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Active</label>
											<div class="checkbox">
												<label>
													<input type="checkbox" class="flat" name="active" <?php echo $activeNews ?>>
												</label>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="file" id="image" name="image" required="required" class="form-control">
												<img src="../img/<?php echo $image ?>" alt="<?php echo $title ?>" style="width:200px;">
											</div>
										</div>

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Category <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" name="categoryname" id="">
													<?php
														foreach($stmtCat->fetchAll() as $row){
															$curCategory = $row["categoryname"];
															$curCatID = $row["id"];
															if($curCatID == $catID){
																$selected = "selected";
															}else{
																$selected = "";
															}
													?>
													<option value="<?php echo $curCatID ?>" <?php echo $selected ?>><?php echo $curCategory ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<input type="hidden" name="id" value="<?php echo $id ?>">
										<input type="hidden" name="oldImage" value="<?php echo $image ?>">
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button class="btn btn-primary" type="button">Cancel</button>
												<button type="submit" class="btn btn-success">Update</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>

</body>
<?php
	}else{
		echo "Invalid request";
	}
?>
</html>