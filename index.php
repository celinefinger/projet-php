<?php
	$firstname = $lastname = $email = $phone = $message = "";
	$firstnameError = $lastnameError = $emailError = $phoneError = $messageError = "";
	$isSuccess = false;
	$emailTo = "celine.finger@gmail.com";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstname = verifyInput($_POST['firstname']);
		$lastname = verifyInput($_POST['lastname']);
		$email = verifyInput($_POST['email']);
		$phone = verifyInput($_POST['phone']);
		$message = verifyInput($_POST['message']);
		$isSuccess = true;
		$emailText = "";

		if(empty($firstname)) {
			$firstnameError = "J'ai besoin de connaître votre prénom.";
			$isSuccess = false;
		}
		else {
			$emailText .= "Firstname: $firstname\n";
		}

		if(empty($lastname)) {
			$lastnameError = "Euh... Vous avez oublié de renseigner votre nom...";
			$isSuccess = false;
		}
		else {
			$emailText .= "Lastname: $lastname\n";
		}

		if(empty($email)) {
			$emailError = "Oups, il me manque votre e-mail !";
			$isSuccess = false;
		}

		if(empty($message)) {
			$messageError = "Hé, il manque le message !";
			$isSuccess = false;
		}
		else {
			$emailText .= "Message: $message\n";
		}

		if(!isEmail($email)) {
			$emailError = "C'est pas un e-mail valide ça !";
			$isSuccess = false;
		}
		else {
			$emailText .= "Email: $email\n";
		}

		if(!isPhone($phone)) {
			$phoneError = "Que des chiffres et des espaces, svp.";
			$isSuccess = false;
		}
		else {
			$emailText .= "Phone: $phone\n";
		}

		if($isSuccess) {
			$headers = "From: $firstname $lastname <$email>\r\nReply-To: $email";
			mail($emailTo, "Un message de ton site PHP", $emailText, $headers);
			$firstname = $lastname = $email = $phone = $message = "";
		}

	}

	function isPhone($var) {
		return preg_match("/^[0-9 ]*$/", $var);
	}

	function isEmail($var) {
		return filter_var($var, FILTER_VALIDATE_EMAIL);
	}

	function verifyInput($var) {
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlspecialchars($var);
		return $var;
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Contactez-moi !</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet">
	
</head>
<body>
	<div class="container">
		<div class="divider"></div>
		<div class="heading">
			<h2>Contactez-moi !</h2>
		</div>
		<div class="row">
			<div class="col-lg-12 col-lg-offset-1">
				<form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
					<div class="row">
						<div class="col-md-6">
							<label for="firstname">Prénom <span class="blue">*</span></label>
							<input id="firstname" type="text" name="firstname" class="form-control" placeholder="Votre prénom" value="<?php echo $firstname; ?>">
							<p class="comments"><?php echo $firstnameError; ?></p>
						</div>
						<div class="col-md-6">
							<label for="lastname">Nom <span class="blue">*</span></label>
							<input id="lastname" type="text" name="lastname" class="form-control" placeholder="Votre nom" value="<?php echo $lastname; ?>">
							<p class="comments"><?php echo $lastnameError; ?></p>
						</div>
						<div class="col-md-6">
							<label for="email">E-mail <span class="blue">*</span></label>
							<input id="email" type="email" name="email" class="form-control" placeholder="Votre email" value="<?php echo $email; ?>">
							<p class="comments"><?php echo $emailError; ?></p>
						</div>
						<div class="col-md-6">
							<label for="phone">Téléphone</label>
							<input id="phone" type="tel" name="phone" class="form-control" placeholder="Votre numéro de téléphone" value="<?php echo $phone; ?>">
							<p class="comments"><?php echo $phoneError; ?></p>
						</div>
						<div class="col-md-12">
							<label for="message">Message <span class="blue">*</span></label>
							<textarea id="message" name="message" class="form-control" placeholder="Votre message" rows="4"><?php echo $message; ?></textarea>
							<p class="comments"><?php echo $messageError; ?></p>
						</div>
						<div class="col-md-12">
							<p class="blue">* Ces informations sont requises.</p>
						</div>
						<div class="col-md-12">
							<input type="submit" class="button1" value="Envoyer">
						</div>
					</div>
					<p class="thank-you" style="display:<?php if($isSuccess) echo 'block'; else echo 'none'; ?>">Votre message a bien été envoyé. Merci !</p>
				</form>
			</div>
		</div>
	</div>
	
</body>
</html>

