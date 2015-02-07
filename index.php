<?php 
       session_start();
 ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-voting System Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    
    <!-- All CSS Files -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css"/>
    <link rel="stylesheet" type="text/css" href="css/fontello.css"/>
    <link rel="stylesheet" type="text/css" href="css/isotope.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link href='http://fonts.googleapis.com/css?family=Alef:400,700' rel='stylesheet' type='text/css'>

</head>
<body>
    
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#section1">Online Bidding</a>
                <ul class="nav">
                    <li><a href="#section1">Home</a></li>
                    <li><a href="#section2">Login</a></li>
                    <li><a href="#section3">Register</a></li>
                    <li><a href="#section4">AboutUs</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Section 1 -->
    
    <div class="section1" id="section1">
        <div class="container">
            <div class="row">
                <div class="span8">
                    <div class="intro">
                        <h1>Online Bidding</h1>
                        <h2>This is the official website of IIT Patna Online bidding</h2>
                       
                         
                    </div>
                </div>
                
               
            </div>
        </div>
    </div>
    <!--php for login -->
    
    <!-- Section 2 -->
    <div class="section2-start"></div>
    
    <div class="section2" id="section2">
        <div class="container">
            <div class="row">
                <div class="span12">
				<hr/>
                    <h1>Login</h1>
					<hr/>
                    <!--PHP for login-->
                    
                    
                    <?php

$connection=mysql_connect("localhost","root","") or die("could not connect to server "); //connecting to server
mysql_select_db("bidding",$connection) or die("could not connect to database"); 		//database name is bidding


error_reporting(0);																		//just a fancy term to ignore error

if($_POST['login'])																//$_POST is a variable
{
	if($_POST['username'] && $_POST['password'])					// in this database we have entries for username & password
	{
		$username=mysql_real_escape_string($_POST['username']); 				//assignment username to $ username
		$password=mysql_real_escape_string(hash("md5", $_POST['password'])); 
		$user=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `Username`='$username' "));		//sql query assignedd to $user
		if($user == '0')
		{
			die("the UserName does not exit ");
		}
		if($user['Password'] != $password)												//checking password
		{
			die("the password is not correct ");
		}
       
   $user1=mysql_fetch_array(mysql_query("SELECT ID FROM `users` WHERE `Username`='$username' AND `password`='$password' "));

        $_SESSION['user_id']=$user1['ID'];
      

		$salt=hash("md5", rand().rand().rand());					//$salt is used for encryption of password
		setcookie("c_user",hash("md5", $username),time()+24*60*60,"/");			//expire this cookie after 24 hours
		setcookie("c_salt",$salt,time()+24*60*60,"/");
		$userID=$user['ID'];										//assigning ID to userID
		mysql_query("UPDATE `users` SET `salt`='$salt'  WHERE `ID`='$userID'");	//query
		
           
                header("Location: afterlogin.php");		//redirecting to next page //can be html or php
           
           

        //die("you r loged in as $username :  <a href ='logout.php'>cllick here to logout</a>");
		
	}
}


include "algor.php";      //algor.php checks for logged in user
if($logged==true)
{
	die("u r already logged in :: <a href ='logout.php'>cllick here to logout</a> ");
	
}
    
    
    
echo "
    
                    
                    
                    <!---->
					<form action='' method='post'>
                        <table width='35%' height='50%' bgcolor='#33CC33' align='center'>
                            <tr>  
                            <br/>      
                                <td colspan=3 ><font size=3><center><b>LOGIN </b><br/></center>        
                            </tr>

                            <tr>
                                <td width='30%'  >  <span style='padding-left:45px'> UserName    :</span> <br/></td>

                                <td><input type='text' name='username' size=25 maxlength=20 ></td>
                            </tr>

                            <tr>
                                <td width='30%'> <span style='padding-left:45px'> Password    :</span><br/></td>
                                <td><input type='password'  name='password'size=25 maxlength=20></td>
                            </tr>


                            <tr>
                                <td ><span style='padding-left:120px'><input type='submit'  style='background-color:#009900; color: #00FFFF; font-size: 120%;' value='Login' name='login'> </span> </td>
                            </tr>


                           <tr>
                           
                            </tr>



                        </table>
                        </form>

";
?>
				   
                </div>
                
                
            </div>
        </div>
    </div>
    
    
    
    
  
    <!-- Section 3 -->
    
    <div class="section3-start"></div>
    
    <div class="section3" id="section3">
        <div class="container">
            <div class="row">
                <div class="span12">
                    
                      <!--php  for register-->
    
    
    <?php

$connection=mysql_connect("localhost","root","") or die("could not connect to server ");
mysql_select_db("bidding",$connection) or die("could not connect to database");


error_reporting(0);

if($_POST['register'])
{
	if($_POST['username'] && $_POST['password'])
	{
		$username=mysql_real_escape_string($_POST['username']); 
		$password=mysql_real_escape_string(hash("md5",$_POST['password'])); 
		$name='';
		if($_POST['name'])
		{
			$name=mysql_real_escape_string(strip_tags($_POST['name'])); 
		}
		$check=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `Username`='$username'"));
		if($check!='0')
		{
			die(" username already exits ");

		}
		if(strlen($username)>20)
		{
			die("username must not contain more then 20 char" );
		}

      
		  $salt=hash("md5", rand().rand().rand());
		mysql_query("INSERT INTO `users` (`Username` , `Password` , `Name` ,  `Salt`,`Balance`) VALUES ('$username' , '$password' , '$name' , '$salt','1000')   ");
    
		setcookie("c_user",hash("md5", $username),time()+24*60*60,"/");
		setcookie("c_salt",$salt,time()+24*60*60,"/");
		  
           header("Location: afterlogin.php");		//redirecting to next page //can be html or php


	}
}

echo"
                    
                    <!---->
					<form action='' method='post'>
<table width='35%' height='50%' bgcolor='#33CC33' align='center'>

    <tr>  
    <br/>      
        <td colspan=3 ><font size=3><center><b>    REGISTER  </b><br/></center>        
    </tr>
           
    <tr>
        <td width='30%'  >  <span style='padding-left:45px'> UserName    :</span> <br/></td>
       
        <td><input type='text' name='username' size=25 maxlength=20 ></td>
    </tr>

    <tr>
        <td width='30%'> <span style='padding-left:45px'> Password    :</span><br/></td>
        <td><input type='password'  name='password'size=25 maxlength=20></td>
    </tr>
    
    
     <tr>
        <td width='30%'  >  <span style='padding-left:45px'> Name    :</span> <br/></td>
       
        <td><input type='text' name='name' size=25 maxlength=20 ></td>
    </tr>



    <tr>
        <td ><span style='padding-left:120px'><input type='submit'  style='background-color:#009900; color: #00FFFF; font-size: 120%;' value='Register' name='register'> </span> </td>
    </tr>


   <tr>
		
    </tr>


     
</table>
</form>
";
?>
                </div>
            </div>
                
        
           
                    
                </div>
            </div>
       



    <!-- Section 4 -->
    
    <div class="section4-start"></div>
    
    <div class="section4" id="section4">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <h1>Get In Touch</h1> <hr/>
                </div>
            </div>
            
            <div class="row">
                <div class="span4">
                    <p>Enough about me lets hear about you. I am currently available for projects.</p>
                    
                    <p><span>Email: </span> hello@yourdomain.com</p>
                    <p><span>Phone: </span> (0121) 444 4444</p>
                    
                    <div class="social">
                        <a target="_blank" href="https://twitter.com/CreativityTuts"><i class="icon-twitter-circled"></i></a>
                        <a href="#"><i class="icon-gplus-circled"></i></a>
                        <a href="#"><i class="icon-facebook-circled"></i></a>
                        <a href="#"><i class="icon-github-circled"></i></a>
                    </div>
                </div>
                
                <div class="span6 offset1">
                    <form>
                        <label>Name</label>
                        <input type="text" class="span5" />
                        
                        <label>Email</label>
                        <input type="text" class="span5" />
                        
                        <label>Phone</label>
                        <input type="text" class="span5" />
                        
                        <label>Message</label>
                        <textarea class="span5" rows="4" type="text"></textarea>
                        
                        <button type="submit" class="btn-default">Send Message <i class="icon-right-circled"></i></button>

                    </form>
                </div>
            </div>
            
            
        </div>
    </div>
    
    
    
    <!-- All JavaScript Files -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/isotope.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.scrollTo.js"></script>
    <script src="js/jquery.nav.js"></script>
    <script src="js/jquery.knob.js"></script>
    <script src="js/custom.js"></script>
    
</body>
</html>


