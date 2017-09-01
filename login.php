<?php
if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) { 
    header('HTTP/1.0 404 Not Found'); 
    exit; 
}
define('AUTH_USER', "YOUR_USERNAME_HERE");
define('AUTH_PASS', "21232f297a57a5a743894a0e4a801fc3"); // MD5 hash 'YOUR_PASSWORD'
/*===========================================
>>>>>>>>>> CODED BY BIPIN JITIYA <<<<<<<<<<<<
	Author Email: bipinjitiya77@gmail.com
	Year: 2017
===========================================*/

session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == "log")
{
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/admin.php');
	exit;
}

			$error_msg = '';
			if (isset($_POST['login']) && !empty($_POST['user']) && !empty($_POST['pass'])){
				
				$user = $_POST['user'];
				$pass = $_POST['pass'];
				if ($user == AUTH_USER && md5($pass) == AUTH_PASS){
					$_SESSION['admin'] = "log";
					header('Location: https://'.$_SERVER['HTTP_HOST'].'/admin.php');
					exit;
				}else{
					$error_msg = '<div class="alert alert-danger">Wrong username or password!</div>';
				}
			}

?>
<html>
<head>
	<title>E-Paper Login</title>
	<link rel='stylesheet' href='css/bootstrap.css' type='text/css'/>
	<style>
	.wrapper {    
		margin-top: 80px;
		margin-bottom: 20px;
	}

	.form-signin {
	  max-width: 420px;
	  padding: 30px 38px 66px;
	  margin: 0 auto;
	  background-color: #eee;
	  border: 3px dotted rgba(0,0,0,0.1);  
	  }

	.form-signin-heading {
	  text-align:center;
	  margin-bottom: 30px;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	}

	input[type="text"] {
	  margin-bottom: 0px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}

	.colorgraph {
	  height: 7px;
	  border-top: 0;
	  background: #c4e17f;
	  border-radius: 5px;
	  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	}
	</style>
</head>
<body>
	<div class = "container">
		<div class="wrapper">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="Login_Form" class="form-signin">       
				<h3 class="form-signin-heading">E-NewsPaper Sign In!</h3>
				  <hr class="colorgraph"><br>
				  <?php echo $error_msg;?>
				  <input type="text" class="form-control" name="user" placeholder="Username" required="" autofocus="" />
				  <input type="password" class="form-control" name="pass" placeholder="Password" required=""/>     		  
				 
				  <button class="btn btn-lg btn-primary btn-block"  name="login" value="Login" type="Submit">Login</button>  			
			</form>			
		</div>
	</div>
</body>
</html>

