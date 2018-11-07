<?php

try {
	$conn = new PDO("mysql:dbname=bdphp7;host=localhost","root","");
} catch (PDOException $e) {
	echo "erro no banco ".$e->getMessage();
}

?>