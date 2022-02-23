	<?php

require_once ('head.php');

		function Forma() {  ?>
			<div class="search-form">
				<div>
					<h3>Расчет НДС</h3>
				</div>
				<div>
					<form method="POST" action="/30_my_test/summ.php">
						<input placeholder="Введите сумму" type="text" name="sum" autofocus>
						<br />
						<input placeholder="Введите ставку" type="text" name="tax">
						<br />
						<button class="btn btn-primary" type="submit">Расчитать</button>
					</form>
				</div>
			</div> 
	<?php
	}
		function Reg() {  ?>
			<div class="container">
			<div class="row">
			<div class="col">
			<div class="search-form">
				<div>
					<h3>Форма регистрации</h3>
				</div>
				<div>
					<form method="POST" action="/30_my_test/validation-form/reg.php">
						<input class="form-control" placeholder="Введите логин" type="text" name="login" autofocus>
						<br />
						<input class="form-control" placeholder="Введите имя" type="text" name="name">
						<br />
						<input class="form-control" placeholder="Введите пароль" type="password" name="pass">
						<br />
						<button class="btn btn-primary" type="submit">Зарегистрироваться</button>
					</form>
				</div>
			</div> </div>

			<div class="col">
			<div class="search-form">
				<div>
					<h3>Форма авторизации</h3>
				</div>
				<div>
					<form method="POST" action="/30_my_test/validation-form/auth.php">
						<input class="form-control" placeholder="Введите логин" type="text" name="login">
						<br />
						<input class="form-control" placeholder="Введите пароль" type="password" name="pass">
						<br />
						<button class="btn btn-primary" type="submit">Войти в кабинет</button>
					</form>
				</div>
			</div> </div>
		</div></div>
	<?php
	}

	// Cookies
	if (@!$_COOKIE['user']) {
		reg();
	} else {
		echo "Вы, ".$_COOKIE['user']. ", уже вошли!<br \>"; 	?>
			<h3> Что бы выйти, нажмите <a href="/30_my_test/validation-form/exit/exit.php"><b>Выход</b></h3> 

</body>
</html>