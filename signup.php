<?php
  $page_title = 'Sign Up';
  require_once('header.php');  // Insert the page header

  require_once('appvars.php');
  require_once('connectvars.php');
  
  
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
    //****************************************IMPORTANT **************************************************************
	  // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM contactinfo WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO contactinfo (username, password, join_date, ipadd) VALUES ('$username', '$password1', NOW(), '$ip')";
        mysqli_query($dbc, $query);
		//*********************************************************************************************************************************
        // Confirm success with the user
		echo "<script type='text/javascript'>alert('Signup Successful and please login');</script>";
	 echo "<meta http-equiv='refresh' content='0; url=index.php' />";
        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        $error = "An account already exists for this username. Please use a different address.";
        $username = "";
      }
    }
    else {
      $error = "You must enter all of the sign-up data, including the desired password twice.";
    }
  }
  mysqli_close($dbc);
?>
<center>
  <div id="box_title"><img src="images/signup_title.png" alt="" /></div>
    <div id="form_box">
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" class="box" /><br />

      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" class="box" /><br />

      <label for="password2">Confirm Password:</label>
      <input type="password" id="password2" name="password2" class="box" /><br /><br />


    <input type="submit" value="" name="submit" class="create_acc" />
  </form> 

<p class="error"><?php echo $error; ?></p>
</div>
  <div id="box_btm"></div>
<br />
<br /> 
<a href="index.php" title="">Home</a> &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; 
        <a href="login.php" title="Login into your Account">Login</a>
</center>
</body>
</html>