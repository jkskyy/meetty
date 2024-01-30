<?php
session_start();
$userid=$_SESSION['id'];
require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 $rez = @$polacz->query("SELECT * FROM users WHERE id='$userid'");
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
         $kod = $wiersz['verify_code'];
  }
   if(!empty($_POST['profilename2']))
   {
   $nicknew = $_POST['profilename2'];
   }
   if(!empty($_POST['city2']))
   {
   $citynew = $_POST['city2'];
   }
   if(!empty($_POST['brdate2']))
   {
   $brnew = $_POST['brdate2'];
   }
   if(!empty($_POST['email2']))
   {
   $emailnew = $_POST['email2'];
   }
   if((!empty($_POST['city2'])) && (!empty($_POST['brdate2'])) && (!empty($_POST['email2'])) && (!empty($_POST['profilename2'])))
   {
     header("Location: profil/".$_SESSION['id']."");
   }
 if(isset($emailnew))
 {
 if($email!=$emailnew)
 {
   $emailnewB = filter_var($emailnew, FILTER_SANITIZE_EMAIL);
   if (filter_var($emailnewB, FILTER_VALIDATE_EMAIL)==true)
   {
       $link='http://www.meetty.5v.pl/email-zmiana?code='.$kod.'';
  $tytul="Zmiana adresu E-Mail w serwisie Meetty";
  $tresc1="Z twojego konta została wysłana prośba o zmianę adresu email. Jeżeli chcesz zmienić adres email na - ".$emailnewB." kliknij w link poniżej.
  
  ";
  $tresc2="
  
  Jeżeli jednak nie ty zażądałeś zmiany adresu email niezwłocznie zmień hasło dostępu do konta i skontaktuj się z działem pomocy!";
  $headers = 'From: Meetty <Meetty@meetty.5v.pl>'."\r\n";
  $tresc3=$tresc1.$link;
  $tresc5=$tresc3.$tresc2;
  mail($email,$tytul,$tresc5,$headers);
  $rez1 = $polacz->query("INSERT INTO emailchange VALUES(NULL, '$userid', '$emailnewB', '$email', '$kod')");
       header("Location: profil/".$_SESSION['id']."");
   }
 }
 else
 {
   header("Location: profil/".$_SESSION['id']."");
 }
}
 if(isset($brnew))
 {
 if($birthdate!=$brnew)
 {
   $agedateform=$brnew;
   $agedateformtimestamp=strtotime($agedateform);
   $agedate=time()-$agedateformtimestamp;
   $agenew=$agedate/(60*60*24*365);
   $agenew=floor($agenew);
   if($agenew>=16 && $agenew<=99)
   {
       $rez2 = $polacz->query("UPDATE users SET age='$agenew', birthdate='$agedateform' WHERE id='$userid'");
       header("Location: profil/".$_SESSION['id']."");
   }
   else
   {
       header("Location: profil/".$_SESSION['id']."");
   }
 }
}
 if(isset($citynew))
 {
 if($city!=$citynew)
 {
       preg_replace('/[^A-Za-z0-9\-]/', '', $citynew);
       $rez3 = $polacz->query("UPDATE users SET city='$citynew' WHERE id='$userid'");
       header("Location: profil/".$_SESSION['id']."");
 }
 else
 {
   header("Location: profil/".$_SESSION['id']."");
 }
}
 if(isset($nicknew))
 {
 if($username!=$nicknew)
 {
       preg_replace('/[^A-Za-z0-9\-]/', '', $nicknew);
       $rez4 = $polacz->query("UPDATE users SET username='$nicknew' WHERE id='$userid'");
       header("Location: profil/".$_SESSION['id']."");
 }
 else
 {
   header("Location: profil/".$_SESSION['id']."");
 }
}
?>