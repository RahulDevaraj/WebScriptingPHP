<?php
$population = array("NY"=>array("New York"=> 8008278),
"CA"=>array("Los Angeles"=>379621,"San Diego"=>1307407),
"IL"=>array("Chicago"=>2695598)
);
//Print a table of locations and population information that includes the total population in all 10 cities.
//The table should have the following columns: State, City, Population

foreach ($population as $state => $city) {

    foreach ($city as $cname => $pop) {
        // echo $cname." ".$pop;
        printf("%s %s %d",$state,$cname,$pop);
        echo "\n";
    }
}
//sort the table by population in descending order




?>