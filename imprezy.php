<?php
 session_start();
 require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="title" content="Imprezy - Meetty">
  <meta name="description" content="Strona wszystkich imprez dostępnych w serwisie Meetty">
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
  <title>Imprezy - Meetty</title>
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
    <div class="card-glass m-5">
      <div class="card-body">
        <div class="d-flex flex-column align-items-center">
          <div id="content" class="row3 justify-content-center">
          </div>
        </div>
      </div>
    </div>
    <div id="buttons">
      <button id="back" type="button" class="back2">Wróć</button>
      <button id="next" type="button" class="next2">Dalej</button>
    </div>
  </main>
  <div id="footer"></div>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/allparty.js"></script>
</body>

</html>