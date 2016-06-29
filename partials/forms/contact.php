<?php 

	require_once "Mail.php";

	if( empty($_POST['password']) ) {

	$success = false;

	$firstname = isset( $_POST['firstname'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['firstname'] ) : "";
	$lastname = isset( $_POST['lastname'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['lastname'] ) : "";
	$interest = isset( $_POST['interest'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['interest'] ) : "";
	$emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
	$message = isset( $_POST['message'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['message'] ) : "";

	$from = 'Sophie Uliano <sophie@gorgeouslygreen.com>';
 	$to = $firstname.' '.$lastname.' <'.$emailaddress.'>';

 	$smtp = Mail::factory('smtp', array(
        'host' => 'sophieuliano.com',
        'port' => '587',
        'auth' => true,
        'username' => 'kyle@sophieuliano.com',
        'password' => 'zKq4w9^3'
    ));

	if ( $firstname && $lastname && $emailaddress && $message ) {

		$subject = "Sophie Uliano's Contact Lead";

		$headers = array(
			    'From' => $to,
			    'Subject' => $subject,
			    'Reply-To' => $from,
			    'X-Mailer' => 'PHP/'.phpversion(),
			    'MIME-Version' => '1.0',
			    'Content-Type' => 'text/html',
			    'charset' => 'ISO-8859-1'
			);

		$formcontent = '<html><body><center>';
			$formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
			$formcontent .= "<tr><td><strong>Interest:</strong></td><td>" . $interest . "</td></tr>";
			$formcontent .= "<tr><td><strong>Name:</strong></td><td>" . $firstname .' '. $lastname . "</td></tr>";
			$formcontent .= "<tr><td><strong>Email:</strong></td><td>" . $emailaddress . "</td></tr>";
			$formcontent .= "<tr><td><strong>Message:</strong></td><td>" . $message . "</td></tr>";
		$formcontent .= '</table></center></body></html>';

		$success = $smtp->send($from, $headers, $formcontent );

		if ( $interest === "Product Reviews") {

			$subject2 = "Sophie Uliano's Product Reviews";

			$headers2 = array(
			    'From' => $from,
			    'Subject' => $subject2,
			    'Date' => date("Y-m-d",time()),
			    'Reply-To' => $to,
			    'X-Mailer' => 'PHP/'.phpversion(),
			    'MIME-Version' => '1.0',
			    'Content-Type' => 'text/html',
			    'charset' => 'ISO-8859-1'
			);

			ob_start();
	        include("../emails/productReview.php");
	        $body = ob_get_clean();

			$success = $smtp->send($to, $headers2, $body);
		}
	}

	// Return an appropriate response to the browser
	if ( isset($_GET["ajax"]) ) {
		
		echo $success ? "Success" : "E";

	} else { ?>

	<html lang="en">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	  	<head>
	    	<title>Thank You!</title>
	  	</head>
		<body>
		  <?php if ( $success ) echo "<p>Thanks for sending your message! We'll get back to you shortly.</p>" ?>
		  <?php if ( !$success ) echo "<p>There was a problem sending your message. Please try again.</p>" ?>
	  </body>
	</html>

	<?php } 
}
?>
