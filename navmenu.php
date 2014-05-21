
<?php
  // Generate the navigation menu
  if (isset($_SESSION['username'])) {
	  ?>
       <h4>         <strong>Welcome,</strong> 
<?php 		

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

$query = "select * from contactinfo WHERE user_id = '" . $_SESSION['user_id'] . "'";
 $data = mysqli_query($dbc, $query); 
$row = mysqli_fetch_array($data);

if(!empty($row['first_name']) || !empty($row['last_name'])) {
	echo $row['first_name'] . ' ' . $row['last_name'];
} else {
	echo $_SESSION['username'];	
}			?>        <strong>!</strong>         </h4>
        <?php
    echo '<a href="logout.php" title="Log Out" class="user_details"> Log Out</a>';   
    echo '<a href="viewprofile.php" title="View Profile" class="user_details"> View Profile</a> ';
    echo '<a href="editprofile.php" title="Edit Profile" class="user_details"> Edit Profile</a> ';
 echo '<a href="index.php" title="Home page" class="user_details"> Home</a> ';
  }
  else {
	  	  ?>
       <h4>
        <strong>Welcome,</strong> Guest<strong>!</strong>
        </h4>
        <?php
    echo '<a href="login.php" title="Log In" class="user_details">Log In</a> ';
    echo '<a href="signup.php" title="Sign Up" class="user_details">Sign Up</a>';
  }

?>
