<?php
	session_start();
	//connect database
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbname = "bookstore";
	$con=mysqli_connect($dbHost, $dbUser, $dbPass, $dbname);

	// Check connection
	if (mysqli_connect_errno($con)){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	 $mid= $_POST['mid'];
	 $fname = $_POST['firstName'];
	 $lname = $_POST['lastName'];
	 $passwd = md5($_POST['password']);
	 $line1 = $_POST['line1'];
	 $line2 = $_POST['line2'];
	 $line3 = $_POST['line3'];
	 $city = $_POST['city'];
	 $state = $_POST['state'];
	 $zipcode = $_POST['zip'];
	 $email = $_POST['email'];
	 $dob = $_POST['dob'];
	 $str_dob = date('Y-m-d',strtotime($dob));
	 	 
	 
	  $query1 = "select m_id from members where email = '$email' ";
	  $query2 = "insert into members(email, password, first_name, last_name, date_of_birth, admin) VALUES ('$email', '$passwd', '$fname','$lname','$str_dob', '0')";
	  $query3 = "select m_id from members where email = '$email' ";
	  
	  

	  echo 'query1'.$query1.'<br><br>';
	  
	 
	  $result1 = mysqli_query($con,$query1);

	  $row_cnt = mysqli_num_rows($result1);
	 if(mysqli_num_rows($result1)){
	 	echo "Member already exists. Please type in a different email address";
		mysqli_close($con);
	 }else{ 
	 	echo 'query2'.$query2.'<br><br>';
	    $result2 = mysqli_query($con,$query2);
		if($result2){
			echo 'query3'.$query3.'<br><br>';
	   		$result3 = mysqli_query($con,$query3);
			while($row = mysqli_fetch_array($result3)){
				echo $row['m_id'];
				echo "<br>";
				$email_addr =  $row['m_id'];
			}
			$query4 = "insert into addresses(m_id, line_1, city, state) VALUES ('$email_addr', '$line1', '$city', '$state')";
			$result4 = mysqli_query($con,$query4);
			echo 'query4'.$query4.'<br><br>';
			if($result4){
				mysqli_query('commit');
				//session_start();
				$_SESSION['mid'] = $mid;
				$_SESSION['fname'] = $fname;
	   			header('Location: index.php'); 	
			}else{						 						  
		  		die('Could not insert into database');
		 		echo "Registration failed";
				mysqli_close($con);
			}
		}
		else{
			echo 'database insertion problem';
		}
	}
?>
