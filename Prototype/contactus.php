<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact Us Page</title>
	<link rel="shortcut icon" href="/img/icons/logo.png" /><!--temp name till real logo is placed in here-->
	<link rel="stylesheet" href="style/ContactUsStyle.css"/>
	<script src="scripts/SendMailTo.js"></script>
	<?php 
	//this is mainly used to sanatise the code
	function sanitise_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return($data);
    }
	?>
</head>

<body>
	
	<header></header>
	
	<main>
<!--		<?php //php coding starts here for the main proccess of this seciton
//		$err_msg = "";
//		if (isset($_POST["name"]))
//		{
////		echo "<p>Testing is this work</p>"; testestst
////			echo "<p>Test2</p>";
//			$name = $_POST["name"];
//			$name = sanitise_input($name);
//			$email = $_POST['email'];
//			$email = sanitise_input($email);
//			$subject = $_POST["subject"];
//			$subject = sanitise_input($subject);
//			$msg = $_POST["msg"];
//			$msg = sanitise_input($msg);
//			/*echo"<p>Round 1:</p>";
//			echo "<p>Name:".$name."</p>";
//			echo "<p>Email:".$email."</p>";
//			echo "<p>Subject:".$subject."</p>";
//			echo "<p>Message:".$msg."</p>";*/
//			$err_msg="";
//			//name
//			if (($name)=="") {
//				$err_msg .= "<p>Please enter first name.</p>";
//			}
//			else if (!preg_match("/^[a-zA-Z]{1,25}$/",$name)) {
//				$err_msg .= "<p>Your name can only contain max 25 alpha characters.</p>";
//			}
//			
//			//email
//			if ($email=="") {
//				$err_msg .= "<p>Please enter email.</p>";
//			}
//			else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//				$err_msg .= "<p>The email you have entered is invalid.</p>";
//			}
//			
//			if($err_msg=="")
//			{
//				$headers="From: $email \r\n";
//				/*echo"<p>Round 2:</p>";
//				echo "<p>Name:".$name."</p>";
//				echo "<p>Email:".$email."</p>";
//				echo "<p>Subject:".$subject."</p>";
//				echo "<p>Message:".$msg."</p>";*/
//				$recieving_email="strent@gmail.com";//"invenlochbikes@gmail.com"; //This is blocked off and use an alt email so that the main email wont be filled up with spam.
////				echo $recieving_email. $subject. $msg. $headers;
//				echo"<a href=mailto:$recieving_email?subject=$subject&body=$msg>SEND MAIL TEST</a>";
//			}
//		}
		?>-->
		<div id="headercomment" class="contactmargin">
			<h2> For questions, bookings or just to chat about eBikes, contact us today. <br/>
			Or Check Our <a href="#faq">FAQ'S </a>.</h2>
		</div>
		
		
		<div id="contactUsInfo" class="contactmargin">
			<div id="contactbox">
				<div class="Contactbox" id="Conactbox1">
					<div id="contactInfo" class="textcentral">
						<h2>CONTACT INFORMATION</h2>
						<p> We are a 'Click &amp; Collect' Service. Book a location and pick-up time online and your bike/s will be waiting for you.</p>
						<table width="100%" border="0">
						  <tbody>
							<tr>
							  <td><img src="img/icons/calandar.png" alt="" width="59" height="55" class="imgpadding"/></td>
							  <td><p>TRADING HOURS<br>
													Open -Days a week;<br>
										9am-5pm</p></td>
							</tr>
							<tr>
							  <td><img src="img/icons/phone.png" alt="" width="56" height="59" class="imgpadding"/></td>
							  <td><p>INVERLOCH BIKE HIRE&nbsp;<br>
													invenlochbikes@gmail.com<br>
													Mob:0455 896 240</p></td>
							</tr>
<!--
							<tr>
							  <td><img src="img/icons/pin.png" alt="" width="51" height="77" class="imgpadding"/></td>
							  <td>addresshere street suburb, state, <br>
													postcode&nbsp</p>;</td>
							</tr>
-->
						  </tbody>
						</table>
						<p>We look foward to hearing from you.&nbsp;</p>
					</div>
				</div>
				<div class="Contactbox" id="Conactbox2">
					<form action="contactus.php" method="post" id="emailform" name="emailform" class="textcentral">
							<p>
								<label for="name">Your Name (Required):</label>
								<br>
								<input name="name" type="text" required="required" id="name" class="fourmsize"/>
							</p>
							<p>
								<label for="emailinput">Your Email (Required):</label>
								<br>
								<input name="email" type="text" required="required" id="email" class="fourmsize"/>
							</p>
							<p>
								<label for="subject">Subject:</label>
								<br>
								<input name="subject" type="text" id="subject" class="fourmsize"/>
							</p>
							<p>
								<label for="msg">Your Message:</label>
								<br>
								<textarea name="msg" rows="10" id="msg" class="fourmsize"></textarea>
							</p>
							<button id="submit" class="submitbutton"><span>Send</span></button>
						<!--<p class='errors'><?php 
							/*if($err_msg!="")
							{
								echo "Errors when input:<br/>" . 
									$err_msg;
							}*/
							?></p>-->
						</form>
				</div>
			</div>
		</div>
		<div id="faqfloat">
			<div id="faq" class="contactmargin">
				
				<h2>FAQ'S</h2>
				<p><em>If you can't find the answer to your questions bellow, feel free to get in touch.</em></p>
				<div id="mainfaq">
					<button type="button" class="collapsible">Do I need a license to ride on an eBike?</button>
					<div class="content">
						<p>For most electric bikes, you do not need a licence of anykind to use.</p>
					</div>
					<button type="button" class="collapsible">I've never ridden an eBike is it difficult?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">How fast does an eBike go?</button>
					<div class="content">
						<p>eBikes go as fast as 25km/h to abide with Australian eBike Laws</p>
					</div>
					<button type="button" class="collapsible">What is a cargo bike?</button>
					<div class="content">
						<p>A cargo bike is a human powered vehicle designed and constructed specifically for transporting loads.</p>
					</div>
					<button type="button" class="collapsible">Where should we ride?</button>
					<div class="content">
						<p>Around Inverloch</p>
					</div>
					<button type="button" class="collapsible">My partner doesn't ride much. Will they be fit enough?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">What brand are your eBikes?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">Do you sell eBikes?</button>
					<div class="content">
						<p>No</p>
					</div>
					<button type="button" class="collapsible">We have small kids, do you have trailers or tagalongs?</button>
					<div class="content">
						<p>Yes</p>
					</div>
					<button type="button" class="collapsible">We are a large group, how many bikes do you have?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">Do you just have eBikes?</button>
					<div class="content">
						<p>No, we have other bikes around</p>
					</div>
					<button type="button" class="collapsible">Does the hire price include supply of helmets and locks?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	<footer></footer>
</body>
</html>
