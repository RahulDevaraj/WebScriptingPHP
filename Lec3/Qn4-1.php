<?php

$population = array("NY"=>array("New York"=> 8008278),
"CA"=>array("Los Angeles"=>379621,"San Diego"=>1307407),
"IL"=>array("Chicago"=>2695598)
);

$population2 =[
    ["NY", "New York", 8008278],
    ["CA", "Los Angeles", 379621],
    ["IL", "Chicago", 2695598]
];

$population3 =array(
    ["NY", "New York", 8008278],
    ["CA", "Los Angeles", 379621],
    ["IL", "Chicago", 2695598]
);

// echo $population["CA"]["Los Angeles"];
// echo "\n";
// echo $population2[1][2];
// echo "\n";
// echo $population3[1][2];

foreach ($population as $state => $city) {

    foreach ($city as $cname => $pop) {
        // echo $cname." ".$pop;
        printf("%s %s %d",$state,$cname,$pop);
        echo "\n";
    }
}

?>