<?php
  require_once('startsession.php');  // Start the session
  
  $page_title = 'Edit Profile';  // Insert the page header
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
  <?php require_once('navmenu.php');  // Show the navigation menu ?>
</div>
<div id="user_info">
  <?php
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);  // Connect to the database

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
    $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$occupation = mysqli_real_escape_string($dbc, trim($_POST['occupation']));
	$company = mysqli_real_escape_string($dbc, trim($_POST['company']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size']; 
	$_SESSION['firstname'] = $_POST['firstname'];
	$_SESSION['lastname'] = $_POST['lastname'];
//    list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE)) {
        if ($_FILES['file']['error'] == 0) {
          // Move the file to the target upload folder
          $target = MM_UPLOADPATH . basename($new_picture);
          if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(MM_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
          }
        }
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['new_picture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
          ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    }

    // Update the profile data in the database
    if (!$error) {
      if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($email) && !empty($occupation)) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
          $query = "UPDATE contactinfo SET ipadd = '$ip', first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', occupation = '$occupation', company = '$company', email = '$email', picture = '$new_picture' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        else {
          $query = "UPDATE contactinfo SET ipadd = '$ip', first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', occupation = '$occupation', company = '$company', email = '$email' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';
        mysqli_close($dbc);
        exit();
      }
      else {
		   $query = "UPDATE contactinfo SET ipadd = '$ip', first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', occupation = '$occupation', company = '$company',  email = '$email' WHERE user_id = '" . $_SESSION['user_id'] . "'";       
			mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';
        mysqli_close($dbc);
        exit();
      
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT first_name, last_name, gender, birthdate, city, occupation, company, email, picture FROM contactinfo WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $gender = $row['gender'];
      $birthdate = $row['birthdate'];
      $city = $row['city'];
      $email = $row['email'];
	  $occupation = $row['occupation'];
	  $company = $row['company'];
      $old_picture = $row['picture'];
    }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
  }

  mysqli_close($dbc);
?>
  <div id="profile_photo">
    <?php if (!empty($old_picture)) {
        echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" width="120"  />';
      } else {
		  if($gender == 'M') {
		  echo '<img class="profile" src="images/profile-image.jpg" width="120" />';
		  } else {
			  if($gender == 'F') {
				  echo '<img class="profile" src="images/female-picture.jpg" width="120" />';
			  } else {
			  echo '<img class="profile" src="images/nopic.jpg" width="120" />';
			  }
		  }
	  }
		  ?>
  </div>
  <div id="userstitle">
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
      <div style="width: 100px; display: block; float: left;">
        <label for="firstname">First name:</label>
        <label for="lastname">Last name:</label>
        <label for="gender">Gender:</label>
        <label for="birthdate">Birthdate:</label>
        <label for="email">Email:</label>
		<label for="occupation">Occupation</label>
		<label for="company">Company</label>
        <label for="city">City:</label>
        <label for="new_picture" style="margin-top: 6px;">Picture:</label>
      </div>
      <div style="width: 205px; display: block; float: left;">
        <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" />
        <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
        <select id="gender" name="gender" class="gender">
          <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
          <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
        </select>
        <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" />   <span style="font-size: 12px; margin-left: 5px; float: right;"> (yyyy-mm-dd)</span>
        <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" />
		<input type="text" id="occupation" name="occupation" value="<?php if(!empty($occupation)) echo $occupation; ?>" />
		<input type="text" id="company" name="company" value="<?php if(!empty($company)) echo $company; ?>" />
        <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" />
        <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
        <div class="browse">
          <input type="file" id="new_picture" name="new_picture" class="input_browse" size="1" />
        </div>
        <br />
        <br />
      </div>
      <input type="submit" value="" name="submit" class="save" />
    </form>
  </div>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
