<?php
//Rahul Devarajan Raj (300342528)
session_start();
display_HTML_header('Product Registration Form');

if("POST"==$_SERVER['REQUEST_METHOD']){
    if($_POST['submit']=="Register"){
        $errors = validate_form();

        if(count($errors)>0){
            display_form($errors);
        }
        else
        {

            $details = $_SESSION['pData'];
            try{
                $db= new PDO("mysql:host=localhost;dbname=productsDB", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                print "<p style='color:red'>Error in connection:".$e->getMessage()." </p>\n";
            }

            try{
                $sql = "INSERT INTO product VALUES(?,?,?);";
                $stmt = $db->prepare($sql);
                $stmt->execute(array($details['ProductID'],$details['ProductName'],$details['Price']));

                 print "<p style='color:green'>".$details['ProductName']." with productID ".$details['ProductID']." registered. </p></br>";
            print "<a href='register.php'><ul><< Register More</ul></a>";
            }
            catch(PDOException $e){
                print "<p style='color:red'>Error in creating Database:".$e->getMessage()." </p></br>";
                print "<a href='register.php'><ul><< Go to Form</ul></a>";
            }            
        }        
    }

}
else
{
    display_form();
    session_unset();
}

display_footer();







function display_HTML_header($title = '') {
    print <<<EOT
    <!DOCTYPE html>
    <html>
    <head>
    <title>{$title}</title>
     </head>
    <body>
  EOT;
}

function display_form($errors=[])

{

    if(count($errors)>0){
        print "Validation Errors : </br><ul>";
        foreach($errors as $err){
            print "<li>$err</li>";
        }
        print "</ul>";
    }
    
   print <<<HERE
        <h1>Product Registration Form</h1>
        <form method='POST' action='$_SERVER[PHP_SELF]'>
        <label>Product ID:</label>
        <input type='number' name='ProductID' /> <br /><br />
        <label>Product Name:</label>
        <input type='text' name='ProductName' /> <br /><br />
        <label>Price: </label>
        <input type='number' name='Price' /> <br /><br />
        <input type='submit' name='submit' value='Register'/>
        </form>
        HERE;

    print_table();

}

function validate_form(){
    $errors = [];
    $productData=[];

    //validate Product Id
    
    $pid = filter_input(INPUT_POST, 'ProductID', FILTER_VALIDATE_INT);
//     if ($pid===false) {
//     $errors[0] = "PID must be an integer.".strlen($_POST['ProductID']);
//   } 
//   else
if ($_POST['ProductID']<1){
    $errors[0] = "PID must be a positive integer.";
  }
  else
   if(strlen($_POST['ProductID'])<5){
    $errors[0] = "PID must be at least 5 digits long.";
  }
  else {
    $productData['ProductID'] = $_POST['ProductID'];
  }

  //2nd val  
  $pname = $_POST['ProductName']; 
  if(strlen(trim($pname))<2){
    $errors[1] = "Product Name must be at least 2 characters long.";
  }
  else{
    $productData['ProductName'] = $pname;
  }

  //3rd val
  $price = filter_input(INPUT_POST, 'Price', FILTER_VALIDATE_FLOAT);
    if ($price===false || $price < 1) {
        $errors[2] = "Price must be a positive number.";
    } 
    else if($price>=10000){
        $errors[2] = "Price must be less than 10000.";
    }
    else {
        $productData['Price'] = $price;
    }

    $_SESSION['pData'] = $productData;


  return $errors;

}

function display_footer() {
    print <<<EOT
    </body>
    </html>
  EOT;
}

function print_table(){
     try{
                $db= new PDO("mysql:host=localhost;dbname=productsDB", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e){
                print "<p style='color:red'>Error in connection:".$e->getMessage()." </p>\n";
        }

    try{
                $sql = "SELECT * FROM product;";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($result)==0){
                    return;
                }
                print "<h2>Currently Stored Products</h2>";
                print "<table>";
                print "<tr><th>Product ID</th><th>Product Name</th><th>Price</th></tr>";
                foreach($result as $row){
                    print "<tr>";
                    foreach($row as $col){
                        print "<td>$col</td>";
                    }
                    print "</tr>";
                }
                print "</table>";
            }
            catch(PDOException $e){
                print "<p style='color:red'>Error in creating Database:".$e->getMessage()." </p></br>";
            }
}