<?php
session_start();
require('baza.php');
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$partyid=$_SESSION['partyid'];
$rez = @$polacz->query("SELECT pid FROM parties WHERE pid=$partyid");
$hm = $rez->num_rows;
  if($hm>0)
  {
	$wiersz = $rez->fetch_assoc();
	$pid = $wiersz['pid'];
  }
  $rez2 = $polacz->query("SELECT * FROM party_joined WHERE pid='$partyid'");
$hm2 = $rez2->num_rows;
if($hm2>0)
{
  $wiersz2 = $rez2->fetch_assoc();
  $joined = $wiersz2['joined'];
  $zapisani = explode(',', $joined);
}
if(isset($_POST['dolacz']))
    {
    $newarray = $zapisani;
    array_push($newarray, $_SESSION['id']);
    $newjoin = implode(',', $newarray);
    $polacz->query("UPDATE party_joined SET joined='$newjoin' WHERE pid='$partyid'");
    header("Location: impreza/".$partyid);
    }
if(isset($_POST['usun']))
  {
  $newarray = $zapisani;
  $newarray_length = sizeof($newarray);
  for($y=0; $y<$newarray_length; $y++)
  {
    if($_SESSION['id']===$newarray[$y])
    {
      unset($newarray[$y]);
      break;
    }
  }
  $newjoin = implode(',', $newarray);
  $polacz->query("UPDATE party_joined SET joined='$newjoin' WHERE pid='$partyid'");
  header("Location: impreza/".$partyid);
}
?>