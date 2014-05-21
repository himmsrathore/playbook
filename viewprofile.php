<?php
  require_once('startsession.php');  // Start the session
 
  $page_title = 'View Profile';  // Insert the page header
  require_once('header.php');
  require_once('appvars.php');
  require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  ?>
<div id="innerpage">
    <div id="top_head">
		<?php   require_once('navmenu.php');  // Show the navigation menu?>
</div>
  <div id="user_info">
<?php
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);  // Connect to the database

  // Grab the profile data from the database
  if (!isset($_GET['user_id'])) {
    $query = "SELECT username, first_name, last_name, gender, birthdate, city, occupation, company, email, picture FROM contactinfo WHERE user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT * FROM contactinfo WHERE user_id = '" . $_GET['user_id'] . "'";
  }
  $data = mysqli_query($dbc, $query); 

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
	  ?>
	<div id="profile_photo">
      <?php 
	  if (!empty($row['picture'])) {
        echo '<img class="profile"  src="' . MM_UPLOADPATH . $row['picture'] .'" alt="Profile Picture" width="120"  />';
	//	<img src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" width="120" height="120" />
      }
	  else { 
	  if ($row['gender'] == 'M') {
		  echo '<img class="profile" src="images/profile-image.jpg" width="120" />';
      }
      else if ($row['gender'] == 'F') {
				  echo '<img class="profile" src="images/female-picture.jpg" width="120" />';
      }
      else {
			  echo '<img class="profile" src="images/nopic.jpg" width="120" />';
      }   }
	  ?>
      </div>
       <?php
    echo '<table id="userstitle">';

    if (!empty($row['first_name'])) {
      echo '<tr><td class="label">First name:</td><td class="label1">' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
      echo '<tr><td class="label">Last name:</td><td class="label1">' . $row['last_name'] . '</td></tr>';
    }
	    if (!empty($row['username'])) {
      echo '<tr><td class="label">Username:</td><td class="label1">' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
      echo '<tr><td class="label">Gender:</td><td class="label1">';
      if ($row['gender'] == 'M') {
        echo 'Male';
      }
      else if ($row['gender'] == 'F') {
        echo 'Female';
      }
      else {
        echo '?';
      }
      echo '</td></tr>';
    }
	
    if (!empty($row['birthdate'])) {
      if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
        // Show the user their own birthdate
        echo '<tr><td class="label">Birthdate:</td><td class="label1">' . $row['birthdate'] . '</td></tr>';
      }
      else {
        // Show only the birth year for everyone else
        list($year, $month, $day) = explode('-', $row['birthdate']);
        echo '<tr><td class="label">Year born:</td><td class="label1">' . $year . '</td></tr>';
      }
    }
	
	 if (!empty($row['email'])) {
      echo '<tr><td class="label">Email:</td><td class="label1">' . $row['email'] . '</td></tr>';
    }
	
	if(!empty($row['occupation'])) {
		echo '<tr><td class="label">Occupation:</td><td class="label1">'. $row['occupation'] . '</td></tr>';
	}
	
	
	if(!empty($row['company'])) {
		echo '<tr><td class="label">Company:</td><td class="label1">'. $row['company'] . '</td></tr>';
	}
	
if (!empty($row['city']) || !empty($row['email'])) {
      echo '<tr><td class="label">Location:</td><td class="label1">' . $row['city'] . '</td></tr>';
    }
 
    echo '</table>';

  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
      echo '<p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>';
    }
 ?>
</div>
<script type="text/javascript">
var scriptname = GetUrlScriptname();
         $(' a[href$="' + scriptname + '"]').parent().addClass('selected'); 
        function GetUrlScriptname()
    {
      var rex = new RegExp("\\/[^\\/]+\\.\\w+($|\\?)");
      var match = rex.exec(location.pathname);
      return match[0].substring(1);
    }  
</script>
<div style="border: 1px solid #ccc; width: auto; height: 50px; display: block;">
<?php 
 
$referer = $_SERVER['HTTP_REFERER'];
 $url = $_SERVER['REQUEST_URI'];
echo $referer . "<br />" .  $url;

?><br />
<br />
	 
</div> 
<?php
  mysqli_close($dbc);
  // Insert the page footer
  require_once('footer.php');
  
?>