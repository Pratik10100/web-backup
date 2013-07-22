<?php
#########################
#   			#
#     Anantha Natarajan.S	#
#           112112008		#
#           sananth12	   	#
#	 Task 3	 	#
#			#
#########################

if (isset($_POST['submit']))
{
  
  ## Please change "root" to your username and "" to password ##
  
  $conid=mysql_connect("localhost","root","");
  

$flag=0;
$name=$_REQUEST["name"];
$dob=$_REQUEST["txtDate"];
$dept=$_REQUEST["dept"];
$school=$_REQUEST["school"];
$roll=$_REQUEST["rollnumber"];
$add=$_REQUEST["address"];
$rep_pass=$_REQUEST["rep_pass"];
$password=$_REQUEST["password"];
$hash=crypt($password);
$gender=$_REQUEST["gender"];
$email=$_REQUEST["email"];
$photo=addslashes(file_get_contents($_FILES["file"]["tmp_name"]));

## Image validation ##
if(is_uploaded_file($_FILES["file"]["tmp_name"]) )
    {
    
	$size= $_FILES["file"]["size"];
	$type=$_FILES["file"]["type"];
    if($size>1000000)
		 {echo "<p><text style=\"color:red\" >Error:</text> File size must be less than 1MB</p>";$flag++;}
	if($type!= "image/jpeg" && $type!= "image/png")
		{echo "<p><text style=\"color:red\" >Error:</text>Only jgeg/png image types are allowed </p><br />";
		 $flag=1;
		}
	}

## Validations done server-side ##
if($name=="")
{echo "<p><text style=\"color:red\" >Error:</text> Name field must not be left empty </p><br>";$flag++;}
if($name!="")
{
   if($name[0]!=strtoupper($name[0]))
   {echo "<p><text style=\"color:red\" >Error:</text> The first letter of the name must be in upper case</p><br>";$flag++;}
}

if($dob =="")
{echo "<p><text style=\"color:red\" >Error:</text> Date of Birth field must not be left empty </p><br>";$flag++;}
if($dob!="")
{
  if(strlen($dob)!=10)
  {echo "<p><text style=\"color:red\" >Error:</text> Invalid date format (must be dd/mm/yyyy) </p><br>";$flag++;}
  else
  {
   $d=$dob[0].$dob[1];
   $d=(int)$d;
   $m=$dob[3].$dob[4];
   $m=(int)$m;
   $y=$dob[6].$dob[7].$dob[8].$dob[9];
   $y=(int)$y;
   if(!checkdate($m, $d, $y) || $dob[5]!="/" || $dob[2]!="/")
    {echo "<p><text style=\"color:red\" >Error:</text> Invalid date</p><br>";$flag++;}
  }

}

if($roll =="")
{echo "<p><text style=\"color:red\" >Error:</text> Roll number field must not be left empty </p><br>";$flag++;}

if($roll!="")
{
   if(strlen($roll)!=10)
   { echo "<p><text style=\"color:red\" >Error:</text> Roll number must contain 10-digits</p><br>";$flag++;}
}

if(sizeof($_REQUEST["club"])<3)
{
echo "<p><text style=\"color:red\" >Error:</text> At least 3 clubs must be selected</p><br>";$flag++;
}
if($school =="")
{echo "<p><text style=\"color:red\" >Error:</text> School field must not be left empty </p><br>";$flag++;}
if($school=="Others")
{
 $school=$_REQUEST["other_school"];
}
if($email =="")
{echo "<p><text style=\"color:red\" >Error:</text> E-mail field must not be left empty </p><br>";$flag++;}
if($email!="")
{
   if (!filter_var($email, FILTER_VALIDATE_EMAIL))
   {
    echo "<p><text style=\"color:red\" >Error:</text> E-mail id invalid </p><br>";$flag++;
   }
   if(strpos($email,"spambot.org") || strpos($email,"mailinator.com"))
   {
    echo "<p><text style=\"color:red\" >Error:</text> E-mail id is Blacklisted ! </p><br>";$flag++;
   } 
}


if($password =="")
{echo "<p><text style=\"color:red\" >Error:</text>  Password field must not be left empty </p><br>";$flag++;}
if($password!="")
{ 
  if(strlen($password)<5 || strlen($password)>10)
  {echo "<p><text style=\"color:red\" >Error:</text> Password must contain 5-10 characters </p><br>";$flag++;}
 
  if(preg_match('/\W/',$password))
  {
  
   echo "<p><text style=\"color:red\" >Error:</text> Password must contain a-z, A-Z ,0-9, _ characters only</p><br>";$flag++;
  }
}
if($rep_pass =="")
{echo "<p><text style=\"color:red\" >Error:</text> Repeat password field must not be left empty </p><br>";$flag++;}


## Create a db my_db if it doesnt exist 
if (mysql_query("CREATE DATABASE my_db",$conid))
  {
  echo "<p>Database created</p><br />";
  }
## if any validation failed, flag>0 ,hence no values added to db.
if($flag==0)
  {
    mysql_select_db("my_db", $conid);
	
	mysql_query($sql,$conid);
   	
	mysql_query("INSERT INTO Register (Name,Dob, Dept, Roll,email,Password,Gender,School,Address,photo)
	VALUES ('$name', '$dob','$dept', '$roll','$email', '$hash','$gender','$school','$add','$photo')");	
		
	
	echo "<p style=\"color:green\">Succesfully Registered !!</p>";

   }
	
	mysql_close($conid);
  }


?>
<html>

<head>
<style>
body{
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
color:inherit;
font-size:22px;
}
</style>
</head>
<body align="center">
</body>

</html>