<?php
// Rahul Devarajan Raj
function display_HTML_header($title = '') {
    #write a here document
    print <<<EOT
    <!DOCTYPE html>
    <html>
    <head>
    <title>{$title}</title>
    <link rel="stylesheet" href="style.css" />
  </head>
    <body>
  EOT;
}

function validate_form() {
  $errors = array();
  
  // Validate PID
  $pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT);
  if (!$pid || $pid < 1) {
    $errors[0] = "PID must be a positive integer.";
  } else {
    $_SESSION['PID'] = $pid;
  }
  
  // Validate Name
  if (empty($_POST['name'])) {
    $errors[1] = "Name cannot be empty.";
  } else {
    $_SESSION['Name'] = $_POST['name'];
  }
  
  // Validate Team Names
  $valid_teams = array('U10', 'U11', 'U12');
  if (!in_array($_POST['teams'], $valid_teams)) {
    $errors[2] = "Team Name is not valid.";
  } else {
    $_SESSION['Team Name'] = $_POST['teams'];
  }
  
  // Validate Gender
  if (isset($_POST['gender']))
  {
  $valid_genders = array('F', 'M', 'X');
  if (!in_array($_POST['gender'], $valid_genders)) {
    $errors[3] = "Gender is not valid.";
  } else {
    $_SESSION['Gender'] =$_POST['gender'];
  }
  }
  else{
     $errors[3] = "A Selection for Gender is required";
  }
 

  
  // Validate Favorite Sports
  if (isset($_POST['sports'])) {
    foreach ($_POST['sports'] as $sport) {
      if (!in_array($sport, array('sc', 'ts', 'sw', 'bb'))) {
        $errors[4] = "Favorite Sports are not valid.";
        break;
      }
    }
    $_SESSION['Favorite Sports'] = $_POST['sports'];
  }
  else{
    $errors[4] = "A Selection for Favorite Sports is required";
  }

  return $errors;
}

function display_form($errors=[])
{
   print "<form method='POST' action='$_SERVER[PHP_SELF]'>
<label>PID</label><input type='number' name='pid' value='" . ($_SESSION['PID'] ?? '') . "'/>";
if (isset($errors[0])) {
print "<span class='err'>$errors[0]</span>";
}

print "<br/><label>Name</label><input type='text' name='name' value='" . ($_SESSION['Name'] ?? '') . "'/>";

    if (isset($errors[1])) {
        print "<span class='err'>$errors[1]</span>";
    }

  print "</br><label>Team Name</label>
            <select name='teams'>";
    $teams = array('U10', 'U11', 'U12');
    foreach ($teams as $team) {
        $selected = '';
        if (isset($_SESSION['Team Name']) && $_SESSION['Team Name'] == $team) {
            $selected = 'selected';
        }
        print "<option value='$team' $selected>$team</option>";
    }
    print "</select>";
    if (isset($errors[2])) {
        print "<span class='err'>$errors[2]</span><br/>";
    }

    
    print "<br/><label>Gender</label>";
    if (isset($errors[3])) {
        print "<span class='err'>$errors[3]</span><br/>";
    }
    else
    print "<br/>";
      print "<input type='radio' name='gender' value='M'" . (isset($_SESSION['Gender']) && $_SESSION['Gender'] == 'M' ? 'checked' : '') . ">Male <br/>
      <input type='radio' name='gender' value='F'" . (isset($_SESSION['Gender']) && $_SESSION['Gender'] == 'F' ? 'checked' : '') . ">Female <br/>
      <input type='radio' name='gender' value='X'" . (isset($_SESSION['Gender']) && $_SESSION['Gender'] == 'X' ? 'checked' : '') . ">Other <br/>" ;
    

    print "<label>Favorite Sports</label>";
     if (isset($errors[4])) {
        print "<span class='err'>$errors[4]</span><br/>";
    }
    else
    print "<br/>";
           print "<input type='checkbox' name='sports[]' value='sc'" . (isset($_SESSION['Favorite Sports']) && in_array('sc', $_SESSION['Favorite Sports']) ? 'checked' : '') . "><label>Soccer</label></br>
            <input type='checkbox' name='sports[]' value='ts'" . (isset($_SESSION['Favorite Sports']) && in_array('ts', $_SESSION['Favorite Sports']) ? 'checked' : '') . "><label>Tennis</label></br>
            <input type='checkbox' name='sports[]' value='sw'" . (isset($_SESSION['Favorite Sports']) && in_array('sw', $_SESSION['Favorite Sports']) ? 'checked' : '') . "><label>Swimming</label></br>
            <input type='checkbox' name='sports[]' value='bb'" . (isset($_SESSION['Favorite Sports']) && in_array('bb', $_SESSION['Favorite Sports']) ? 'checked' : '') . "><label>Basketball</label></br>";
   

    print "<input type='submit' name='submit' value='Submit'/>
        </form>";

}

function confirm_form() {
  
  foreach ($_SESSION as $key => $value) {
    if (is_array($value)) {
      $value = implode(", ", $value);
    }
    print "<p><strong>$key:</strong> $value</p>";
  }
  
  print "<form method='POST' action='$_SERVER[PHP_SELF]'>
        <input type='submit' name='submit' value='Confirm'/>
        <input type='submit' name='submit' value='Edit'/>
        </form>";
}

function process_form() {
    try {
        $conn = new PDO("mysql:host=localhost", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $sql = "CREATE DATABASE IF NOT EXISTS players_db;
                            USE players_db;
                            CREATE TABLE IF NOT EXISTS Player (
                                PID INT PRIMARY KEY,
                                PName VARCHAR(20),
                                TeamName CHAR(3),
                                Gender CHAR(1)
                            );
                            CREATE TABLE IF NOT EXISTS Player_FavSports (
                                PID INT,
                                FavSport CHAR(2),
                                PRIMARY KEY(PID, FavSport),
                                FOREIGN KEY(PID) REFERENCES Player(PID)
                            );";
        $conn->exec($sql);

        try {
              $insert = "INSERT INTO players_db.Player VALUES (?,?,?,?);";
              $stmt = $conn->prepare($insert);
              $stmt->execute(array($_SESSION['PID'], $_SESSION['Name'], $_SESSION['Team Name'], $_SESSION['Gender']));
              foreach ($_SESSION['Favorite Sports'] as $sport) {
              $insert = "INSERT INTO players_db.Player_FavSports VALUES (?,?);";
              $stmt = $conn->prepare($insert);
              $stmt->execute(array($_SESSION['PID'], $sport));
              }
              echo "<p style='color:green'>Data Inserted Successfully.</p>";
              } catch (PDOException $e) {
              echo "<p class='err'>Error: " . $e->getMessage() . "</p>";
              }
        }catch (PDOException $e) {
echo "<p class='err'>Error: " . $e->getMessage() . "</p>";
}

        } catch (PDOException $e) {
        echo "<p class='err'>Error: " . $e->getMessage() . "</p>";
    }
     

        
    
}

function display_HTML_footer() {
  print "</body></html>";
}