<?php
include('config.php');


$sql ="SELECT emailId from tblemail";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0):
foreach($results as $result):
$adminemail=$result->emailId;
endforeach;
endif;
if(isset($_POST['submit']))
{

$name=$_POST['name'];
$phoneno=$_POST['phonenumber'];
$email=$_POST['emailaddres'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$uip = $_SERVER ['REMOTE_ADDR'];
$isread=0;

$sql="INSERT INTO  tblcontactdata(FullName,PhoneNumber,EmailId,Subject,Message,UserIp,Is_Read) VALUES(:fname,:phone,:email,:subject,:message,:uip,:isread)";
$query = $dbh->prepare($sql);

$query->bindParam(':fname',$name,PDO::PARAM_STR);
$query->bindParam(':phone',$phoneno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':subject',$subject,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':uip',$uip,PDO::PARAM_STR);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

$to=$email.",".$adminemail; 
$headers .= "MIME-Version: 1.0"."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'From:PHPGurukul Contact Form Demo<info@phpgurukul.com>'."\r\n";
$ms.="<html></body><div>
<div><b>Name:</b> $name,</div>
<div><b>Phone Number:</b> $phoneno,</div>
<div><b>Email Id:</b> $email,</div>";
$ms.="<div style='padding-top:8px;'><b>Message : </b>$message</div><div></div></body></html>";
mail($to,$subject,$ms,$headers);




echo "<script>alert('Your info submitted successfully.');</script>";
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}


}


?>

<!DOCTYPE HTML>
<html>
<head>
<title>Contact Form</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>


<link href='//fonts.googleapis.com/css?family=Josefin+Sans:400,100,300,600,700' rel='stylesheet' type='text/css'>

</head>
<body>

	<div class="header">
		<h1>Contact Form</h1>
	</div>

	<div class="section">
		<div class="container">

			<h2>Contact Us</h2>
			<p>Send us a message and we will get back to you ASAP!</p>

			<span></span>

			<form name="ContactForm" method="post">

				<h4>Name</h4>
				<input type="text" name="name" class="user" placeholder="John Doe"  autocomplete="off" required>

				<h4>Phone Number</h4>
				<input type="text" name="phonenumber" class="phone" placeholder="123.456.7891" maxlength="10" required autocomplete="off">

				<h4>Email Address</h4>
				<input type="email" name="emailaddres" class="email" placeholder="Address@email.com" required autocomplete="off">

				<h4>Subject</h4>
				<input type="text" name="subject" class="email" placeholder="Subject" autocomplete="off">

				<h4>Message</h4>
				<textarea class="mess" name="message" placeholder="Message" required></textarea>
				<input type="submit" value="Send Message" name="submit">

			</form>						
		</div>
	</div>
		
</body>
</html>