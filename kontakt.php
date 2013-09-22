<?php
if(isset($_POST) ){

	$formok = true;
	$errors = array();
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$data = date('d/m/y');
	$time = time('H:i:s');
	$name = $_POST['name'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$enquiry = $_POST['enquiry'];
	$message = $_POST['message'];


	if(empty($name)){
		$formok = false;
		$errors[] = "Niste vpisali vasega imena";
	}
	if(empty($email)){
		$formok = false;
		$errors[] = "Niste vpisali vasega E-mail naslova";
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$formok = false;
		$errors[] = "Niste vpisali pravilno obliko E-mail naslova";
	}
	if(empty($message)){
		$formok = false;
		$message = "Vase besedilo je prazno";
	}
	elseif (strlen($message) < 20) {
		$formok = false;
		$errors = "Vpisati morate vsaj 20 crk"; 
	}

	if($formok){
		$headers = "Od: info@example.com". "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$emailbody = "
		<p>Dobili ste novo sporocilo preko spletko.eu</p>
			<p><strong>Ime: </strong> {$name} </p>
			<p><strong>Email naslov: </strong> {$email}</p>
			<p><strong>Telefon: </strong> {$telephone}</p>
			<p><strong>Enquiry: </strong> {$enquiry}</p>
			<p><strong>Besedilo: </strong> {$message}</p>
			<p>To sporocilo je bilo poslano od IP naslova: {$ipaddress}, dne: {$date}</p>";
		mail("enquiries@example.com", "New Enquiry",$emailbody,$headers);
	}
	$returndata = array(
		'posted_form_data' => array(
			'name' => $name,
			'email' => $email,
			'telephone' => $telephone,
			'enquiry' => $enquiry,
			'message' => $message
			),
		'form_ok' => $formok,
		'errors' => $errors
		);
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){  
        session_start();  
        $_SESSION['cf_returndata'] = $returndata;  
          
        header('location: ' . $_SERVER['HTTP_REFERER']);  
    }  
}  