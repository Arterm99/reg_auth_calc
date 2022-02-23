<?php
session_start();
require_once ('../head.php');

class check {

	public $login;
	private $name;
	private $pass;
	
	public int $sum;
	public int $tax;

	private $db;
	private $fetch;
	private $rows;
	private $row;
	private $mysql;


	public $k;

	function header() {
	
	if (isset($_SESSION['login'])) {
	?>
		<div class="art-header"> 
			<div class='art-admin'>
				Приветствуем Вас, <b><?= $_SESSION['login'] ?></b>
			</div>
			<div class="remove-player">
				<button class="btn btn-warning" onclick="window.location.href = '/exit/exit.php';">Выйти</a></button>
				<button class="btn btn-danger" type="submit" onclick="window.location.href = '/exit/remove.php';">Удалить себя</a></button>
			</div>
		</div>

	<?php
	} else 
	die('Войдите в систему!');
}

	function db_reg() {

// Подкючение к БД
	// Назначение переменных
	$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

	$this->login = $login;
	$this->name = $name;
	$this->pass = $pass;

	$_SESSION['login'] = $login;

	if (empty($login)) exit("Поле \"Логин\"не заполнено");
	if (empty($name)) exit("Поле \"Имя\" не заполнено");
	if (empty($pass)) exit("Введите пароль"); // empty - возвращает True, если строка пустая, и False, если строка содержит хотя бы один символ

	// Хеширование пароля
	$pass = md5($pass."adadwadsagea123");

	try { 
	$db = new PDO ('mysql:host=localhost; dbname=script-01', 'root', '' );
 
 	// Установить исключения при ошибках в базе данных
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		  


	// Проверка на дублирование логинов
	$fetch = $db->query('SELECT login FROM users');
	$rows = $fetch->fetchAll();
		foreach($rows as $row) {
			if ($login === $row[0]) {
		echo "Такой логин существует<br \>";
		$this->header();
		return;
	}} 

	$this->db = $db;
	$this->fetch = $fetch;
	$this->rows = $rows;
	

	// Заносим информацию в БД
	if ($login) {
	$mysql = $db->prepare("INSERT INTO users (login, name, pass) 
							VALUES (?,?,?)")->execute(array($login, $name, $pass)); 
	$this->header();
	echo "<br \>
	В таблицу занесена <b>$mysql</b> строка";
	}

	$this->mysql = $mysql;


	} // Закрывает try
	catch (PDOException $е) {
	print "Ошибка: " . $e->getMessage();
	}

}

	function db_auth() {
// Подкючение к БД
	

	// Назначение переменных
	$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
		
	$this->login = $login;
	$this->pass = $pass;

	$_SESSION['login'] = $login;

	if (empty($login)) exit("Поле \"Логин\"не заполнено");
	if (empty($pass)) exit("Введите пароль"); // empty - возвращает True, если строка пустая, и False, если строка содержит хотя бы один символ

// Хеширование пароля
	$pass = md5($pass."adadwadsagea123"); 

	try { 
	$db = new PDO ('mysql:host=localhost; dbname=script-01', 'root', '' ); 

	// Установить исключения при ошибках в базе данных
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		   

	// Проверка логинов и паролей
	$fetch = $db->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
	$rows = $fetch->fetchALL(); // fetch_assoc - конвертирует в массив
	// Подсчитываем колличество элементов внутри массива
	if(count($rows) == 0) {
		echo "Такой пользователь не найден или Ваш пароль неверный";
		exit(); // выход
	} else {
		$this->header();
	}


	} // Закрывает try
	catch (PDOException $е) {
	print "Ошибка: " . $e->getMessage();
	}

}

		function Tdata() {
				$sum = filter_var(trim($_POST['sum']), FILTER_SANITIZE_STRING); 
				$tax = filter_var(trim($_POST['tax']), FILTER_SANITIZE_STRING);

				$sum = str_replace(',', '.', $sum);
				$tax = str_replace(',', '.', $tax);

				try {
					$this->sum = $sum;
					$this->tax = $tax;
				} catch (TypeError $e) {
				    exit('<b>Ошибка. Введите число.</b>');
				}


			if ('POST' == $_SERVER['REQUEST_METHOD']) {
				if (isset($tax, $sum)) {

					if (mb_strlen($sum, 'utf-8') > 1 && mb_strlen($sum, 'utf-8') < 8
						&& mb_strlen($tax, 'utf-8') > 0 && mb_strlen($tax, 'utf-8') < 3) {
						echo "СУММА: ".$sum."<br \>";
						echo "СТАВКА: ".$tax;
						@$str = $sum * $tax / 100;
						echo '<br />Ответ: '.$str;
						
					} else {
						return "Недопустимая длина (диапазон значений: <b> СУММА: </b>от 2 до 7, <b> СТАВКА: </b>от 1 до 2)"; 
				}
		}}

		// ПОДКЮЧЕНИЕ К БД
		
		try { 
			$db = new PDO ('mysql:host=localhost; dbname=script-01', 'root', '' ); 
		   
		    // Установить исключения при ошибках в базе данных
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		if ($str) {
			$mysql = $db->prepare("UPDATE users SET data = '$str'  
									WHERE `login` = '$_SESSION[login]'")->execute(); 
			echo "<br \><br \>";
			echo "<div> В таблицу занесено значаение расчета <b>$str</b></div>";
			// Выявление количества строк таблицы, затронутых при выполнении запроса SQL с командой UPDATE
			echo 'В таблицу занесена '.$mysql.' строка';
			}

			echo "<br \><br \>";
			echo "ОТВЕТЫ ВСЕХ ЗАРЕГЕСТРИРОВАВШИХСЯ: <br \>";
			// ОТВЕТЫ ВСЕХ ЗАРЕГЕСТРИРОВАВШИХСЯ
			$fetch = $db->query("SELECT * FROM `users`");
				$rows = $fetch->fetchALL(); 
				foreach($rows as $row) {

			echo "Имя: ".$row[2]."\n";
			echo "Ответ = ".$row[5]."<br \>";
			}


			} // Закрывает try
			catch (PDOException $е) {
			print "Ошибка: " . $e->getMessage();
			}

	
		}

function cookie() {

	// Куки
	setcookie('user', $_SESSION['login'], time() + 3600, "/");

}
}