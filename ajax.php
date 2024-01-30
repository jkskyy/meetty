<?php
 session_start();
 require('baza.php');
 $trybik = 'ZAKOŃCZONA';
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 if(isset($_COOKIE['trybik']))
 {
   $trybik = $_COOKIE['trybik'];
  $rez = $polacz->query("SELECT parties.*, users.username, users.id FROM parties, users WHERE users.id=parties.uid AND trybik='$trybik' ORDER BY startdate ASC");
 }
 else
 {
  $rez = $polacz->query("SELECT parties.*, users.username, users.id FROM parties, users WHERE users.id=parties.uid AND trybik!='$trybik' ORDER BY startdate ASC");
 }
 $rez2 = $polacz->query('SELECT MAX(pid) AS maxpid FROM parties WHERE trybik!="ZAKOŃCZONA"');
 $rez3 = $polacz->query('SELECT COUNT(pid) AS countpid FROM parties WHERE trybik!="ZAKOŃCZONA"');
 $row2 = $rez2->fetch_assoc();
 $maxpid = $row2['maxpid'];
 $row3 = $rez3->fetch_assoc();
 $countpid = $row3['countpid'];
 $i = 0;
 echo '[';
 while ($row=$rez->fetch_assoc())
  {
    $i++;
      if($i<$countpid)
      {
    echo '{
      "countpid":'.$row3['countpid'].',
      "pid":'.$row['pid'].',
      "uid":'.$row['uid'].',
      "trybik": "'.$row['trybik'].'",
      "username": "'.$row['username'].'",
      "startdate": "'.$row['startdate'].'",
      "starttime": "'.$row['starttime'].'",
      "startdate": "'.$row['startdate'].'",
      "partyname": "'.$row['partyname'].'"
    },
    ';
}
else
{
    echo '{
      "countpid":'.$row3['countpid'].',
        "pid":'.$row['pid'].',
        "uid":'.$row['uid'].',
        "trybik": "'.$row['trybik'].'",
        "username": "'.$row['username'].'",
        "startdate": "'.$row['startdate'].'",
        "starttime": "'.$row['starttime'].'",
        "startdate": "'.$row['startdate'].'",
        "partyname": "'.$row['partyname'].'"
      }';  
}
  }
  echo ']';
 ?>