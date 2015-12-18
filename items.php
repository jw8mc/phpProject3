<?php

	include_once("ItemManager.php");
	$SALT = "skatingatonementshark";

	$method = $_SERVER['REQUEST_METHOD'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$toHash = $ip . $SALT;
	$expectedToken = hash('sha256', $toHash);

	$token = $_SERVER['HTTP_TOKEN'];
	
	if ($token === $expectedToken) {
		switch ($method) {
			case "GET":
				if (isset($_GET['id']) && !empty($_GET['id'])) {
					//getting record by id
					$id = $_GET['id'];
					$item = ItemManager::GetById($id);
					echo json_encode($item);
				} else {
					//getting all records
					$items = ItemManager::GetAllItems();
					echo json_encode($items);
				}
				break;
			case "PUT":
				$newRecordData = fopen("php://input", "r");
				$data = stream_get_contents($newRecordData);
				fclose($newRecordData);
				parse_str($data);
				$newId = ItemManager::AddNewItem($desc, $price, $quantity);
				echo "The item $desc has been inserted with the id $newId.";
				break;
			case "POST":
				$id = $_POST["id"];
				if (isset($id) && $id != 0 && !empty($id)) {
					$desc = $_POST["desc"];
					$price = $_POST["price"];
					$quantity = $_POST["quantity"];
					$rows = ItemManager::UpdateItem($id, $desc, $price, $quantity);
					echo "Rows updated: $rows.";
				} else {
					echo "Please enter a valid item id to update.";
				}
				break;
			case "DELETE":
				$deleteData = fopen("php://input", "r");
				$data = stream_get_contents($deleteData);
				fclose($deleteData);
				parse_str($data);
				$rows = ItemManager::DeleteItem($id);
				echo "Rows deleted: $rows.";
				break;
		}
	} else {
		echo "ERROR: Token mismatch.";
	}

?>