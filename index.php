<?php
  require_once('startsession.php');     // Start the session
  $page_title = 'Welcome...!'; 	
  require_once('header.php');   // Insert the page header
  require_once('appvars.php');
  require_once('connectvars.php');
   
   ?>

<div id="innerpage">
  <div id="top_head">
    <?php 		  	require_once('navmenu.php');  // Show the navigation menu 		?>
  </div>
  <hr />
  <?php
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);   // Connect to the database 

  // Retrieve the user data from MySQL
  $query = "SELECT * FROM contactinfo WHERE username IS NOT NULL ORDER BY join_date DESC";
  $data = mysqli_query($dbc, $query);
  ?>
  <div id="user_info">
    <div id="left_content">
      <h3>Login Script With Database ... now enjoy </h3>
      <br /> 
      <img src="upload/template_page1.jpg" alt="" width="150" height="180" style=" margin-left: 10px;margin-right: 10px;" /> <img src="upload/template_page2.jpg" alt="" width="150" height="180" style="margin-right: 10px;" /> <img src="upload/template_page3.jpg" alt="" width="150" height="180" style="margin-right: 10px;" /><br />

	 <?php   
  if (!isset($_SESSION['user_id'])) {
  	echo "<p>Please signup if you would like to check this login script</p>";
	echo "<br/><p>and you can download this login script once you login with your login details and check it yourself in your localhost or your website</p>";
  } else {
  echo "thanks for register your account <br/>";
  echo "<a href='login_script_2.zip' title=''>download PHP Login Script </a>";
  echo "<br/><br/>mail me with your username here (anand.8487@gmail.com) if you want to delete your account from this website";
  }
  ?>
	   </div>
    <script type="text/javascript">
	$(document).ready(function() { 
		 $("#mycustomscroll").css("float","right");
		 $("#mycustomscroll").css("border","1px solid #ccc");
		 $("#mycustomscroll").css("borderRight","none"); 
		 $("#mycustomscroll .mcontentwrapper").css("top","0px");
	 });
</script><br />

    <div id='mycustomscroll' class='flexcroll'>
      <?php
  // Loop through the array of user data, formatting it as HTML
  echo '<table id="thumbdisp"><tbody>';
  while ($row = mysqli_fetch_array($data)) {
  
  // if user logged  
  if (isset($_SESSION['user_id'])) 
  { 
  	     if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) 
		{
      		echo '<tr><td><a href="viewprofile.php?user_id=' . $row['user_id'] . '" title="'.$row['first_name'].'"><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '"   height="75" /></a></td>';
    	}      
		else 
		{
			if($row['gender'] == 'M') 
			{
				echo '<tr><td><a href="viewprofile.php?user_id=' . $row['user_id'] . '" title="'.$row['first_name'].'"><img class="profile" src="images/profile-image.jpg" alt="' . $row['first_name'] . '" height="75" /></a></td>';
			} 
			else 
			{
 				if($row['gender'] == 'F') 
				{
		  			echo '<tr><td><a href="viewprofile.php?user_id=' . $row['user_id'] . '" title="'.$row['first_name'].'"><img class="profile" src="images/female-picture.jpg" alt="' . $row['first_name'] . '" height="75" /></a></td>';
			  	} 
				else 
				{
			  		echo '<tr><td><a href="viewprofile.php?user_id=' . $row['user_id'] . '" title="'.$row['first_name'].'"><img class="profile" src="images/nopic.jpg" alt="' . $row['username'] . '" height="75" /></a></td>';
				}
			} //end of checking gender
		}  //end of confirm file from database
		
  }
  else {
  
  	     if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) 
		{
      		echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '"  height="75" />';
    	}      
		else 
		{
			if($row['gender'] == 'M') 
			{
				echo '<tr><td><img class="profile" src="images/profile-image.jpg" alt="' . $row['first_name'] . '"  height="75" />';
			} 
			else 
			{
 				if($row['gender'] == 'F') 
				{
		  			echo '<tr><td><img class="profile" src="images/female-picture.jpg" alt="' . $row['first_name'] . '" height="75" />';
			  	} 
				else 
				{
			  		echo '<tr><td><img class="profile" src="images/nopic.jpg" alt="' . $row['username'] . '"  height="75" />';
				}
			} //end of checking gender
		}  //end of confirm file from database
		
		
		}

  if (isset($_SESSION['user_id'])) 
  {
	if(!empty($row['first_name']) || !empty($row['last_name'])) 
	{
    	echo '<td><a href="viewprofile.php?user_id=' . $row['user_id'] .'" title="'.$row['first_name'].'">' . $row['first_name'] . '</a></td></tr>';
	} 
	else 
	{
		echo '<td><a href="viewprofile.php?user_id=' . $row['user_id'] . '" title="'.$row['username'].'">' . $row['username'] . '</a></td></tr>'; 		
	}     
   }    
  else 
  {
	if(!empty($row['first_name']) || !empty($row['last_name'])) 
	{
    	echo '' . $row['first_name'] .'</td></tr>';
	} 
	else 
	{
		echo '' . $row['username'] . '</td></tr>';
	}       
  } // end of issest user_id   
	  
 }
  echo '</tbody></table>';

  mysqli_close($dbc);
?>
    </div>
  </div>
  <?php
  // Insert the page footer
  require_once('footer.php'); 
	  
?>
