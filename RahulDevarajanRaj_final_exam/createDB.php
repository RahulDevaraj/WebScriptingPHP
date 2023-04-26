<?php
//Rahul Devarajan Raj (300342528)

try{
        $db = new PDO("mysql:host=localhost", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}


catch(PDOException $e){
    print "<p style='color:red'>Error in connection:".$e->getMessage()." </p>\n";
}

try{
            $sql = "CREATE DATABASE IF NOT EXISTS productsDB;
                            USE productsDB;
                            CREATE TABLE IF NOT EXISTS product (
                                product_id INT PRIMARY KEY,
                                product_name VARCHAR(20),
                                price FLOAT
                            );";
        $db->exec($sql); }
catch(PDOException $e){
    print "<p style='color:red'>Error in creating Database:".$e->getMessage()." </p>\n";
}

 print "<p style='color:green'>Database Creation Successful. </p>\n";