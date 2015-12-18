<?php

	class ItemManager {
		/*	Returns item record matching given ID.
		*/
		public static function GetById($id) {
			$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
			$sql = "select * from Inventory where id=:id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$results = $stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}

		/*	Returns all item records.
		*/
		public static function GetAllItems() {
			$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
			$sql = "select * from Inventory";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}

		/*	Adds a new item record using given data.
		*/
		public static function AddNewItem($desc, $price, $quantity) {
			$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
			$sql = "insert into Inventory(`description`, price, qty) "
				 . "values(:desc, :price, :quantity)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":desc", $desc);
			$stmt->bindParam(":price", $price);
			$stmt->bindParam(":quantity", $quantity);
			$stmt->execute();

			return $db->lastInsertId();
		}

		/*	Updates an item record using given data.
		*/
		public static function UpdateItem($id, $desc, $price, $quantity) {
			$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
			$sql = "update Inventory set";
			if ($desc != "") {
				$sql .= " `description`=:desc,";
			}
			if ($price != "") {
				$sql .= " price=:price,";
			}
			if ($quantity != "") {
				$sql .= " qty=:quantity,";
			}
			//remove final comma
			$sql = substr($sql, 0, (strlen($sql) - 1));
			//adding where clause
			$sql .= " where id=:id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id);
			if ($desc != "") {
				$stmt->bindParam(":desc", $desc);
			}
			if ($price != "") {
				$stmt->bindParam(":price", $price);
			}
			if ($quantity != "") {
				$stmt->bindParam(":quantity", $quantity);
			}
			$stmt->execute();

			return $stmt->rowCount();
		}

		/*	Deletes an item record matching given id.
		*/
		public static function DeleteItem($id) {
			$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
			$sql = "delete from Inventory where id=:id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->rowCount(); 
		}
	}
?>