<?php

header('Content-Type: text/html; charset=utf-8');

$mysqli = new mysqli("localhost", "root", "root", "sites");

if($mysqli->connect_errno)
{
    echo json_encode(array("error"=>true, "error_text"=>"Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
	die();
}

if(!isset($_POST['id']))
{
	echo json_encode(array("error"=>true, "error_text"=>"Не верный формат данных"));
	die();
}

if (!($stmt = $mysqli->prepare("DELETE FROM sites WHERE id=?")))
{
	echo json_encode(array("error"=>true, "error_text"=>"Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error));
	die();
}

if(!$stmt->bind_param("i", $_POST['id']))
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