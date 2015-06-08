<?php
header('Content-Type: text/html; charset=utf-8');

$mysqli = new mysqli("localhost", "root", "root", "sites");

if($mysqli->connect_errno)
{
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$stmt = $mysqli->prepare("SELECT * FROM sites");

if(!$stmt->execute())
{
    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
}

$stmt->store_result();

$stmt->bind_result($id, $sitename, $url, $description, $rate);

$table_content = '';

while($stmt->fetch())
{
    $table_content .= "<tr row-id=\"$id\" ><td><input  class=\"edit_row\" type=\"button\" value=\"Редактировать\" /><input class=\"delete_row\" type=\"button\" value=\"Удалить\" /></td><td>$sitename</td><td><a target=\"_blank\" href=\"http://$url\">$url</a></td><td>$description</td><td>$rate</td></tr>\n";
}

$stmt->close();

echo <<< text
<!DOCTYPE html>
<html>
	<head>
		<title>Sites</title>
		<link href="css/style.css" rel="stylesheet" />
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
	<div class="form_wrap">
	<div class="form_title">Добавить сайт</div>
		<form method="post" action="" class="add-item-form" name="Добавить">
			<p><b>Название:</b><br>
				<input class="new-site-name" type="text" size="40">
			</p>
			<p><b>Сайт:</b><br>
				<input class="new-site-url" type="text" size="40">
			</p>
			<p><b>Описание:</b><br>
				<textarea class="new-site-desc" name="comment" cols="40" rows="3"></textarea>
			</p>
			<p><b>Рейтинг:</b><br>
				<select class="new-site-rate">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option selected="selected" value="4">4</option>
				  <option value="5">5</option>
				</select>
			</p>
			<p><input class="add-site" type="button" value="Добавить" /></p>
		</form>
	</div>
		<table id="table">
			<thead>
				<tr>
					<th></th>
					<th>Название</th>
					<th>Сайт</th>
					<th>Описание</th>
					<th>Рейтинг</th>
				</tr>
			</thead>
			<tbody>
				$table_content
			</tbody>
		</table>
	</body>
</html>

text;
