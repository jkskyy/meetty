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
   if(!empty($_POST['submit']))
   {
     $email=$_POST['email'];
     $haslo=$_POST['password'];
     if ($rez = @$polacz->query(
     sprintf("SELECT * FROM users WHERE email = '%s'",
     mysqli_real_escape_string($polacz, $email))))
     {
         $hm = $rez->num_rows;
         if($hm>0)
         {
             
             
             $wiersz = $rez->fetch_assoc();
             if(password_verify($haslo, $wiersz['password']))
             {
                 $_SESSION['id'] = $wiersz['id'];
                 $_SESSION['username'] = $wiersz['username'];
                 $_SESSION['email'] = $wiersz['email'];
                 $_SESSION['gender'] = $wiersz['gender'];
                 $_SESSION['age'] = $wiersz['age'];
                 $_SESSION['joindate'] = $wiersz['joindate'];
                 $_SESSION['birthdate'] = $wiersz['birthdate'];
                 $_SESSION['lastlogin'] = $wiersz['lastlogin'];
                 $_SESSION['acc_verify'] = $wiersz['acc_verify'];
                 $_SESSION['city'] = $wiersz['city'];
                 $_SESSION['region'] = $wiersz['region'];
                 $_SESSION['rating'] = $wiersz['rating'];
                 $_SESSION['rating_count'] = $wiersz['rating_count'];
                 $_SESSION['profilepic'] = $wiersz['profilepic'];
             if($_SESSION['acc_verify']=="Niezweryfikowany")
             {
                 $_SESSION['error120'] = '<span style="color: #FF0000;">Musisz zweryfikować swoje konto!</span>';
             }
             else
             {
                 $_SESSION['zalogowany'] = true;
                 unset($_SESSION['error12']);
                 unset($_SESSION['error120']);
                 $rez->free_result();
                 $polacz->query("UPDATE users SET lastlogin=now() WHERE id=".$_SESSION['id']."");
                 header('Location: profil/'.$_SESSION['id']);
             }
             }
             else
                 {
             $_SESSION['error12'] = '<span style="color: #FF0000;">Niepoprwany email lub hasło!</span>';
                 }
         }
         else
                 {
             $_SESSION['error12'] = '<span style="color: #FF0000;">Niepoprwany email lub hasło!</span>';
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
    <meta name="title" content="Logowanie - Meetty">
    <meta name="description" content="Strona logowania do konta w serwisie Meetty">
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
    <title>Logowanie - Meetty</title>
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
                    <h1>Logowanie</h1>
                </div>
                <div class="card-body bg-secondary">
                    <form action="logowanie" method="POST">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="demo-icon icon-mail-alt"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="Email...">

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="demo-icon icon-lock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Hasło...">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Zaloguj" name="submit"
                                class="btn float-right btn-dark btn-sm kartabtn">
                        </div>
                        <?php if(isset($_SESSION['error12'])) echo $_SESSION['error12']."<br />"; ?>
                        <?php unset($_SESSION['error12']); ?>
                        <?php if(isset($_SESSION['error120'])) echo $_SESSION['error120']."<br />"; ?>
                        <?php unset($_SESSION['error120']); ?>
                        <?php if(isset($_SESSION['verifying'])) echo $_SESSION['verifying']."<br />"; ?>
                        <?php unset($_SESSION['verifying']); ?>
                        <?php if(isset($_SESSION['regok'])) echo $_SESSION['regok']."<br />"; ?>
                        <?php unset($_SESSION['regok']); ?>
                        <?php if(isset($_SESSION['notlogged'])) echo $_SESSION['notlogged']."<br />"; ?>
                        <?php unset($_SESSION['notlogged']); ?>
                    </form>
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
    </main>
    <div id="footer"></div>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>