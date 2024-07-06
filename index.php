<?php
	require_once './php/Database.php';
	require_once './php/main.php';
	$db = new Database();
	$conn = $db->getConnection();

	if (checkToken($conn) == false) {
		header("Location: ./login");
	}

	if(isset($_POST['delete_block-btn'])) {
		$blockId = $_POST['block-id'];
		deleteBlock($conn, $blockId);
		header("Location: " . $_SERVER['PHP_SELF']);
	}

	if(isset($_POST['add-btn'])) {
		$title = $_POST['title'];
		$info = $_POST['info'];
		if($_COOKIE['parent_id']) {
			$parentId = $_COOKIE['parent_id'];
		} else {
			$parentId = '0';
		}
		createBlock($conn, $parentId, $title, $info);
		header("Location: " . $_SERVER['PHP_SELF']);
	}

	if(isset($_POST['logout-btn'])) {
		setcookie('TOKEN', '', time() - 3600, '/');
		header('Location: ./login');
	}

	$conn->close();
?>

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
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="stylesheet" type="text/css" href="./css/up-styles.css">

	<link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
	<title>SIA "SOK" Test Task</title>
</head>
<body>

	<div id="modal-w">
		<form id="auth_form" method="POST">
			<label for="title">Title</label>
			<input type="text" id="title" name="title" title="Title" maxlength="16" required>
			<label for="info">Info</label>
			<textarea id="info" name="info" title="Info" maxlength="255" required></textarea>
			<input type="submit" name="add-btn" value="Add Block">
		</form>
	</div>

	<div id="main-container">
		<div id="navbar">
			<h2>Hello, 
			<?php
				require_once './php/Database.php';
				require_once './php/main.php';

				$db = new Database();
				$conn = $db->getConnection();

				echo getUsername($conn);

				$conn->close();
			?>!
			</h2>
			<form method="POST">
				<input type="submit" name="logout-btn" value="Log Out">
			</form>
		</div>
		<div id="main-block">
			<button id="mainBlockAddBtn">Add</button>
			<?php
				require_once './php/Database.php';
				require_once './php/Block.php';

				$db = new Database();
				$conn = $db->getConnection();

				$blocks = Block::fetchAll($conn);
	
				$renderedBlocksId = [];
				renderAllBlocks($conn, $blocks, $renderedBlocksId);

				$conn->close();
			?>
		</div>
		<div id="footer">
			SIA "SOK" | Test Task
		</div>
	</div>

	<!-- JS -->
	<script type="text/javascript" src="./js/script.js"></script>
</body>
</html>