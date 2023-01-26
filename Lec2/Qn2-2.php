<?php
$cost_ham=4.95;
$cost_milk=1.95;
$cost_cola=0.85;
$taxrate = 0.075;
$tiprate = 0.16;

$cost = ($cost_ham*2+$cost_milk+$cost_cola);
print "Total Cost is ".(($cost*(1+$taxrate))+$cost*$tiprate);

?>