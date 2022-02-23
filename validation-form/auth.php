<?php
require_once ('../head.php');
require_once ('check.php');

		$r = new check();
		$r->db_auth();

	?>


	<div class="container-auth">
		<form method="POST" action="calculate.php">
		<input class="form-control" placeholder="Сумма" type="text" name="sum">
		<br />
		<input class="form-control" placeholder="Ставка" type="text" name="tax">
		<br />
		<button class="btn btn-primary" type="submit">Расчитать</button>

		</form>
	</div>
<?php

	// $r->cookie();

/* Сколько раз посетил страницу
if (isset($_SESSION['count'])) {
$_SESSION['count'] = $_SESSION['count'] + 1;
} else {
$_SESSION['count'] = 1;
}
print "You've looked at this page " . $_SESSION['count'] . ' times.';
*/
