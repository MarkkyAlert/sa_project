<?php

$b = substr(date('Y-d-m'),8);
$c = number_format($b);
if ($c == 1) {
	$c = '02';
}
else if($c == 2) {
    $c = '03';
}
else if ($c == 3){
    $c = '04';
}
else if ($c == 4){
    $c = '05';
}
else if ($c == 5){
    $c = '06';
}
else if ($c == 6){
    $c = '07';
}
else if ($c == 7){
    $c = '08';
}
else if ($c == 8){
    $c = '09';
}
else if ($c == 9){
    $c = '10';
}
else if ($c == 10){
    $c = '11';
}
else if ($c == 11){
    $c = '12';
}
else if ($c == 12){
    $c = '01';
}


echo $c;
?>