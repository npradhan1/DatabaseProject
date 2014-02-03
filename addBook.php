<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<head>
	<title>Add Book Form</title>
	<link rel="stylesheet" type="text/css" href="./select/select2.css">
	<link rel="stylesheet" href="http://bootswatch.com/slate/bootstrap.css" media="screen">
	<link rel="stylesheet" href="http://bootswatch.com/assets/css/bootswatch.min.css">

	
	
	<link rel="shortcut icon" href="./Bootswatch_Slate_files/favicon.png">
	<script type="text/javascript" src="./Bootswatch_Slate_files/addBookValidation.js"></script>
	<style>


	</style>
</head>

<body onLoad="document.registration.userid.focus();">
	<h1 style="padding-left:15px;">Add Book Form</h1>
	<p style="padding-left:15px;">Use tab keys to move from one input field to the next.</p>
	<form name='addBook' onSubmit="return formValidation();" class="form-horizontal" style="width:50%;margin-left:50px;" action="addBook_submit.php" method="post">
		<legend>Enter Book Information</legend>
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Enter book name" size="20">
		</div>
		<div class="form-group">
			<label for="author">Author</label>
			<input type="text" class="form-control" id="author" name="author" placeholder="Enter author name">
		</div>
		<div class="form-group">
			<label for="isbn">ISBN</label>
			<input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN">
		</div>
		<div class="form-group">
			<label for="quantity">Quantity</label>
			<input type="quantity" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity">
		</div>
		<div class="form-group">
			<label for="subject">Subject</label>
			<br/>
			<select name="subject" class="dropdown" id="subject">
				<option value="TextBooks">TextBooks</option>
				<option value="Historical">Historical</option>
				<option value="Biography">Biography</option>
				<option value="Fantasy">Fantasy</option>
				<option value="Fiction">Fiction</option>
				<option value="Romance">Romance</option>
				<option value="Sports">Sports</option>
				<option value="Cooking">Cooking</option>
			</select>
		</div>
		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
	</form>
</body>
</html>