<?php
if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) { 
    header('HTTP/1.0 404 Not Found'); 
    exit; 
}
// Change This Database Credentials 
define('DB_USER', "username"); 
define('DB_PASS', "password");
define('DB_NAME', "database");
define('DB_HOST', "localhost");
/*===========================================
>>>>>>>>>> CODED BY BIPIN JITIYA <<<<<<<<<<<<
	Author Email: bipinjitiya77@gmail.com
	Year: 2017
===========================================*/

session_start();

if(isset($_GET['logout']))
{
    $_SESSION['admin'] = 0;
	unset($_SESSION['admin']);
    session_destroy();
    header('Location: https://'.$_SERVER['HTTP_HOST'].'/login.php');
	exit;
}

if (!isset($_SESSION['admin']) && $_SESSION['admin'] != "log"){
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/login.php');
	exit;
}
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_connect_error());
?>
<html>
<head>
	<title>Admin</title>
	<link rel='stylesheet' href='css/bootstrap.css' type='text/css'/>
	<style type="text/css">
	.toast {
		width:200px;
		height:20px;
		height:auto;
		position:absolute;
		left:50%;
		margin-left:-100px;
		bottom:10px;
		background-color: #383838;
		color: #F0F0F0;
		font-family: Calibri;
		font-size: 20px;
		padding:10px;
		text-align:center;
		border-radius: 2px;
		-webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
		-moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
		box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
	}
	</style>
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
</head>
<body>
	<div id="uploadSuccess" class="toast" style="display: none;"><b>E-Paper Succesfully Added.</b></div>
	<div id="deleteSuccess" class="toast" style="display: none;"><b>E-Paper Succesfully Deleted.</b></div>
	<div id="uploadError" class="toast" style="display: none;"><b>Error while uploading E-Paper.</b></div>
	<div id="deleteError" class="toast" style="display: none;"><b>Error while Deleting E-Paper.</b></div>
	<div id="selectFile" class="toast" style="display: none;"><b>Please Select E-Paper first.</b></div>
	<div id="fileExists" class="toast" style="display: none;"><b>E-Paper Already Exists.</b></div>
	<div id="ErrorSomewhere" class="toast" style="display: none;"><b>An Error Occurred Somewhere.</b></div>
	<div id="filetypeError" class="toast" style="display: none;"><b>Only PDF format is allowed</b></div>
	
	<div class="container" style="margin-top:15px;">
		<div class="panel panel-info">
			<div class="panel-heading"><h3><strong><center>E-NEWSPAPER Uploader</center></strong></h3></div>
			<div class="panel-body">
				<center><i><strong>Select a PDF file to upload, format should be <code>epaper_{date}.pdf</code></strong></i></center><br/>
				
				<?php
				if(isset($_GET['delete_key']) && isset($_GET['delete_name']))
				{
					if(unlink("uploads/".$_GET['delete_name']))
					{
						$delete_key = $_GET['delete_key'];
						$result = mysqli_query($con,"DELETE FROM `epaper` WHERE id = '$delete_key'") or die(mysqli_connect_error());
						mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
						mysqli_query($con,"UPDATE epaper SET id = @num := (@num+1)") or die(mysqli_connect_error());
						mysqli_query($con,"ALTER TABLE epaper AUTO_INCREMENT=1") or die(mysqli_connect_error());
						if($result){
							echo "<script>$(document).ready(function(){
								$('#deleteSuccess').fadeIn(400).delay(3000).fadeOut(400);});</script>";
						}
						else{
							echo "<script>$(document).ready(function(){
								$('#deleteError').fadeIn(400).delay(3000).fadeOut(400);});</script>";
						}
					}
					else
					{
						echo "<script>$(document).ready(function(){
								$('#deleteError').fadeIn(400).delay(3000).fadeOut(400);});</script>";
					}
				}
				if(isset($_POST['submit']))
				{
					$currentDir = getcwd();
					$uploadDirectory = "/uploads/";

					$fileExtensions = ['pdf']; // Get all the file extensions
					//$allowedMimes = ['application/pdf'];

					$fileName = $_FILES['file']['name'];
					$fileTmpName  = $_FILES['file']['tmp_name'];
					$fileType = $_FILES['file']['type'];
					
					if (empty($fileName))
					{
						echo "<script>$(document).ready(function(){
									$('#selectFile').fadeIn(400).delay(3000).fadeOut(400);});</script>";
					}
					else
					{
						$getExt = explode('.',$fileName);
						$fileExtension = strtolower(end($getExt));
						//$fileMime = mime_content_type($fileTmpName);
						
						$newFileName = 'epaper_'.date("d").'.'.$fileExtension;

						//$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
						$uploadPath = $currentDir . $uploadDirectory . $newFileName; 
						
						if(file_exists( "uploads/$newFileName" )){
							echo "<script>$(document).ready(function(){
										$('#fileExists').fadeIn(400).delay(3000).fadeOut(400);});</script>";
						}
						else if (in_array($fileExtension,$fileExtensions)) {
							$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

							if ($didUpload) {
								//echo "The file " . basename($fileName) . " has been uploaded";
								//$sub = basename($fileName);
								$sub = $newFileName;
								$result = mysqli_query($con,"INSERT INTO `epaper` (`id`, `name`) VALUES ('', '$sub')") or die(mysqli_connect_error());
								mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
								mysqli_query($con,"UPDATE epaper SET id = @num := (@num+1)") or die(mysqli_connect_error());
								mysqli_query($con,"ALTER TABLE epaper AUTO_INCREMENT=1") or die(mysqli_connect_error());
								if($result){
									echo "<script>$(document).ready(function(){
										$('#uploadSuccess').fadeIn(400).delay(3000).fadeOut(400);});</script>";
								}
								else{
									echo "<script>$(document).ready(function(){
										$('#uploadError').fadeIn(400).delay(3000).fadeOut(400);});</script>";
								}
							} else {
								echo "<script>$(document).ready(function(){
										$('#ErrorSomewhere').fadeIn(400).delay(3000).fadeOut(400);});</script>";
							}
						}
						else
						{
							echo "<script>$(document).ready(function(){
										$('#filetypeError').fadeIn(400).delay(3000).fadeOut(400);});</script>";
						}
					}

				}

				?>

				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
					<input type="file" name="file" class="btn btn-default" style="float: left;" accept=".pdf"/> &nbsp;&nbsp;
					<input type="submit" name="submit" class="btn btn-primary" value="Upload E-Paper"/>
				</form>

				
				<table class="table" style="border: 1px solid #bce8f1" border="1">
					<tr>
						<th align="center">ID</th>
						<th align="center">E-PAPER</th>
						<th align="center">DELETE</th>		
					</tr>
					<?php
						
						$result = mysqli_query($con,"SELECT * FROM epaper") or die(mysqli_connect_error());
						mysqli_query($con,"set @num := 0;") or die(mysqli_connect_error());
						mysqli_query($con,"UPDATE epaper SET id = @num := (@num+1)") or die(mysqli_connect_error());
						mysqli_query($con,"ALTER TABLE epaper AUTO_INCREMENT=1") or die(mysqli_connect_error());
						if (mysqli_num_rows($result) > 0)
						{
							while ($row = mysqli_fetch_array($result)) 
							{
							$i = $row["id"];
							$u = $row["name"];
							echo "<tr>";
							echo "	<td>".$i."</td>";
							echo "	<td>".$u."</td>";
							echo "	<td align='center'><a href = '".$_SERVER['PHP_SELF']."?delete_key=".$i."&delete_name=".$u."'><span class='glyphicon glyphicon-trash' style='font-size:1.5em;'></span></a></td>";
							echo "</tr>";
							}
						}
						else
						{
							echo "<td colspan='4'><h3> No data inserted yet. </h3></td>";
						}
					?>
				</table>

				<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF'].'?logout'?>">Logout!</a>
				<a class="btn btn-primary" href="<?php echo $_SERVER['PHP_SELF'];?>">Refresh</a>
			</div>
		</div>
	</div>
	
	<div class="well">
      <p align="center">All contents copyright &copy; Bipin Jitiya. All rights reserved.<br/>Designed and Developed by <strong>Bipin Jitiya</strong></p>
	</div>
</body>
</html>
