<?php
session_start();
if($_POST['submit'])
{
	$OK=true;
	$emailA=$_POST['email'];
	$emailB = filter_var($emailA, FILTER_SANITIZE_EMAIL);
	 	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || $emailB!=$emailA)
	 	{
			$OK=false;
		 	$_SESSION['e_email']="<span style='color: #FF0000;'>Podaj poprawny adres e-mail!</span>";
		}
	$subject=$_POST['subject'];
		if($subject==" " || $subject=="")
		{
			$OK=false;
			$_SESSION['e_subject']="<span style='color: #FF0000;'>Nie podano tematu wiadomości!</span>";
		}
	$content=$_POST['content'];
		if($content==" " || $content=="")
		{
			$OK=false;
			$_SESSION['e_content']="<span style='color: #FF0000;'>Nie wprowadzono treści wiadomości!</span>";
		}
	if($OK!=false)
	{
		$to="Meetty@c00lh34d.webd.pro";
		$from=$emailB;
		$headers = "From:" . $from;
		mail($to, $subject,$content,$headers);
		$_SESSION['email_sent']="<span style='color: green;'>Pomyślnie przesłano wiadomość!</span>";
	}
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="title" content="Pomoc - Meetty">
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
	<title>Pomoc - Meetty</title>
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
			<div class="card help-form">
				<div class="card-header login-form-dark">
					<h1>Pomoc</h1>
				</div>
				<div class="card-body">
					<h3 id="main-page"><i class="demo-icon icon-home-outline"></i> Strona Główna</h3>
					<div class="bot-border"></div>
					Na stronie głównej pojawiają się dodane przez użytkowników imprezy w kolejności od najnowszej do
					najstarszej, otrzymują one odpowiednie <a href="#colors">kolory</a> w zależności od ich statusu.
					Najeżdżając kursorem lub klikając (urządzenia mobilne) w kartę imprezy, na której przedniej stronie
					widoczna jest jej nazwa, będziesz mógł zobaczyć skrócone informacje
					na jej temat, takie jak: nazwa użytkownika który utworzył imprezę, zakres wiekowy, miasto w którym
					odbywa się impreza oraz jej status.
					Znajduje się tam też przycisk przenoszący na stronę imprezy, gdzie można sprawdzić szczegółowe dane
					o imprezie, zapisać się na nią czy ocenić ją (po jej zakończeniu).
					<br />
					<br />
					<h5 id="colors">Kolory</h5>
					<div class="bot-border"></div>
					<div class="helpplanned"></div> - oznacza że impreza jest zaplanowana i do jej startu zostało więcej
					niż 60 minut.
					<br />

					<div class="helpstarting"></div> - oznacza że impreza się zaczyna i do jej rozpoczęcia zostało mniej
					niż 60 minut.
					<br />

					<div class="helpongoing"></div> - oznacza że impreza trwa, zapisy są zakończone i zabawa trwa w
					najlepsze.
					<br />

					<div class="helpended"></div> - oznacza że impreza się zakończyła i nie znajduje się jeszcze w
					archiwum.
					<br />
					<br />
					<br />
					<h3 id="parties"><i class="demo-icon icon-megaphone"></i> Imprezy</h3>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<h5>Zweryfikowane</h5>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<h5>Wszystkie</h5>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<h5>Klubowe</h5>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<h5>Domówki</h5>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<br />
					<h3 id="locales"><i class="demo-icon icon-building"></i> Lokale</h3>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<br />
					<h3 id="help"><i class="demo-icon icon-lifebuoy"></i> Pomoc</h3>
					<div class="bot-border"></div>
					Jesteś tutaj! :D
					<br />
					<br />
					<br />
					<h3 id="user"><i class="demo-icon icon-user"></i> Zakładka użytkownika</h3>
					<div class="bot-border"></div>
					<br />
					<br />
					<h5><i class="demo-icon icon-user"></i> Profil</h5>
					<div class="bot-border"></div>
					<br />
					<br />
					<h5><i class="demo-icon icon-login"></i> Zaloguj / <i class="demo-icon icon-logout"></i> Wyloguj
					</h5>
					<div class="bot-border"></div>
					<br />
					<br />
					<h5><i class="demo-icon icon-clipboard"></i> Rejestracja</h5>
					<div class="bot-border"></div>
					<br />
					<br />
					<h5><i class="demo-icon icon-lock-open-alt"></i> Reset hasła</h5>
					<div class="bot-border"></div>
					<br />
					<br />
					<h5><i class="demo-icon icon-cog"></i> Ustawienia użytkownika</h5>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
					<br />
					<br />
					<br />
					<h3 id="user"><i class="demo-icon icon-android-1"></i> Aplikacja Android</h3>
					<div class="bot-border"></div>
					<i class="demo-icon icon-wrench"></i> W budowie...
				</div>
				<div class="card-header login-form-dark">
					<h2>Formularz kontaktowy</h2>
				</div>
				<div class="card-body">
					<form action="pomoc" method="POST">
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-mail-alt"></i></span>
							</div>
							<input type="email" name="email" class="form-control" placeholder="Email...">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-doc-text"></i></span>
							</div>
							<input type="text" name="subject" class="form-control" placeholder="Temat">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-comment-alt"></i></span>
							</div>
							<textarea class="form-control" name="content" rows="8" placeholder="Treść..."></textarea>
						</div>
						<div class="form-group">
							<input type="submit" value="Wyślij" name="submit"
								class="btn float-right btn-dark btn-sm kartabtn">
						</div>
						<?php if(isset($_SESSION['e_email'])) echo $_SESSION['e_email']."<br />"; ?>
						<?php unset($_SESSION['e_email']); ?>
						<?php if(isset($_SESSION['e_subject'])) echo $_SESSION['e_subject']."<br />"; ?>
						<?php unset($_SESSION['e_subject']); ?>
						<?php if(isset($_SESSION['e_content'])) echo $_SESSION['e_content']."<br />"; ?>
						<?php unset($_SESSION['e_content']); ?>
						<?php if(isset($_SESSION['email_sent'])) echo $_SESSION['email_sent']."<br />"; ?>
						<?php unset($_SESSION['email_sent']); ?>
					</form>
				</div>
				<div class="card-footer login-form-dark">
					<div class="d-flex">
						Podziękowania:
						<br>
						Dla Cryvietv: Za pomoc w marketingu i zarzucaniu nowych pomysłów.
						<br>
						Dla Syczey: Za pomoc w zachowaniu czystej głowy i testowaniu niektórych funkcji.
						<br>
						Dla Shawel123: Za wskazanie błędów oraz testowanie strony i funkcji.
						<br>
						Oraz dla wszystkich użytkowników za korzystanie i wspieranie projektu.
						<br>
						Dziękuję, J.K.
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