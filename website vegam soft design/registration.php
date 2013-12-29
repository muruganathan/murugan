<?php  
      include 'header.php';
if($_POST['submit1']!=""){


     if($_POST['email'] !=""){
	 
	 $email = mysql_num_rows(mysql_query("SELECT * FROM registration WHERE email ='".$_POST['email']."' "));
	 
	 if($email > 0){
	 	$msg="<li>Email alreay exist.</li>";
		$c++;
		 }
	}
	
	if($_POST['paypal'] !=""){
	 
	 $paypal = mysql_num_rows(mysql_query("SELECT * FROM registration WHERE paypal ='".$_POST['paypal']."' "));
	 
	 if($paypal > 0){
	 	$msg="<li>Paypal id is alreay exist.</li>";
		$c++;
		 }
	}

	if($_POST['skype'] !=""){
		 
		 $skype = mysql_num_rows(mysql_query("SELECT * FROM registration WHERE skype ='".$_POST['skype']."' "));
		 
		 if($skype > 0){
			$msg="<li>skype id is alreay exist.</li>";
			$c++;
			 }
		}
		
		if($_POST['residence'] !=""){
	 
	 $residence = mysql_num_rows(mysql_query("SELECT * FROM registration WHERE city ='".$_POST['residence']."' "));
	 
	 if($residence > 0){
	 	$msg="<li>Diabolo id is alreay exist.</li>";
		$c++;
		 }
	}
		if($_POST['user'] !=""){
	 
	 $user = mysql_num_rows(mysql_query("SELECT * FROM registration WHERE username ='".$_POST['user']."' "));
	 
	 if($user > 0){
	 	$msg="<li>User name is alreay exist.</li>";
		$c++;
		 }
	}
		if($c==0){
		$verification = md5(uniqid(rand()));
		$_POST['fin_id'] = trim(substr($verification, 0, 20));

		$reg = mysql_query("INSERT INTO registration set id='".$_POST['fin_id']."', firstname='".$_POST['fname']."',lastname='".$_POST['lname']."',email='".$_POST['email']."',city='".$_POST['residence']."',phone='".$_POST['phone']."',paypal='".$_POST['paypal']."', skype='".$_POST['skype']."', username='".$_POST['user']."',pass='".$_POST['pass']."'");
		
			/*$last_id=mysql_insert_id();		
			
		$user = mysql_query("SELECT * FROM registration where id = '".$_POST['fin_id']."'");
 	    $detail = mysql_fetch_object($user);
		$_SESSION['a']=$detail->email;
		
		$sendTo = $_POST['email'];
		$subject = "Welcome To FRANZEYMART!";
		$headers = "From: <info@frenzymart.com>";
		$body = "Please click on the link provided to activate your account. If you encounter any issues
         when trying to logging in, please don't hesitate to contact FRANZEYMART \n".
		"http://www.warblerdemo.co.cc/frenzygame/verify.php?key=base64_encode($last_id).\n".
		"For more details,please contact FRENZYMART. \n".
		"Regards, \n ". 
		"FRENZYMART \n";
		mail($sendTo, $subject, $body, $headers);
		 $sendTo = $_POST['email'];
		$subject = "Welcome To FRANZEYMART";
		//$headers  = 'MIME-Version: 1.0' . "\r\n";
		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
		$headers = "From: FRANZEYMART \n";
		$message = "Please click on the link provided to activate your account. If you encounter any issues
when trying to logging in, please don't hesitate to contact FRANZEYMART \n";
		$message .= "<a href='http://www.warblerdemo.co.cc/frenzygame/verify.php?key=base64_encode($last_id)' target='_blank'>http://www.warblerdemo.co.cc/frenzygame/verify.php?key=base64_encode($last_id).</a>\n";
		$message .= "Regards,\n";
		$message .= "FRANZEYMART";
		mail($sendTo, $subject, $message, $headers);	
			$to = $_POST['email'];
			$subject = "Welcome To FRANZEYMART";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: FRANZEYMART   \r\n";
			$message = "Hi <b>".ucwords($_POST['fname'])."</b><br/><br/>\r\n\n";
			$message .= "Thank you for registering with FRANZEYMART <br/><br/>\r\n\n";		
			$message .= "http://www.warblerdemo.co.cc/frenzygame/<br/><br/>\r\n\n";	 'MIME-Version: 1.0'.""\r\n Content-type : text/hyml; charset=iso-8859-1
			$message .= "Please click on the link provided to activate your account. If you encounter any issues
when trying to logging in, please don't hesitate to contact us at FRANZEYMART<br/><br/>\r\n\n";
      		$message .= "<a href='http://www.warblerdemo.co.cc/frenzygame/verify.php?key=".base64_encode($last_id)."' target='_blank'>http://www.warblerdemo.co.cc/frenzygame/verify.php?key=".base64_encode($last_id)."</a><br/><br/>\r\n\n";
			$message .= "Congratulations! You've just created an account to enable FRANZEYMART.<br/><br/>\r\n\n";
			$message .= "Here are your login details. Please keep them in a safe place:<br/><br/>\r\n\n";
			$message .= "<strong>LogIn-Id : </strong>".$_POST['email']."<br/>\r\n\n";
			$message .= "<strong>Password :</strong>".$_POST['pass']."<br/><br/>\r\n\n";		
			$message .= "Kind Regards,<br/>\r\n\n";
			$message .= "FRANZEYMART";
			mail($to, $subject, $message, $headers);*/
		$dest = "registration.php?act=des";
		
		header( "refresh: 3;" ); 
		echo '<div align="center" style="background:#200D09; height:50px;"><p style="padding-top:12px; padding-left:50px; font-size:16px;"> You are successfully registered in <label style="color:#990000;"> FrenzyMart</label>.Please Login to start your auction here!</p></div>'; ?>
		<script>window.parent.location.href='index.php'</script>
		<?php
	
		
	
	 
	
			}} ?>
			
<div id="container_bg">

 
<div id="content">
<div id="wrapper" style="margin-top:26px;">    
<!--<div class="slider-wrapper theme-orman">
<div class="ribbon"></div>
<div id="slider" class="nivoSlider" style="border: 1px solid #ccc;">
<a href=""><img src="images/banner.jpg" alt="" title="This is an example of a caption 1" /></a>
<a href=""><img src="images/banner2.jpg" alt="" title="This is an example of a caption 2" /></a>
<a href=""><img src="images/banner3.jpg" alt="" title="This is an example of a caption 3" /></a>
<a href=""><img src="images/banner4.jpg" alt="" title="This is an example of a caption 4" /></a>
</div>


</div>--></div>
<br /><br />
<div class="box">
<div class="box-content_home">
<div class="box-heading">Registration with FrenzyMart </div>
<div style="padding:0px 10px 20px 210px;"><br /><br /><p align="justify"><br />
 <form method="POST" name="register_form" action="" onSubmit="return reg_validate();" > 

<table cellspacing="4px" align="center">
<? if($msg!="") { ?>
	 <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" class="errortxt"><? echo $msg; ?></td>
  </tr>
  <? } ?>
  <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
<tr>
<td>
<label style="font-size:16px; font-weight:600;">First Name* :</td>
<td>
<input style="border:" class="box1" type="text" name="fname" value="<?php echo $_POST['fname'];?>"></td></tr>
<tr>
<td>
<label style="font-size:16px; font-weight:600;">Last Name*: </td>
<td>
<input style="border:" class="box1" type="text" name="lname" value="<?php echo $_POST['lname'];?>"></td></tr>


<tr>
<td>
<label style="font-size:16px; font-weight:600;">Email*:</td>
<td>
<input class="box1" type="text" name="email" value="<?php echo $_POST['email'];?>"></td></tr>

<tr>
<td>
<label style="font-size:16px; font-weight:600;">Diablo id *: </td>
<td>
<input class="box1" type="text" name="residence" value="<?php echo $_POST['residence'];?>"></td></tr>

<tr>
<td>
<label style="font-size:16px; font-weight:600;">Primary Phone number*: </td>
<td>
<input class="box1" type="text" name="phone" value="<?php echo $_POST['phone'];?>"></td>
</tr>

<tr>
<td>
<label style="font-size:16px; font-weight:600;">Paypal id : </td>
<td>
<input class="box1" type="text" name="paypal" value="<?php echo $_POST['paypal'];?>"></td>
</tr>
<tr>
<td>
<label style="font-size:16px; font-weight:600;">Skype id : </td>
<td>
<input class="box1" type="text" name="skype" value="<?php echo $_POST['skype'];?>"></td>
</tr>
<tr>
<td>
<label style="font-size:16px; font-weight:600;">Username:</td>
<td>
<input class="box1" type="text" name="user" value="<?php echo $_POST['user'];?>"></td>
</tr>

<tr>
<td>
<label style="font-size:16px; font-weight:600;">Password: </td>
<td>
<input class="box1" type="password" name="pass" value="<?php echo $_POST['pass'];?>"></td>
</tr>

<tr>
<td>
<label style="font-size:16px; font-weight:600;">Re enter password : </td>
<td>
<input class="box1" type="password" name="repass" value="<?php echo $_POST['repass'];?>"></td>
</tr></table>
<br/>

<input class="button" style="margin-left:85px" type="submit" value="Submit" name='submit1' ></form>
</div>
</div></div>

	</div>

  </div>
</div>

<?php include 'footer.php';  ?>
</body>
</html>
