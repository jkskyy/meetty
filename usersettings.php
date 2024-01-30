<?php
 session_start();
if(!isset($_SESSION['zalogowany']))
{
	$_SESSION['notlogged'] = "<span style='color: #FF0000;'> Musisz być zalogowany by wykonać tą akcję!</span>";
	header("Location: logowanie");
	exit();
}
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
  <meta name="title" content="Ustawienia profilu - Meetty">
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
  <script type="text/javascript" src="js/jquery.form.js"></script>
  <title>Ustawienia profilu - Meetty</title>
  <script src="navfoo.js"></script>
</head>

<body>
  <div id="nav" class="sticky-top"></div>
  <script>
    $(document).ready(function () {
      $('#submitbtn').click(function () {
        $("#viewimage").html('');
        $("#viewimage").html('<img src="img/loading.gif" />');
        $(".uploadform").ajaxForm({
          target: '#viewimage'
        }).submit();
      });
    });
  </script>
  <script>
    var loadFile = function (event) {
      var choosen = document.getElementById('choosen');
      choosen.src = URL.createObjectURL(event.target.files[0]);
      choosen.onload = function () {
        URL.revokeObjectURL(choosen.src)
      }
    };
  </script>
  <div id="loader-wrapper">
    <div class="load">
      <object type="image/svg+xml" data="img/mm.svg"></object>
    </div>
  </div>
  <main>
    <div class="col-12 cwhite container">

      <form class="uploadform" method="post" enctype="multipart/form-data" action='upload.php'>
        Zdjęcie profilowe:
        <br />
        <label class="btn btn-primary">
          Browse&hellip; <input class="d-none" type="file" name="imagefile" accept="image/*" onchange="loadFile(event)">
        </label>
        <label class="btn btn-primary">
          Submit
          <input class="d-none" type="submit" value="Submit" name="submitbtn" id="submitbtn">
        </label>
      </form>
      <br />
      Aktualne zdjęcie profilowe: <div id='viewimage'>
        <?php echo '<img class="actualpicupload" src="uploads/'.$_SESSION['profilepic'].'">'; ?>
      </div>
      <br />
      Wybrane zdjęcie profilowe:
      <div>
        <img class="actualpicupload" src="uploads/no-profile-pic.jpg" id="choosen" />
      </div>
      <br />
      <?php
      if(isset($_SESSION['uploaderr']))
      {
        echo $_SESSION['uploaderr'];
        unset($_SESSION['uploaderr']);
      }
      if(isset($_SESSION['toobig']))
      {
        echo $_SESSION['toobig'];
        unset($_SESSION['toobig']);
      }
      if(isset($_SESSION['wrongtype']))
      {
        echo $_SESSION['wrongtype'];
        unset($_SESSION['wrongtype']);
      }
      if(isset($_SESSION['nofile']))
      {
        echo $_SESSION['nofile'];
        unset($_SESSION['nofile']);
      }
      ?>
    </div>
  </main>
  <div id="footer"></div>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>