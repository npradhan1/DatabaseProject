<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<head>
	<title>Registration Form</title>
	<link rel="stylesheet" type="text/css" href="./select/select2.css">
	<link rel="stylesheet" href="http://bootswatch.com/slate/bootstrap.css" media="screen">
	<link rel="stylesheet" href="http://bootswatch.com/assets/css/bootswatch.min.css">

	
	
	<link rel="shortcut icon" href="./Bootswatch_Slate_files/favicon.png">
	<script type="text/javascript" src="./Bootswatch_Slate_files/registrationFormValidation.js"></script>
	<style>


	</style>
</head>

<body onLoad="document.registration.userid.focus();">
	<h1 style="padding-left:15px;">Registration Form</h1>
	<p style="padding-left:15px;">Use tab keys to move from one input field to the next.</p>
	<form name='registration' onSubmit="return formValidation();" class="form-horizontal" style="width:50%;margin-left:50px;" action="reg_submit.php" method="post">
		<legend>Personal Information</legend>
		<div class="form-group">
			<label for="firstName">First name</label>
			<input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First name" size="20">
		</div>
		<div class="form-group">
			<label for="lastName">Last name</label>
			<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last name">
		</div>
		<div class="form-group">
			<label for="email">Email (will be used as Login ID)</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
		</div>
		<div class="form-group">
			<label for="dob">Date of Birth</label>
			<input type="text" class="form-control" id="dob" name="dob" placeholder="Enter date of birth mm/dd/yyyy">
		</div>
		<legend>Address</legend>
		<div class="form-group">
			<label for="line1">Line 1</label>
			<input type="text" class="form-control" id="line1" name="line1" placeholder="Enter line 1">
			<label for="line2">Line 2</label>
			<input type="text" class="form-control" id="line2" name="line2" placeholder="Enter line 2">
			<label for="line3">Line 3</label>
			<input type="text" class="form-control" id="line3" name="line3" placeholder="Enter line 3">
		</div>
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
		</div>
		<div class="form-group">
			<label for="state">State</label>
			<br/>
			<select name="state" class="dropdown">
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>	
		</div>
		<div class="form-group">
			<label for="zip">ZIP</label>
			<input type="text" class="form-control" id="zip" name="zip" placeholder="Enter ZIP">
		</div>

		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
	</form>
</body>
</html>