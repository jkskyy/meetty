<?php
session_start();
if (isset($_SESSION['zalogowany']))
 {
	 header('Location: profil/'.$_SESSION['id']);
     exit();
 }
require('baza.php');
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$agedateform=$_POST['age'];
$agedateformtimestamp=strtotime($agedateform);
$gender=$_POST['gender'];
$agedate=time()-$agedateformtimestamp;
$age=$agedate/(60*60*24*365);
$age=floor($age);
$kod = uniqid();
$city=$_POST['city'];
$region=$_POST['region'];
if(isset($_POST['email']))
 {
	 $OK = true;
	 $OK2 = true;
	 $nick = $_POST['name'];
	 $nick = strtoupper($nick);
	 $opis = strip_tags($opis);
	 preg_replace('/[^A-Za-z0-9\-]/', '', $nick);
	 if((strlen($nick)<4) || (strlen($nick)>16))
	 {
		 $OK=false;
		 $OK2=false;
		 $_SESSION['e_nick']="<span style='color: #FF0000;'>Nazwa użytkownika musi posiadać od 4 do 16 znaków!</span>";
	 }
	 if (ctype_alnum($nick)==false)
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_nick1']="<span style='color: #FF0000;'>Nazwa użytkownika może się składać tylko ze znaków alfanumerycznych (bez znaków specjalnych)</span>";
	 }
	 if ($age<16)
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_age']="<span style='color: #FF0000;'>Konto w serwisie można założyć od 16 roku życia</span>";
	 }
	 if ($agedateform=="")
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_age1']="<span style='color: #FF0000;'>Musisz podać datę urodzenia</span>";
	 }
	 if (!isset($_POST['gender']))
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_gender']="<span style='color: #FF0000;'>Wybierz odpowiednią opcję!</span>";
	 }
	 if ($city=="" || $city==" ")
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_city']="<span style='color: #FF0000;'>Musisz podać miasto, w którym mieszkasz!</span>";
	 }
	 if (!isset($region) || $region=="Wybierz województwo...")
	 {
		$OK=false;
		$OK2=false;
		$_SESSION['e_region']="<span style='color: #FF0000;'>Musisz wybrać województwo, w którym mieszkasz!</span>";
	 } 
	 $haslo0=$_POST['password'];
	 if((strlen($haslo0)<8) || (strlen($haslo0)>32))
	 {
		 $OK=false;
		 $OK2=false;
		 $_SESSION['e_haslo']="<span style='color: #FF0000;'>Hasło powinno mieć od 8 do 32 znaków!</span>";
     }
     
	 $haslo_hash= password_hash($haslo0, PASSWORD_DEFAULT);
	 
	 $email=$_POST['email'];
	 
	 $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
	 if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || $emailB!=$email)
	 {
		 $OK=false;
		 $OK2=false;
		 $_SESSION['e_email']="<span style='color: #FF0000;'>Podaj poprawny adres e-mail</span>";
	 }
	 if(!isset($_POST['reg']))
	 {
		 $OK=false;
		 $OK2=false;
		 $_SESSION['e_chkbox']="<span style='color: #FF0000;'>Prosze zaakceptować regulamin!</span>";
	 }
	 mysqli_report(MYSQLI_REPORT_STRICT);
	 try
	 {
		 if ($polacz->connect_errno!=0)
	{
		throw new Exception(mysqli_connect_errno());
	}
	else
	{
		$rez = $polacz->query("SELECT id FROM users WHERE email='$email'");
		if(!$rez) throw new Exception($polacz->error);
		$hme=$rez->num_rows;
		if($hme>0)
		{
			$OK=false;
			$OK2=false;
			$_SESSION['e_email2']="<span style='color: #FF0000;'>Istnieje już konto z podanym adresem e-mail!</span>";
		}
		$rez1 = $polacz->query("SELECT id FROM users WHERE username='$nick'");
		if(!$rez1) throw new Exception($polacz->error);
		$hmn=$rez1->num_rows;
		if($hmn>0)
		{
			$OK=false;
			$OK2=false;
			$_SESSION['e_nick2']="<span style='color: #FF0000;'>Istnieje już konto o podanej nazwie!</span>";
		}
			 if ($OK==true)
		{
		$polacz->query("INSERT INTO users VALUES(NULL, '$nick', '$haslo_hash', '$emailB', '$gender', '$age', now(), '$agedateform', now(), '$city', '$region', 0, 0, 0, 0, '$kod', 'Niezweryfikowany', 0, 'no-profile-pic.jpg')");
		$_SESSION['good']=1;
		}
	}
	 }
	 catch(Exception $e)
	 {
		 echo '<span style="color:black;">Błąd serwera. Przepraszamy za niedogodności!</span>';
	 }
 }
 
	 if(($rez5 = $polacz->query("SELECT id FROM users WHERE email='$email'")) && ($rez6 = $polacz->query("SELECT id FROM users WHERE acc_verify='0'")));
	 {
		 $rez7 = $polacz->query("SELECT mail_sent FROM users WHERE email='$email' AND username='$nick'");
		 $hm3 = $rez7->num_rows;
		 if($hm3>0 && $hm3<2)
		 {
			 $row3 = $rez7->fetch_assoc();
			 $mail_sent=$row3['mail_sent'];
		 }
		 if($mail_sent==0 && $OK==true)
		 {
	 $link='http://www.meetty.5v.pl/weryfikacja?user='.$kod.'';
	 $tytul="Potwierdzenie rejestracji w serwisie Meetty";
	 $tresc1="Dziękujemy za rejestrację w naszym serwisie! Kliknij w link podany poniżej i by zweryfikować swoje konto!
	 Kod resetowania hasła: ".$kod."
	 ";
	 $tresc2="
	 
	 Mamy nadzieję że zostaniesz z nami na dłużej!";
	 $headers = 'From: Rejestracja Meetty'."\r\n";
	 $tresc3=$tresc1.$link;
	 $tresc5=$tresc3.$tresc2;
	 mail($email,$tytul,$tresc5,$headers);
	 $polacz->query("UPDATE users SET mail_sent=1 WHERE email='$email' AND username='$nick'");
		 }
	 $polacz->close();
	 }
	
	 if($_SESSION['good']==1)
	 {
		 unset($_SESSION['good']);
		 $_SESSION['regok'] = '<span style="color: #00FF00;">Pomyślnie zarejestrowano! Sprawdź swoją skrzynke pocztową, zajrzyj też do folderu SPAM.</span>';
		header("Location: logowanie");
		exit;
	 }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="title" content="Rejestracja - Meetty">
	<meta name="description" content="Strona rejestracji konta w serwisie Meetty">
	<meta name="keywords" content="Meetty">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf8">
	<meta name="language" content="Polish">
	<meta name="author" content="Jarosław Kulig">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fontello.css">
	<link rel="icon" href="img/meettylogo.png" type="image/png" sizes="16x16">
	<script src="js/jquery-3.6.0.min.js"></script>
	<title>Rejestracja - Meetty</title>
	<script src="navfoo.js"></script>
</head>

<body>
	<div id="nav" class="sticky-top"></div>
	<div id="loader-wrapper">
		<div class="load">
			<object type="image/svg+xml" data="img/mm.svg"></object>
		</div>
	</div>
	<main>
		<div class="d-flex justify-content-center align-items-center container cwhite my-5">
			<div class="card login-form">
				<div class="card-header bg-dark">
					<h1>Rejestracja</h1>
				</div>
				<div class="card-body bg-secondary">
					<form action="rejestracja" method="POST">
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-user"></i></span>
							</div>
							<input type="text" name="name" class="form-control" placeholder="Nazwa...">
							<span class="help-block">Nazwa konta powinna posiadać od 4 do 16 znaków, bez użycia znaków
								specjalnych!<br></span>
							<?php if(isset($_SESSION['e_nick'])) echo $_SESSION['e_nick']."<br>"; ?>
							<?php if(isset($_SESSION['e_nick1'])) echo $_SESSION['e_nick1']."<br>"; ?>
							<?php if(isset($_SESSION['e_nick2'])) echo $_SESSION['e_nick2']."<br>"; ?>
							<?php unset($_SESSION['e_nick']); ?>
							<?php unset($_SESSION['e_nick1']); ?>
							<?php unset($_SESSION['e_nick2']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-mail-alt"></i></span>
							</div>
							<input type="email" name="email" class="form-control" placeholder="Email...">
							<span class="help-block">Podaj email do którego masz dostęp tylko ty, dodatkowo email nie
								powinien zawierać znaków diakrytycznych!<br></span>
							<?php if(isset($_SESSION['e_email'])) echo $_SESSION['e_email']."<br>"; ?>
							<?php if(isset($_SESSION['e_email2'])) echo $_SESSION['e_email2']."<br>"; ?>
							<?php unset($_SESSION['e_email']); ?>
							<?php unset($_SESSION['e_email2']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-lock"></i></span>
							</div>
							<input type="password" name="password" class="form-control" placeholder="Hasło...">
							<span class="help-block">Hasło powinno mieć co najmniej 8 znaków, nie więcej niż 32 znaki i
								nie powinno zawierać znaków diakrytycznych!<br></span>
							<?php if(isset($_SESSION['e_haslo'])) echo $_SESSION['e_haslo']."<br>"; ?>
							<?php unset($_SESSION['e_haslo']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-calendar"></i></span>
							</div>
							<input type="date" name="age" class="form-control" placeholder="Data urodzenia...">
							<span class="help-block">Aby posiadać konto użytkownika serwisu wymagane jest ukończenie 16
								roku życia!<br></span>
							<?php if(isset($_SESSION['e_age'])) echo $_SESSION['e_age']."<br>"; ?>
							<?php unset($_SESSION['e_age']); ?>
							<?php if(isset($_SESSION['e_age1'])) echo $_SESSION['e_age1']."<br>"; ?>
							<?php unset($_SESSION['e_age1']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-map"></i></span>
							</div>
							<select name="region" class="form-control">
								<option selected>Wybierz województwo...</option>
								<option>Dolnośląskie</option>
								<option>Kujawsko-Pomorskie</option>
								<option>Lubelskie</option>
								<option>Lubuskie</option>
								<option>Łódzkie</option>
								<option>Małopolskie</option>
								<option>Mazowieckie</option>
								<option>Opolskie</option>
								<option>Podkarpackie</option>
								<option>Podlaskie</option>
								<option>Pomorskie</option>
								<option>Śląskie</option>
								<option>Świętokrzyskie</option>
								<option>Warmińsko-Mazurskie</option>
								<option>Wielkopolskie</option>
								<option>Zachodniopomorskie</option>
							</select>
							<span class="help-block">Aby posiadać konto użytkownika serwisu musisz podać region kraju, w
								który mieszkasz!<br></span>
							<?php if(isset($_SESSION['e_region'])) echo $_SESSION['e_region']."<br>"; ?>
							<?php unset($_SESSION['e_region']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-map-signs"></i></span>
							</div>

							<input type="text" name="city" class="form-control" placeholder="Miasto...">
							<span class="help-block">Aby posiadać konto użytkownika serwisu wymagane jest podanie miasta
								zamieszkania!<br></span>
							<?php if(isset($_SESSION['e_city'])) echo $_SESSION['e_city']."<br>"; ?>
							<?php unset($_SESSION['e_city']); ?>
						</div>
						<div class="input-group form-group">
							<label>Płeć</label>
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-4">
										<label class="radio-inline">
											<input type="radio" id="femaleRadio" value="Kobieta" name="gender"><i
												class="demo-icon icon-female"></i> Kobieta
										</label>
									</div>
									<div class="col-sm-4">
										<label class="radio-inline">
											<input type="radio" id="maleRadio" value="Mężczyzna" name="gender"><i
												class="demo-icon icon-male"></i> Mężczyzna
										</label>
									</div>
									<div class="col-sm-4">
										<label class="radio-inline">
											<input type="radio" id="uncknownRadio" value="Ukryta" name="gender"><i
												class="demo-icon icon-user-secret"></i> Ukryta
										</label>
									</div>
								</div>
								<?php if(isset($_SESSION['e_gender'])) echo $_SESSION['e_gender']."<br>"; ?>
								<?php unset($_SESSION['e_gender']); ?>
							</div>
						</div>
						<div class="input-group form-group">
							<div class="col-sm-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="reg"> Akceptuję <a class="linkprp"
											href="#">regulamin<br></a>
										<?php if(isset($_SESSION['e_chkbox'])) echo $_SESSION['e_chkbox']."<br>"; ?>
										<?php unset($_SESSION['e_chkbox']); ?>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" value="Zarejestruj" class="btn float-right btn-dark btn-sm kartabtn">
						</div>
					</form>
				</div>
				<div class="card-footer bg-dark">
					<div class="d-flex justify-content-center">
						<div class="text-gray">Masz już konto?&nbsp;</div><a class="linkwh" href="logowanie">Zaloguj
							się!</a>
					</div>
					<div class="d-flex justify-content-center">
						<a class="linkwh" href="resetowanie-hasla">Zapomniałeś hasła?</a>
					</div>
				</div>
			</div>
		</div>
	</main>
	<div id="footer"></div>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>