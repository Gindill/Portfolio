<?php
	$to      = 'nobody@example.com';
	$subject = 'Заявка на расчет ремонта';
	$message = '';
	$headers = 'From: webmaster@example.com' . "\r\n" .
	    'Reply-To: webmaster@example.com' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion() . "\r\n" .
		"Content-type: text/html; charset=utf-8" . "\r\n";

	$cost = 0;
	$area = $_POST['floor-range'];

	$message .= 'Тип ремонта: ';
	switch ($_POST['repair']) {
		case '0':
			$cost = 1680;
			$message .= "косметический<br>";
			break;
		case '1':
			$cost = 1800;
			$message .= "комплексный<br>";
			break;
		case '2':
			$cost = 4300;
			$message .= "капитальный<br>";
			break;
		case '3':
			$cost = 6000;
			$message .= "евроремонт<br>";
			break;
		default:
			$cost = 0;
			$message .= "?<br>";
			break;
	}

	$cost *= $area;

	$message .= 'Объект: ';
	switch ($_POST['flat']) {
		case '0':
			$message .= "студия<br>";
			break;
		case '1':
			$cost *= 0.99;
			$message .= "1-но комнатная квартира <br>";
			break;
		case '2':
			$cost *= 0.97;
			$message .= "2-х комнатная квартира <br>";
			break;
		case '3':
			$cost *= 0.95;
			$message .= "3-х комнатная квартира <br>";
			break;
		case '4':
			$cost *= 0.93;
			$message .= "4-х комнатная квартира <br>";
			break;
		case '5':
			$cost *= 0.93;
			$message .= "Таунхаус <br>";
			break;
		case '6':
			$cost *= 0.93;
			$message .= "Коттедж <br>";
			break;
		default:
			$cost = 0;
			$message .= "?<br>";
			break;
	}

	$message .= 'Площадь: ' . $area . "<br>";

	$message .= 'Потолок: ';
	switch ($_POST['ceiling']) {
		case '0':
			$message .= "покраска<br>";
			break;
		case '1':
			$cost += 180 * $area;
			$message .= "натяжной<br>";
			break;
		case '2':
			$cost += 220 * $area;
			$message .= "гипсокартон<br>";
			break;
		default:
			$cost = 0;
			$message .= "?<br>";
			break;
	}

	$message .= 'Стены: ';
	switch ($_POST['walls']) {
		case '0':
			$message .= "покраска<br>";
			break;
		case '1':
			$cost += 90 * $area;
			$message .= "обои<br>";
			break;
		default:
			$cost = 0;
			$message .= "?<br>";
			break;
	}

	$message .= 'Пол: ';
	switch ($_POST['flooring']) {
		case '0':
			$message .= "линолеум<br>";
			break;
		case '1':
			$cost += 110 * $area;
			$message .= "ламинат<br>";
			break;
		case '2':
			$cost += 180 * $area;
			$message .= "паркетная доска<br>";
			break;
		case '3':
			$cost += 250 * $area;
			$message .= "штучный паркет<br>";
			break;
		case '4':
			$cost += 270 * $area;
			$message .= "плитка<br>";
			break;
		default:
			$cost = 0;
			$message .= "?<br>";
			break;
	}

	$message .= 'Дополнительно: ';
	if($_POST["plumbing"]) {
		$cost += 9980;
		$message .= "сантехника ";
	}
	if($_POST["electric"]) {
		$cost += 14980;
		$message .= "электрика ";
	}
	if($_POST["ventilation"]) {
		$cost += 9980;
		$message .= "вентиляция ";
	}
	if($_POST["heating"]) {
		$cost += 4980;
		$message .= "отопление";
	}

	$message .= "<br>";
	$message .= 'Имя: ' . $_POST['name'] . "<br>";
	$message .= 'Телефон: ' . $_POST['phone'] . "<br>";
	$message .= 'Стоимость: ' . $cost . "<br>";

	mail($to, $subject, $message, $headers);
?>
