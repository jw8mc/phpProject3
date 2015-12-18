<?php

	$PASSWORD_SALT = "primeaxiombattleground";
	$TOKEN_SALT = "skatingatonementshark";
	$TEST_USER_NAME = "nala";
	$method = $_SERVER["REQUEST_METHOD"];

	if ($method == "POST") {
		//allow login check
		$username = $TEST_USER_NAME;
		$password = $_POST["password"];

		$db = new PDO("mysql:host=localhost;dbname=Project3", "root", "student");
		$sql = "select * from users where username=:username";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(":username", $username);
		$stmt->execute();
		$results = $stmt->fetch(PDO::FETCH_ASSOC);

		$password = $password . $PASSWORD_SALT;
		$hash = hash("sha256", $password);

		if ($hash === $results['password']) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$ip = $ip . $TOKEN_SALT;
			$token = hash('sha256', $ip);
			echo $token;
		} else {
			echo "Your password is incorrect.";
		}
	} else {
		//disallow login check
		header("HTTP/1.0 403 Forbidden");
	}

?>