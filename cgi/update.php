<?php

header('Content-Type: text/html; charset=utf-8');

$mysqli = new mysqli("localhost", "root", "root", "sites");

if($mysqli->connect_errno)
{
    echo json_encode(array("error"=>true, "error_text"=>"Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
	die();
}

if(!isset($_POST['id']) || !isset($_POST['sitename']) || !isset($_POST['url']) || !isset($_POST['description']) || !isset($_POST['rate']))
{
	echo json_encode(array("error"=>true, "error_text"=>"Не верный формат данных"));
	die();
}

if (!($stmt = $mysqli->prepare("UPDATE sites SET name=?, url=?, description=?, rate=? WHERE id=?")))
{
	echo json_encode(array("error"=>true, "error_text"=>"Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error));
	die();
}

if(!$stmt->bind_param("sssii", $_POST['sitename'], $_POST['url'], $_POST['description'], $_POST['rate'], $_POST['id']))
{
	echo json_encode(array("error"=>true, "error_text"=>"Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error));
	$stmt->close();
	die();
}

if(!$stmt->execute())
{
	echo json_encode(array("error"=>true, "error_text"=>"Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error));
	$stmt->close();
	die();
}

$stmt->close();

echo json_encode(array());