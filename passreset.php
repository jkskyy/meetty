<?php
 session_start();
 if (isset($_SESSION['zalogowany']))
 {
     header('Location: profil/'.$_SESSION['id']);
     exit();
 }
 require_once "baza.php";
 
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 if ($polacz->connect_errno!=0)
 {
     echo "Error ".$polacz->connect_errno;
 }
 else
 {
	 if($_POST['submit'])
 {
     $email=$_POST['email'];
     $kod=$_POST['kod'];
	 $haslo=$_POST['password'];
	 if((strlen($haslo)<8) || (strlen($haslo)>32) || $haslo=="" || $haslo==" ")
	 {
		 $OK=false;
		 $_SESSION['e_haslo']="<span style='color: #FF0000;'>Hasło powinno mieć od 8 do 32 znaków!</span>";
	 }
     $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
     if(($rez=@$polacz->query("SELECT id FROM users WHERE email='$email' AND verify_code='$kod'")) && ($OK=!false))
     {
         $hm=$rez->num_rows;
         if($hm>0)
         {
             $wiersz = $rez->fetch_assoc();
             $id=$wiersz['id'];
				 unset($_SESSION['error66']);
				 unset($_SESSION['e_haslo']);
                 $rez->free_result();
                 $polacz->query("UPDATE users SET password='$haslo_hash' WHERE id='$id'");
                 header("Location: login.php");
         }
             
             else
                 {
             $_SESSION['error66'] = '<span style="color: #FF0000;">Niepoprwany email lub kod!</span>';
             
                 }
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
	<meta name="title" content="Resetowanie hasła - Meetty">
	<meta name="description" content="Strona resetowania hasła konta w serwisie Meetty">
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
	<title>Resetowanie hasła - Meetty</title>
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
		<div class="d-flex justify-content-center align-items-center container cwhite vh-100 my-5">
			<div class="card login-form">
				<div class="card-header bg-dark">
					<h1>Resetowanie hasła</h1>
				</div>
				<div class="card-body bg-secondary">
					<form action="resetowanie-hasla" method="POST">
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-mail-alt"></i></span>
							</div>
							<input type="email" name="email" class="form-control" placeholder="Email...">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-key"></i></span>
							</div>
							<input type="text" name="kod" class="form-control" placeholder="Kod...">
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="demo-icon icon-lock"></i></span>
							</div>
							<input type="password" name="password" class="form-control" placeholder="Hasło...">
						</div>
						<div class="form-group">
							<input type="submit" value="Resetuj hasło" name="submit"
								class="btn float-right btn-dark btn-sm kartabtn">
						</div>
					</form>
					<?php if(isset($_SESSION['error66'])) echo $_SESSION['error66']; 
            unset($_SESSION['error66']);
			if(isset($_SESSION['e_haslo'])) echo "<br>".$_SESSION['e_haslo']."<br>"; 
						unset($_SESSION['e_haslo']); ?>
				</div>
				<div class="card-footer bg-dark">
					<div class="d-flex justify-content-center">
						<div class="text-gray">Nie masz konta?&nbsp;</div><a class="linkwh"
							href="rejestracja">Zarejestruj się!</a>
					</div>
					<div class="d-flex justify-content-center">
						<a class="linkwh" href="resetowanie-hasla">Zapomniałeś hasła?</a>
					</div>
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