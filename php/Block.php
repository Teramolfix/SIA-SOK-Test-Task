<?php
	class Block
	{
		public $id;
		public $parentId;
		public $title;
		public $info;
		public function __construct($id, $parentId, $title, $info) {
			$this->id = $id;
			$this->parentId = $parentId;
			$this->title = $title;
			$this->info = $info;
		}

		public function getId() {
			return $this->id;
		}
		public function getParentId() {
			return $this->parentId;
		}
		public function getTitle() {
			return $this->title;
		}
		public function setTitle($title) {
			return $this->title = $title;
		}
		public function getInfo() {
			return $this->info;
		}
		public function setInfo($info) {
			return $this->info = $info;
		}

		public static function createBlock($data) {
			$id = $data['id'];
			$parentId = $data['parent_id'];
			$title = $data['title'];
			$info = $data['info'];

			return new Block($id, $parentId, $title, $info);
		}

		public static function fetchAll($conn) {
			$query = "SELECT * FROM blocks ORDER BY id;";
			$result = $conn->query($query);

			$blocks = [];

			while ($row = $result->fetch_assoc()) {
				$blocks[] = self::createBlock($row);
			}

			return $blocks;
		}

		public static function getChilds($conn, $parent_id) {
			$query = "SELECT * FROM blocks WHERE parent_id = ? ORDER BY id";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $parent_id);
			$stmt->execute();
			$result = $stmt->get_result();

			$childs = [];
			while ($row = $result->fetch_assoc()) {
				$childs[] = self::createBlock($row);
			}
			
			return $childs;
		}
	}