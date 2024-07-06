<?php
	function checkToken($conn) {
		if (isset($_COOKIE["TOKEN"])) {
			$query = "SELECT * FROM users WHERE TOKEN = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $_COOKIE["TOKEN"]);
			$stmt->execute();
			
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();

			if (!$row) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	function getUsername($conn) {
		$query = "SELECT * FROM users WHERE TOKEN = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $_COOKIE["TOKEN"]);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if ($row) {
			$username = $row['username'];
			return $username;
		} else {
			return 'guest';
		}
	}

	function createBlock($conn, $parent_id, $block_title, $block_info) {
		$query = "INSERT INTO `blocks` (`parent_id`, `title`, `info`) VALUES (?, ?, ?);";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("dss", $parent_id, $block_title, $block_info);
		$stmt->execute();
		
		$stmt->close();
	}

	function deleteBlock($conn, $block_id) {
		$query = "DELETE FROM blocks WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $block_id);
		$stmt->execute();

		$stmt->close();
	}

	function renderBlock($block) {
		return "<div class='block block-{$block->getId()}'>
							<form method='post'>
								<input type='button' name='add_block-btn' value='+'>
								<input type='submit' name='delete_block-btn' value='X'>
								<input type='hidden' name='block-id' value='{$block->getId()}'/>
							</form>
							<h3>{$block->getTitle()}</h3>
							<p>{$block->getInfo()}</p>
							<p>{$block->getId()}</p>";
	}

	function renderAllBlocks($conn, $blocks, &$renderedBlocksId) {
		foreach ($blocks as $block) {
			if(!in_array($block->getId(), $renderedBlocksId)) {
				echo renderBlock($block);
				
				array_push($renderedBlocksId, $block->getId());
				
				$childs = $block->getChilds($conn, $block->getId());
				if($childs) {
					renderAllBlocks($conn, $childs, $renderedBlocksId);
				}
				echo "</div>";
			}
		}
	}