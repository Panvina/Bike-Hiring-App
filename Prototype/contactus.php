<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact Us Page</title>
	<link rel="stylesheet" href="styles/style.css"/>
	<script src="scripts/animation.js"></script>
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
		<?php //php coding starts here for the main proccess of this seciton
		$err_msg = "";
		echo "<p>Testing is this work</p>";
		if (isset ($_POST["submit"]))
		{
			$name = $_POST["names"];
			$name = sanitise_input($name);
			$email = $_POST['email'];
			$email = sanitise_input($email);
			$subject = $_POST["subject"];
			$subject = sanitise_input($subject);
			$msg = $_POST["msg"];
			$msg = sanitise_input($msg);
			/*echo"<p>Round 1:</p>";
			echo "<p>Name:".$name."</p>";
			echo "<p>Email:".$email."</p>";
			echo "<p>Subject:".$subject."</p>";
			echo "<p>Message:".$msg."</p>";*/
			$err_msg="";
			//name
			if (($name)=="") {
				$err_msg .= "<p>Please enter first name.</p>";
			}
			else if (!preg_match("/^[a-zA-Z]{1,25}$/",$name)) {
				$err_msg .= "<p>First name can only contain max 25 alpha characters.</p>";
			}
			
			//email
			if ($email=="") {
				$err_msg .= "<p>Please enter email.</p>";
			}
			else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$email)) {
				$err_msg .= "<p>The email you have entered is invalid.</p>";
			}
			
			if($err_msg=="")
			{
				$email="From: $email \r\n";
				/*echo"<p>Round 2:</p>";
				echo "<p>Name:".$name."</p>";
				echo "<p>Email:".$email."</p>";
				echo "<p>Subject:".$subject."</p>";
				echo "<p>Message:".$msg."</p>";*/
				$recieving_email="s103076376@gmail.com";//"invenlochbikes@gmail.com"; //This is blocked off and use an alt email so that the main email wont be filled up with spam.
				
				$emailresult = mail($recieving_email, $subject, $msg, $email);
				if($emailresult == true)
				{
					echo"<p>email successfully send</p>";
				}
				else
				{
					$err_msg.="Email fail";
				}
			}
		}
		?>
		<div id="headercomment">
			<h2> For questions, bookings or just to chat about eBikes, contact us today. <br/>
			Or Check Our <a href="#faq">FAQ'S</a>.</h2>
		</div>
		
		
		<div id="contactUsInfo">
			<div id="contactbox">
				<div class="Contactbox" id="Conactbox1">
					<div id="contactInfo" class="textcentral">
						<h2>CONTACT INFORMATION</h2>
						<p> We are a 'Click &amp; Collect' Service. Book a location and pick-up time online and your bike/s will be waiting for you.</p>
						<p>TRADING HOURS<br>
							Open -Days a week;<br>
							9am-5pm</p>
						<p>INVERLOCK BIKE HIRE&nbsp;<br>
							invenlochbikes@gmail.com<br>
							Mob:0455 896 240</p>
						<p>addresshere street suburb, state, <br>
							postcode&nbsp;</p>
						<p>We look foward to hearing from you.&nbsp;</p>
					</div>
				</div>
				<div class="Contactbox" id="Conactbox2">
						<form  action="contactus.php" method="post" id="emailform" class="textcentral">
							<p>
								<label for="names">Your Name (Required):</label>
								<br>
								<input name="names" type="text" required="required" id="names" class="fourmsize"/>
							</p>
							<p>
								<label for="email">Your Email (Required):</label>
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
							<button type="submit" class="submitbutton" name="submit" id="submit"><span>Send</span></button>
							<?php 
							if($err_msg!="")
							{
								echo "<p class='errors'>Errors when input:<br/>";
								echo $err_msg."</p>";
							}
							?>
						</form>
				</div>
			</div>
		</div>
		<div id="faqfloat">
			<div id="faq">
				
				<h2>FAQ'S</h2>
				<p><em>If you can't find the answer to your questions bellow, feel free to get in touch.</em></p>
				<div id="mainfaq">
					<button type="button" class="collapsible">Do I need a license to ride on an eBike?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">I've never ridden an eBike is it difficult?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">How fast does an eBike go?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">What is a cargo bike?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">Where should we ride?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
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
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">We have small kids, do you have trailers or tagalongs?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">We are a large group, how many bikes do you have?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
					</div>
					<button type="button" class="collapsible">Do you just have eBikes?</button>
					<div class="content">
						<p>Lorem ipsum...</p>
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
