<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	
	<!-- CSS/JS -->
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/lp-styles.css">

	<link rel="icon" href="../images/favicon.png" type="image/png" sizes="16x16">
	<title>SIA "Sok" Test Task</title>
</head>
<body>
	<div id="main-container">
		<form id="auth_form" action="../php/login.php" method="POST">
			<label for="name">Username</label>
			<input type="text" id="username" name="username" title="Username" maxlength="16" required>
			<label for="name">Password</label>
			<input type="password" id="password" name="password" title="Password" maxlength="24" required>
			<input type="submit" value="Log In">
		</form>
	</div>
</body>
</html>

<?php
	require_once '../php/Database.php';
	require_once '../php/main.php';

	$db = new Database();
	$conn = $db->getConnection();

	if (checkToken($conn) == true) {
    header("Location: ../");
	}

	$conn->close();
?>