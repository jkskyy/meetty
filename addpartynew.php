<?php
date_default_timezone_set('Europe/Warsaw');
session_start();
if(!isset($_SESSION['zalogowany']))
{
    $_SESSION['notlogged'] = "<span style='color: #FF0000;'> Musisz być zalogowany by wykonać tą akcję!</span>";
	header("Location: logowanie");
	exit;
}
require('baza.php');
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$dateform=$_POST['startdate'];
$uid=$_SESSION['id'];
$agemin=$_POST['agemin'];
$agemax=$_POST['agemax'];
$region=$_POST['region'];
$starttime=$_POST['starttime'];
$rodzaj=$_POST['rodzaj'];
$city=$_POST['city'];
$place=$_POST['place'];
$members=$_COOKIE['members'];
$now=date("Y-m-d");
$nowtimestamp=strtotime($now);
$dateformtimestamp=strtotime($dateform);
$now7 = $nowtimestamp + (7*24*60*60);
$now7date = date('Y-m-d', $now7);
$opis=$_POST['content'];
if(isset($_POST['pname']))
 {
	 $OK = true;
	 $pname=$_POST['pname'];
	 $pname = strip_tags($pname);
	 $opis = strip_tags($opis);
	 preg_replace('/[^A-Za-z0-9\-]/', '', $pname);
	 preg_replace('/[^A-Za-z0-9\-]/', '', $opis);
	 if($opis=="" || $opis==" ")
{
	$opis="Użytkownik nie dodał opisu imprezy.";
}
	 if((strlen($pname)<8) || (strlen($pname)>24))
	 {
		 $OK=false;
		 $_SESSION['e_pname']="<span style='color: #FF0000;'>Nazwa imprezy musi posiadać od 8 do 24 znaków!</span>";
	 }
	 if ($agemin<16 || $agemax<17 || $agemin>98 || $agemax>99 || $agemin>$agemax)
	 {
		$OK=false;
		$_SESSION['e_age']="<span style='color: #FF0000;'>Podane zostały błędne dane!</span>";
	 }
	 if (!isset($agemin) || !isset($agemax))
	 {
		$OK=false;
		$_SESSION['e_age1']="<span style='color: #FF0000;'>Musisz podać wiek minimalny i maksymalny!</span>";
	 }
	 if (!isset($starttime) || $starttime==0 || $starttime=="")
	 {
		$OK=false;
		$_SESSION['e_starttime']="<span style='color: #FF0000;'>Musisz podać godzine rozpoczęcia!</span>";
	 }
	 if ($dateformtimestamp==0 || $dateformtimestamp<$now7)
	 {
		$OK=false;
		$_SESSION['e_startdate']="<span style='color: #FF0000;'>Musisz podać odpowiedni dzień, w który odbędzie się impreza!</span>";
	 }
	 if ($dateformtimestamp<$now)
     {

     }
	 if (!isset($region) || $region=="Wybierz województwo...")
	 {
		$OK=false;
		$_SESSION['e_region']="<span style='color: #FF0000;'>Musisz wybrać województwo, w którym odbywa się impreza!</span>";
	 }
	 if ($city=="")
	 {
		$OK=false;
		$_SESSION['e_city']="<span style='color: #FF0000;'>Musisz podać miasto, w którym odbywa się impreza!</span>";
	 }
	 if (!isset($rodzaj) || $rodzaj=="Wybierz rodzaj imprezy...")
	 {
		$OK=false;
		$_SESSION['e_rodzaj']="<span style='color: #FF0000;'>Musisz wybrać rodzaj imprezy!</span>";
	 } 
	 if ($place=="")
	 {
		$OK=false;
		$_SESSION['e_place']="<span style='color: #FF0000;'>Musisz podać miejsce lub adres gdzie odbędzie się impreza!</span>";
	 } 
	 if(!isset($_POST['reg']))
	 {
		 $OK=false;
		 $_SESSION['e_chkbox']="<span style='color: #FF0000;'>Prosze zaakceptować regulamin!</span>";
	 }
     if($OK==false)
	 {
		$member = $_COOKIE['members'];
		if($member>100)
		{
			if($members<=100)
			{
				$OK2=false;
				$_SESSION['e_members']='<span style="color: #FF0000;">Podano niepoprawną wartość! Minimalna liczba miejsc dla imprezy typu "Ogromna" wynosi 101!</span>';
			}
	 }
	}
	 if ($OK==true)
		{
			$OK2=true;
			$member = $_COOKIE['members'];
			if($member>100)
			{
				if($members<=100)
				{
					$OK2=false;
					$_SESSION['e_members']='<span style="color: #FF0000;">Podano niepoprawną wartość! Minimalna liczba miejsc dla imprezy typu "Ogromna" wynosi 101!</span>';
				}
				else
				{
					$member=$members;
				}
			}
		if($OK2==true)
		{
			$rezpid = $polacz->query("SELECT pid FROM parties ORDER BY pid DESC LIMIT 1");
			$hm9 = $rezpid->num_rows;
			if($hm9>0)
		{
			$wiersz = $rezpid->fetch_assoc();
			$pid = $wiersz['pid']+1;
			$polacz->query("INSERT INTO parties VALUES('$pid', '$uid', '$pname', now(), '$dateform', '$starttime', '$city', '$place', '$agemin', '$agemax', '$rodzaj', 'ZAPLANOWANA', 0, 0, 0, '$member', '$opis')");
		}
		else
		{
			$polacz->query("INSERT INTO parties VALUES(NULL, '$uid', '$pname', now(), '$dateform', '$starttime', '$city', '$place', '$agemin', '$agemax', '$rodzaj', 'ZAPLANOWANA', 0, 0, 0, '$member', '$opis')");
			$rezofpid = $polacz->query("SELECT pid FROM parties ORDER BY pid DESC LIMIT 1");
			$row = $rezofpid->fetch_assoc();
			$pid = $row['pid'];
		}
		$polacz->query("INSERT INTO party_joined VALUES(NULL, '$pid', '', '')");
        header("Location: impreza/".$pid);
		}
    }
    }
    $polacz->close();
?>
<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="title" content="Dodawanie Imprezy - Meetty">
	<meta name="description"
		content="Meetty to strona na której możesz ogłosić własną imprezę i poznać, nowych ciekawych ludzi. Nie czekaj i już dziś dołącz do naszej społeczności!">
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
	<title>Dodawanie imprezy - Meetty</title>
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
					<h1 id="h1"></h1>
				</div>
				<div class="card-body bg-secondary">
					<form class="form step" id="step1">
						<h2>Wybierz wielkość imprezy</h2>
						<div class="inputGroup">
							<input id="radio1" name="radio" type="radio" value="10" />
							<label for="radio1">Mini (do 10 osób)</label>
						</div>
						<div class="inputGroup">
							<input id="radio2" name="radio" type="radio" value="20" />
							<label for="radio2">Mała (do 20 osób)</label>
						</div>
						<div class="inputGroup">
							<input id="radio3" name="radio" type="radio" value="50" />
							<label for="radio3">Średnia (do 50 osób)</label>
						</div>
						<div class="inputGroup">
							<input id="radio4" name="radio" type="radio" value="100" />
							<label for="radio4">Duża (do 100 osób)</label>
						</div>
						<div class="inputGroup">
							<input id="radio5" name="radio" type="radio" value="101" />
							<label for="radio5">Ogromna (100+ osób)</label>
						</div>
					</form>
					<form id="step2" class="step" action="dodaj-impreze" method="POST">
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-ticket"></i></span>
							</div>
							<input type="text" name="pname" class="form-control" placeholder="Nazwa imprezy...">
							<span class="help-block">Nazwa imprezy powinna posiadać od 8 do 24 znaków! Nie powinna ona
								zawierać określeń obraźliwych lub powszechnie uznawanych za krzywdzące!<br></span>
							<?php if(isset($_SESSION['e_pname'])) echo $_SESSION['e_pname']."<br>"; ?>
							<?php unset($_SESSION['e_pname']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-calendar"></i></span>
							</div>
							<input type="date" name="startdate" class="form-control">
							<span class="help-block">Data musi być odległa od dzisiaj o co najmniej 7 dni! W tym wypadku
								najwcześniejsza dostępna data to: <?php echo $now7date; ?><br></span>
							<?php if(isset($_SESSION['e_startdate'])) echo $_SESSION['e_startdate']."<br>"; ?>
							<?php unset($_SESSION['e_startdate']); ?>
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-clock"></i></span>
							</div>
							<input type="time" name="starttime" class="form-control">
						</div>
						<?php if(isset($_SESSION['e_starttime'])) echo $_SESSION['e_starttime']."<br>"; ?>
						<?php unset($_SESSION['e_starttime']); ?>
						<div class="members input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-users"></i></span>
							</div>
							<input type="number" name="members" min="101" class="form-control"
								placeholder="(101) Miejsca...">
						</div>
						<?php if(isset($_SESSION['e_members'])) echo $_SESSION['e_members']."<br>"; ?>
						<?php unset($_SESSION['e_members']); ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-users"></i></span>
							</div>
							<input type="number" name="agemin" min="16" max="98" class="form-control"
								placeholder="(16) Wiek minimalny...">
						</div>
						<?php if(isset($_SESSION['e_age'])) echo $_SESSION['e_age']."<br>"; ?>
						<?php if(isset($_SESSION['e_age1'])) echo $_SESSION['e_age1']."<br>"; ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-users"></i></span>
							</div>
							<input type="number" name="agemax" min="17" max="99" class="form-control"
								placeholder="(99) Wiek maksymalny...">
						</div>
						<?php if(isset($_SESSION['e_age'])) echo $_SESSION['e_age']."<br>"; ?>
						<?php if(isset($_SESSION['e_age1'])) echo $_SESSION['e_age1']."<br>"; ?>
						<?php unset($_SESSION['e_age']); ?>
						<?php unset($_SESSION['e_age1']); ?>
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
						</div>
						<?php if(isset($_SESSION['e_region'])) echo $_SESSION['e_region']."<br>"; ?>
						<?php unset($_SESSION['e_region']); ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-building"></i></span>
							</div>
							<input type="text" name="city" class="form-control" placeholder="Miasto...">
						</div>
						<?php if(isset($_SESSION['e_city'])) echo $_SESSION['e_city']."<br>"; ?>
						<?php unset($_SESSION['e_city']); ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-map-signs"></i></span>
							</div>
							<input type="text" id="place" class="form-control" name="place" placeholder="Adres...">
						</div>
						<?php if(isset($_SESSION['e_place'])) echo $_SESSION['e_place']."<br>"; ?>
						<?php unset($_SESSION['e_place']); ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-glass"></i></span>
							</div>

							<select name="rodzaj" class="form-control">
								<option selected>Wybierz rodzaj imprezy...</option>
								<option>Domówka (ALK./+18)</option>
								<option>Impreza w klubie (ALK./+18)</option>
								<option>Impreza w plenerze (ALK./+18)</option>
								<option>Impreza mieszana (ALK./+18)</option>
								<option>Domówka (BEZALK./+16)</option>
								<option>Impreza w klubie (BEZALK./+16)</option>
								<option>Impreza w plenerze (BEZALK./+16)</option>
								<option>Impreza mieszana (BEZALK./+16)</option>
							</select>
						</div>
						<?php if(isset($_SESSION['e_rodzaj'])) echo $_SESSION['e_rodzaj']."<br>"; ?>
						<?php unset($_SESSION['e_rodzaj']); ?>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-comment-alt"></i></span>
							</div>
							<textarea class="form-control" name="content" rows="8"
								placeholder="(Opcjonalnie) Opis..."></textarea>
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
							<input type="submit" value="Dodaj imprezę" class="btn float-right btn-dark btn-sm kartabtn">
						</div>
					</form>
					<button type="button" class="back">Wróć</button>
					<button type="button" class="next">Dalej</button>
				</div>
				<div class="card-footer bg-dark">
					<div class="d-flex justify-content-center">
						<div class="text-gray text-center">Jeżeli masz jakiś problem skontaktuj się z naszym działem
							wsparcia. <br /> Pomożemy!</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<div id="footer"></div>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		var counter = 1;
		var title = document.getElementById("h1");
		title.innerHTML = "Dodawanie imprezy - Krok " + counter;
		$('#step' + counter).show();
		$('body').on('click', '.next', function () {
			$('.step').hide();

			counter++;
			title.innerHTML = "Dodawanie imprezy - Krok " + counter;
			$('#step' + counter + '').show();

			if (counter > 1) {
				$('.back').show();
			};
			if (counter > 1) {
				$('.step2').hide();
				$('.next').hide();
				$('.end').show();
			};

		});

		$('body').on('click', '.back', function () {
			counter--;
			title.innerHTML = "Dodawanie imprezy - Krok " + counter;
			$('.step').hide();
			var id = counter;
			$('#step' + id).show();
			if (counter < 2) {
				$('.back').hide();
			}
			if (counter < 2) {
				$('.next').show();
			}


		});

		$('body').on('click', '.next', function () {
			var radio = document.getElementsByName('radio');

			function createCookie(name, value, minutes) {
				var date = new Date();
				date.setTime(date.getTime() + (minutes * 60 * 1000));
				var expires = "; expires=" + date.toGMTString();
				document.cookie = name + "=" + value + expires + ";";
			}

			for (var i = 0, length = radio.length; i < length; i++) {
				if (radio[i].checked) {
					if (radio[i].value > 100) {
						$('.members').show();
						createCookie("members", radio[i].value, 5);
					} else {
						$('.members').hide();
						createCookie("members", radio[i].value, 5);
					}
					break;
				}
			}
		});
	</script>
</body>

</html>