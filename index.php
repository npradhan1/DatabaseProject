<?php
	session_start();
	$userSet = false;	
	
	if (isset($_SESSION['mid'])){
		$userSet = true; // user exists in session !!
		$mid = $_SESSION['mid'];
		$fname = $_SESSION['fname'];
	}else{
		//connect database
		$dbHost = "localhost";
		$dbUser = "root";
		$dbPass = "";
		$dbname = "bookstore";
		$dbconnect = mysql_connect($dbHost,$dbUser,$dbPass)	or die("Unable to connect to the MySQL");
		mysql_select_db($dbname,$dbconnect);
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$emailId = $_POST['emailId'];
			$passwd = $_POST['passwd'];
			echo $emailId;
			echo $passwd;
			$error_arr = array();

			if($emailId == ''){
				$error_arr['emailId'] = 'Email ID Required';
			}
			else if($passwd == ''){
				$error_arr['passwd'] = 'Password Required';
			}else{
				$valid_arr['emailId'] = $emailId;
				$valid_arr['passwd'] = $passwd;
			}

			if(count($error_arr) == 0){
				$_SESSION['emailId'] = $valid_arr['emailId'];
				$_SESSION['passwd'] = $valid_arr['passwd'];
				$password = md5($valid_arr['passwd']);
				//$user_query = mysql_query("SELECT * FROM members where email = '{$_SESSION['emailId']}'") or die("Unable to connect to query");
				$usertype_query = mysql_query("SELECT admin FROM members where email = '{$_SESSION['emailId']}' AND `password` = '$password'") or die("Unable to connect to query");
				$user_query = mysql_query("SELECT * FROM members where email = '{$_SESSION['emailId']}' AND `password` = '$password'") or die("Unable to connect to query");
				$query_num_rows = mysql_num_rows($user_query);

				if($query_num_rows == 0){
				
						$error_arr['passwd'] = 	'Invalid Email ID/Password';
				}
				else if($query_num_rows == 1){
					while($row = mysql_fetch_array($user_query)) {
						if ($row['email'] == $_SESSION['emailId']){
							$_SESSION['userType'] = $row['admin'];
							$_SESSION['mid'] = $row['m_id'];
							$_SESSION['fname'] = $row['first_name'];
							$error_arr['passwd'] = $_SESSION['fname'];
						}
					}
					$userSet = true; // user exists in session !!
					header('Location: index.php');
				}
				else{
					echo 'Error Occured';
				}
			}
		}
	}
?>

<html>
<head>

	<title>Library Management System</title>
	<link rel="stylesheet" href="http://bootswatch.com/slate/bootstrap.css" media="screen">
    <link rel="stylesheet" href="http://bootswatch.com/assets/css/bootswatch.min.css">
	<link rel="shortcut icon" href="./Bootswatch_Slate_files/favicon.png">
    <script type="text/javascript" src="./Bootswatch_Slate_files/ga.js"></script>
	<script type="text/javascript" src="./Bootswatch_Slate_files/bsa.js"></script>
	<script type="text/javascript" id="_bsap_js_c466df00a3cd5ee8568b5c4983b6bb19" src="./Bootswatch_Slate_files/s_c466df00a3cd5ee8568b5c4983b6bb19.js"></script>
	<script type="text/javascript">
    function showHide() {
        var div = document.getElementById("hidden_div");
        if (div.style.display == 'none') {
            div.style.display = '';
        }

        else {
            div.style.display = 'none';
        }
    }
	
	function Clear(){    
		document.getElementById("eid").value= "";
		document.getElementById("pid").value= "";
	}
	</script>

</head>

<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
	        <div class="navbar-header">
	          	<a href="index.php" class="navbar-brand">Home</a>
	        </div>
			<div class="navbar-header">
	          	<a href="registration.php" class="navbar-brand">Sign Up</a>
	        </div>
			<div >
				<a href="addBook.php" class="navbar-brand"> <?php echo isset($_SESSION['userType']) ? "Add Books" : "" ?> </a>
			</div>		
			
	        <div class="navbar-collapse collapse" id="navbar-main">
	        	<ul class="nav navbar-nav">
		            <li class="dropdown">
		            	<a class="dropdown-toggle" data-toggle="dropdown" id="browse">Browse Books <span class="caret"></span></a>
		            	<ul class="dropdown-menu" aria-labelledby="browse">
			                <li><a tabindex="-1" href="#">Textbooks</a></li>
			                <li><a tabindex="-1" href="#">Historical</a></li>
			                <li><a tabindex="-1" href="#">Biographies</a></li>
			                <li class="divider"></li>
			                <li><a tabindex="-1" href="#">Fantasy</a></li>
			                <li><a tabindex="-1" href="#">Science Fiction</a></li>
			                <li><a tabindex="-1" href="#">Romance</a></li>
		            	</ul>
		            </li>
				</ul>
				<label><?php echo $error_arr['emailId'];?></label>
				<label><?php echo $error_arr['passwd'];?></label>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Book Cart</a></li>
					<li>		
					<?php echo (isset($_SESSION['fname']) ? "You are logged in as ".$_SESSION['fname']." &nbsp; 
					<a href=\"logout.php\">Logout</a>" : "<a onclick=\"showHide();\">Login</a>"); ?> 
					</li>
				</ul>
				<div id="hidden_div" style="display:none;padding-top:10px;padding-left:20px;" class="navbar-header">
					<form name='registration' class="form-inline" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">

						<input type="text" id="eid" name="emailId" size="20" class="input-small" placeholder="Email"/>&nbsp;
					
						<input type="password" id="pid" name="passwd" size="20" class="input-small" placeholder="Password"/>&nbsp;
						
						<input type="submit" value="Submit" class="btn-small"/></td>
						<input type="submit" value="Cancel" onclick="Clear(); showHide(); return false;" class="btn-mini">
					</form>
				</div>
				
				
	        </div>
		

      	</div>
	</div>

	<div class="container">

		<div class="page-header" id="banner">
			<div class="row">
				<div class="col-lg-6">
					<h1>Library Management Systems</h1>
					<p class="lead">Browse and Checkout Books</p>
					<br/><br/>
					<br/><br/>
					<blockquote class="pull-right">
		            	<p>The best Library Management System ever!</p>
		            	<small>Some Guy <cite title="Source Title">Somewhere</cite></small>
		            </blockquote>
				</div>
				<div class="col-lg-6">
					<div class="container">
						<div class="row">
							<div class="col-lg-1">
							</div>
							<div class="col-lg-11">
								<img src="./Bootswatch_Slate_files/books.png" id="bsap_1277971" class="bsap_1277971 bsap"></img>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bs-docs-section">

	        <div class="row">
	          <div class="col-lg-12">
	            <div class="bs-example">
	              <div class="jumbotron">
	                <h1>Jumbotron</h1>
	                <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
	                <p><a class="btn btn-primary btn-lg">Learn more</a></p>
	              </div>
	            </div>
	          </div>
	        </div>
	    </div>
    </div>

	<script src="./Bootswatch_Slate_files/jquery.min.js"></script>
    <script src="./Bootswatch_Slate_files/bootstrap.min.js"></script>
    <script src="./Bootswatch_Slate_files/bootswatch.js"></script>
</body>

</html>

