<?php
# declare variables
$titel = $regissorer = $producenter = $genrer = $ar = "";
$result = "Success";
$pris = $langd = 0;

$db_host = 'localhost';
$db_database = 'webbutik_filmer';
$db_username = 'root';
$db_password = '';

# open a connection to the DB
$mysqli = new mysqli($db_host, $db_username, '', $db_database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  # get all the values from the form
  $titel = $_POST["titel"];
  $pris = $_POST["pris"];
  $langd = $_POST["langd"];
  $regissorer = $_POST["regissorer"];
  $regissorArray = explode(", ", $regissorer);
  $producenter = $_POST["producenter"];
  $producentArray = explode(", ", $producenter);
  $genrer = $_POST["genrer"];
  $genreArray = explode(", ", $genrer);
  $ar = $_POST["ar"];

  # add the movie to the table filmer
  $insert_film = "CALL insert_film('$titel', '$langd', '$pris', '$ar')";
  if ($mysqli->query($insert_film) === TRUE) {

    # get the id of the movie we just added
    $get_filmID = "CALL get_filmID('$titel', '$langd', '$pris')";
    $filmID = $mysqli->query($get_filmID); # no error handling... hehe

    foreach ($producentArray as $key) {
      # separate the surname and lastname(s)
      $key = explode(" ", $key);
      if (isset($key[2])) $key[1] = $key[1] . " " . $key[2]; # if the producer has 2 lastnames, concentate them

      # this procedure checks if the producer exists in the table Producenter
      # if it does, return the ID
      # else it adds it to the table and then returns the ID
      $get_producent = "CALL get_producent('$key[0]', '$key[1]')";
      $producentID = $mysqli->query($get_producent);
      if (!$mysqli->error && $res = $mysqli->store_result()) {
        # add the producent to the table Filmproducenter, which links movies and producers
        $rows = $res->fetch_row();
        $add_filmproducent = "CALL insert_filmproducent('$filmID', '$rows[0]')";
        if ($mysqli->query($add_filmproducent) === TRUE) {
        } else {
          $result = "Error: " . $mysqli->error;
        }
        $res->free();
      } else {
        $result = "Error: " . $mysqli->error != "" ? "store_result returned false" : $mysqli->error;
        break;
      }
    }

    /*foreach ($regissorArray as $key) {
      # separate the surname and lastname(s)
      $key = explode(" ", $key);
      if (isset($key[2])) $key[1] = $key[1] . " " . $key[2]; # if the director has 2 lastnames, concentate them

      # this procedure checks if the director exists in the table Regissorer
      # if it does, return the ID
      # else it adds it to the table and then returns the ID
      $get_regissor = "CALL get_regissor('$key[0]', '$key[1]')";
      $regissorID = $mysqli->query($get_regissor); # no error handling here either...

      # add the director to the table Filmregissorer, which links movies and directors
      $add_filmregissor = "CALL insert_regissor('$filmID', '$regissorID')";
      if ($mysqli->query($add_regissor) != TRUE) {
        $result = "Error: " . $mysqli->error
      }
    }

    foreach ($genreArray as $key) {
      # this procedure checks if the genre exists in the table Genrer
      # if it does, return the ID
      # else it adds it to the table and then returns the ID
      $get_genre = "CALL get_genre('$key[0]')";
      $genreID = $mysqli->query($get_genre); # no error handling here either...

      # add the genre to the table Filmgenrer, which links movies and directors
      $add_filmgenre = "CALL insert_filmgenre('$filmID', '$genreID')";
      if ($mysqli->query($add_filmgenre) != TRUE) {
        $result = "Error: " . $mysqli->error
      }
    }*/
  } else {
    # if there was an error, store the error msg in a variable and stop further execution
    $result = "Error: " . $mysqli->error;
  }
}

# function to clear the input from any unwanted characters (another safety measure)
function sanitizeInput($input) {
  $input = htmlentities($input);
  $input = strip_tags($input);
  return $input;
}

# close the db connection
$mysqli->close();

# if there werent any errors redirect back to the form
# otherwise print the error
if ($result == "Success") {
  sleep(2);
  header("Location: ../index.php");
} else {
  echo $result;
}
?>
