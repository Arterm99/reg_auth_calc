<?php 

header('Content-Type: application/json'); // говорим что все возвращаем в формате json


$type = $_GET['url'];
if ($type === 'posts') {
	try { 
	$db = new PDO ('mysql:host=localhost; dbname=script-01', 'root', '' ); 

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	



	$fetch = $db->query("SELECT * FROM `users`"); 
	$rows = $fetch->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC - Возвращает следующую строку в виде массива, индексированного именами столбцов


	echo json_encode($rows); // обработка массива в json
	// Функция json_decode() преобразует объекты и массивы из формата JSON в формат РНР

	} // Закрывает try
	catch (PDOException $е) {
	print "Ошибка: " . $e->getMessage();
	}
}

