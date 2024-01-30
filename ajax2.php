<?php
 session_start();
 require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 $rez = $polacz->query('SELECT MAX(pid) AS maxpid FROM parties WHERE trybik!="ZAKOŃCZONA"');
 echo '[';
 while ($wiersz=$rez->fetch_assoc())
  {
      echo '{
        "maxpid":'.$wiersz['maxpid'].',
      }';
  }
  echo ']';
 ?>