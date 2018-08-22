<?php
	echo password_hash("123456", PASSWORD_DEFAULT);

	echo '<br>';
	echo date("Ymdhis") . '<br>';
	echo '<br>';
	$datetime1 = date_create('2009-01-01');
	$datetime2 = date_create(date('Ymd'));
	$interval = date_diff($datetime1, $datetime2);
	echo $interval->format('%R%a days');
	$age = intval(intval($interval->format('%a')) / 365);
	echo '<br>';
	echo $age;
?>
