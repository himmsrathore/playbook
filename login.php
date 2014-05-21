<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username FROM contactinfo WHERE username = '$user_username' AND password = '$user_password'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
         $_SESSION['user_id'] = $row['user_id'];
         $_SESSION['username'] = $row['username'];
          setcookie('user_id', $row['user_id'], time() + 60);    // expires in 30 days
          setcookie('username', $row['username'], time() + 60);  // expires in 30 days 
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
		 
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }

  // Insert the page header
  $page_title = 'Log In';
  require_once('header.php');

  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
?><center>
 <div id="box_title"><img src="images/login_title.png" alt="" /></div>
     <div id="form_box">
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="username" class="labelleft">Username:</label>
      <input id="username" type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" class="box" /><br />

      <label for="password" class="labelleft">Password:</label>
      <input type="password" name="password" id="password" class="box" /><br />
 
 <input type="submit" value="" name="submit" class="submit login" /> 
  <p class="error"><?php echo $error_msg; ?></p>
  </form> 
    </div>
    <div id="box_btm"></div>
<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
	echo "<a href='index.php'>Goto home</a>";
  }
?><br />
<a href="index.php" title="">Home</a>
 	 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
 <a href="signup.php" title="Create an Account">Create Account</a> 

</center>
<?php 
echo $_SERVER['HTTP_HOST'];          //localhost
 echo dirname($_SERVER['PHP_SELF']); // folder name
echo $_SERVER['REMOTE_ADDR'];    // login script2
?>

</body>
</html>