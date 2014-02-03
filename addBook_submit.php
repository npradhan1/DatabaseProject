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


	 $title = $_POST['title'];
	 $author = $_POST['author'];
	 $subject = $_POST['subject'];
	 $isbn = $_POST['isbn'];
	 $quantity = $_POST['quantity'];

     $query = "insert into books(title, author, isbn, quantity, subject) VALUES ('$title', '$author', '$isbn','$quantity','$subject')";
	  
	  

	 echo 'query'.$query.'<br><br>';
	  
	 
    $result = mysqli_query($con, $query);

	if($result){
		mysqli_query('commit');
		header('Location: index.php'); 	
	}else{
		echo 'book cannot be added';
		die('Could not insert into database');
		mysqli_close($con);
	}

?>
