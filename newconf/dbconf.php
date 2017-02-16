<?php
try {
	$db = new PDO("mysql:host=localhost;dbname=bookmytr_managio",'bookmytr_ainerdb','o?y$)d9y5;}$+)sh');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) { echo "Error " . $e->getCode() . "<!--" . $e->getMessage() . "-->"; die(); }