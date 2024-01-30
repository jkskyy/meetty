<?php
session_start();
require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$kod = $_GET['code'];
$rez = $polacz->query("SELECT * FROM users WHERE verify_code='$kod'");
$hm = $rez->num_rows;
  if($hm>0)
  {
	$wiersz = $rez->fetch_assoc();
	$id = $wiersz['id'];
                 $username = $wiersz['username'];
                 $email = $wiersz['email'];
                 $gender = $wiersz['gender'];
                 $age = $wiersz['age'];
				 $acc_verify = $wiersz['acc_verify'];
				 $birthdate = $wiersz['birthdate'];
				 $joindate = $wiersz['joindate'];
				 $lastlogin = $wiersz['lastlogin'];
				 $city = $wiersz['city'];
				 $region = $wiersz['region'];
				 $rating = $wiersz['rating'];
				 $profilepic = $wiersz['profilepic'];
				 $rating_count = $wiersz['rating_count'];
  }
  else
  {
	  header("Location: /");
  }
  $rez2 = $polacz->query("SELECT * FROM emailchange WHERE code='$kod'");
  $hm2 = $rez2->num_rows;
  if($hm2>0)
  {
    $row = $rez2->fetch_assoc();
    $eid = $row['id'];
    $userid = $row['uid'];
    $emailnew = $row['emailnew'];
    $emailold = $row['emailold'];
    $code = $row['code'];
  }
  else
  {
    header("Location: /");
  }
  $rez3 = $polacz->query("UPDATE users SET email='$emailnew' WHERE verify_code='$kod'");
  $rez4 = $polacz->query("DELETE FROM emailchange WHERE uid='$userid' AND code='$kod'");
  if(isset($_SESSION['zalogowany']))
  {
      header("Location: profil/".$userid."");
  }
  else
  {
      header("Location: /");
  }
?>