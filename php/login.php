<?php
	require_once './Database.php';

	$db = new Database();
	$conn = $db->getConnection();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$data = [
			'username' => $_POST['username'],
			'password' => $_POST['password']
		];

		$query = "SELECT * FROM users WHERE username = ? AND password = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ss", $data['username'], $data['password']);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($row) {
			$userToken = $row['TOKEN'];
			setcookie("TOKEN", $userToken, time() + 3600, "/");
		}
	}

	$conn->close();
	header("Location: ../");