<?php
session_start();
require_once "baza.php";
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

$file_formats = array("jpg", "png", "gif", "bmp");
$filepath = "uploads/";

  $name = $_FILES['file']['name'];
  $size = $_FILES['file']['size'];

   if (strlen($name)) {
      $extension = substr($name, strrpos($name, '.')+1);
      if (in_array($extension, $file_formats)) { 
          if ($size < (4096 * 1024)) {
            $username = $_SESSION['username'];
            $id = $_SESSION['id'];
            $tablica = explode(".",$name);
            $tablica1 = end($tablica);
            $imagename = $username."."."png";
             $tmp = $_FILES['file']['tmp_name'];
             if (move_uploaded_file($tmp, $filepath . $imagename)) {
		  
            $polacz->query("UPDATE users SET profilepic='$imagename' WHERE id='$id'");
     $_SESSION['profilepic'] = $imagename;
     echo $filepath.$imagename;
	     } else {
        $_SESSION['uploaderr'] = "Nie można przenieść plików.";
	     }
	  } else {
      $_SESSION['toobig'] = "Waga obrazka przekracza 2MB.";
	  }
       } else {
        $_SESSION['wrongtype'] = "Nieprawidłowy format pliku.";
       }
  } else {
       $_SESSION['nofile'] = "Nie wybrano pliku!";
  }
exit();

?>