<?php
$f=-50;

print "Fahrenheit\tCelsius\n";

for($f=-50;$f<=50;$f+=5){
$c=($f-32)*5/9;
//round to 2 decimal places
$c=round($c,2);
print "$f\t$c\n";
}

?>