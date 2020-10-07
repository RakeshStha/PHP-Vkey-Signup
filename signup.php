<?php
session_start();
ob_start();
 $error = NULL;
 

if(isset($_POST['submit'])){
  //Get fro m data
  $u = $_POST['u'];
  $p = $_POST['p'];
  $p2 = $_POST['p2'];
  $e = $_POST['e'];
  if(strlen($u) < 6) {
    $error = "<p>Your username must be at least 6 character</p>";
  }elseif($p2 != $p){
    $error .= "<p>Your passwords do not match.</p>";
  }else{
    //Form is valid
    //Connect to the database
    $mysqli=mysqli_connect('localhost','user','password',"dbname");
     
    #if(!$mysqli){
    #  echo "error connecting to server";
    #}
    #else{
    #  echo "Connected to server";
    #}
    #if(!$dbname)
    #{
    #  echo"error connecting to databse";
    #}
    #else{
    #  echo" Database connected";
    #}
    //end

    //Sanitize form data
    $u =  $mysqli->real_escape_string($u);
    $p =  $mysqli->real_escape_string($p);
    $p2 = $mysqli->real_escape_string($p2);
    $e =  $mysqli->real_escape_string($e);

    //Generate Vkey
    $vkey = md5(time().$u);

    //Insert account into the database
    $p = md5($p);

    $insert ="INSERT INTO accounts(username, password,email,vkey) VALUES ('$u', '$p', '$e', '$vkey')";
if(mysqli_query($mysqli,$insert)){
  //Send Email
  $to = $e;
  $subject = "Email Verification";
  #$headers = 'From : unknownbeginner322@gmail.com'. "\r\n".
  #'Reply-To: unknownbeginner322@gmail.com' . "\r\n".
  #'MIME-Version: 1.0' . "\r\n".
  #'Content-type:text/html;charset=UTF-8' . "\r\n";

  $message = "<html>
  <head>
  <title>Please Verify</title>
  </head>
  <body>
  <a href='http://testrakesh.000webhostapp.com/verify.php?vkey=$vkey'>Register Account</a>
  </body>
  </html>";
  #$headers = "From : unknownbeginner322@gmail.com". "\r\n";
  #$headers .= "MIME-Version: 1.0" . "\r\n";
  #$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


mail($to,$subject,$message,'From: local');
            echo "<script>alert('Thank you! We have send link for verification on you email.')</script>";


    }else{
      echo $mysqli->error;
    }
    }
  }


?>


<html>
<head>
	<title>My ChatApp-Signup</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
	    	body{
  background-image:url(https://www.ecopetit.cat/wpic/mpic/18-187310_sky-blue-colour-background-hd.jpg);
  background-size: 100%;

}
#a {
  width: 500px;
  height: 100%;
  overflow: hidden;
  border: 1px solid lightblue;
  margin: auto;
  padding: 40px;
}

.b {
  width: 250px;
  height: 40%;
  margin: 10px auto;
  background-color: #fff;
  border: 2px solid #e6e6e6;
  padding: 40px 50px;
}

.e,
{
  width: 100%;
  margin-bottom: 5px;
  padding: 8px 12px;
  border: 1px solid #dbdbdb;
  box-sizing: border-box;
  border-radius: 3px;
}

.c{
  width: 49.5%;
  margin-bottom: 5px;
  padding: 8px 12px;
  border: 1px solid #dbdbdb;
  box-sizing: border-box;
  border-radius: 3px;
}
	    </style>

</head>
<body>
<form action="" method="POST">

<div id="a">
<div id="b">
  <h1> Welcome to Registration form</h1>
<pre>
 <label>First Name       : <input type="text" name="u" placeholder="First name" class="c" required>
 </label>
 <label>Email            : <input type="email" name="e" placeholder="Mobile number or email address" class="c"  required>
 </label>
 <label>Create Password : <input type="password" name="p" placeholder="******"  class="c" required>
 </label>
 <label>Confirm Password : <input type="password" name="p2" placeholder="******"  class="c" required>
 </label>
</pre>
 <label>
   <h6>By clicking Submit, you agree to our Terms of Service, Data Policy and Cookies Policy. You may receive SMS Notifications from us and can opt out any time.Others will be able to find you by email or phone number when provided.Thank you!</h6>
 </label>
 <pre>
            <button onclick="window.location.href = 'index.php';">Cancel</button>                 <input type="submit" name="submit" value="Submit">

</pre>
</div>
</div>
 </form>
 <center>
     <?php
     echo"$error";
     ?>
 </center>

<div class="footer">
  <h2 align="center"> &copy; My ChatApp | Developed by <a href="https://www.shrestharakesh.com.np/">Rakesh Shrestha</a></h2>
</div>
 </div>
 </body>
 </html>
