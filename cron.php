<?php
date_default_timezone_set('Europe/Warsaw');
require('baza.php');
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$date = date('Y-m-d');
$time = date('H:i:s');
$rez = $polacz->query("SELECT * FROM parties");
while ($row = $rez->fetch_assoc())
{
$time1hstamp = strtotime($time) + 60*60;
$time1h = date('H:i:s', $time1hstamp);
$datesql = $row['startdate'];
$timesql = $row['starttime'];
$timesql1hstamp = strtotime($timesql) - 60*60;
$timesql1h = date('H:i:s', $timesql1hstamp);
$id = $row['pid'];
    if (($date<$datesql) || ($date==$datesql && $time1h<$timesql && $time<$timesql))
{
    $polacz->query("UPDATE parties SET trybik='ZAPLANOWANA' WHERE pid='$id'");
}
else if ($date==$datesql && $time>=$timesql1h && $time<$timesql)
{
    $polacz->query("UPDATE parties SET trybik='STARTUJE' WHERE pid='$id'");
}
else if ($date==$datesql && $time>=$timesql)
{
    $polacz->query("UPDATE parties SET trybik='TRWA' WHERE pid='$id'");
}
else if ($date>$datesql)
{
    $polacz->query("UPDATE parties SET trybik='ZAKOŃCZONA' WHERE pid='$id'");
}
}
$polacz->close();
?>