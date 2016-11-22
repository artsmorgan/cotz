<?php 
	include_once('../utils/genericReader.php');
	$invPath = 'inv.txt';
	$csv = new GenericReader();
	$c = $csv->process($invPath);
	
	// echo '<pre>';
	// print_r($c);
	// echo '</pre>';

	// $string="こんにちは";
	// echo "ENCODING: " . mb_detect_encoding($string) . "\n";
	// $encoded = json_encode($string);
	// echo "ENCODED JSON: $encoded\n";
	// $decoded = json_decode($encoded);
	// echo "DECODED JSON: $decoded\n";

	echo json_encode($c, JSON_UNESCAPED_UNICODE);