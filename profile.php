<?php
 session_start();
 require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 if(!isset($_SESSION['id']))
  {
    $_SESSION['id']=0;
  }
 if(isset($_GET['uid']))
 {
 $userid=$_GET['uid'];
 }
 if((!isset($_SESSION['zalogowany'])) && (!isset($_GET['uid'])))
 {
	$_SESSION['notlogged'] = "<span style='color: red;'> Musisz być zalogowany by wykonać tą akcję!</span>";
	 header("Location: logowanie");
 }
 if(isset($_GET['uid']))
{
  
$rez = @$polacz->query("SELECT * FROM users WHERE id=$userid");
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
  }
  else
  {
	  header("Location: /");
  }

}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php echo '<meta name="title" content="'.$username.' - Meetty">'; ?>
  <meta name="description"
    content="Meetty to strona na której możesz ogłosić własną imprezę i poznać, nowych ciekawych ludzi. Nie czekaj i już dziś dołącz do naszej społeczności!">
  <meta name="keywords" content="Meetty">
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <meta name="language" content="Polish">
  <meta name="author" content="Jarosław Kulig">
  <base href="/" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">
  <link rel="icon" href="img/meettylogo.png" type="image/png" sizes="16x16">
  <script src="js/jquery-3.6.0.min.js"></script>
  <?php echo '<title>'.$username.' - Meetty</title>'; ?>
  <script src="navfoo.js"></script>
  <script src="editprofile.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(function () {

      $('form').on('submit', function (e) {

        e.preventDefault();
        $('#MyModalLoad').modal('show');
        setTimeout(function () {
          $('#MyModalLoad').modal('hide');
        }, 2000);
        $.ajax({
          type: 'post',
          url: 'editprofile.php',
          data: $('form').serialize(),
          proccessData: false,
          success: function () {
            console.log($('form').serialize());
            edit();
            $('#MyModalSuccess').modal('show');
            document.querySelector("#email").innerText = document.getElementsByName("email2")[0].value;
            document.querySelector("#brdate").innerText = document.getElementsByName("brdate2")[0].value;
            document.querySelector("#city").innerText = document.getElementsByName("city2")[0].value;
            document.querySelector("#profilename").innerText = document.getElementsByName("profilename2")[
              0].value;
          },
          error: function () {
            console.log('XD');
          }
        });
        var fd = new FormData();
        var files = $('#file')[0].files;

        if (files.length > 0) {
          fd.append('file', files[0]);

          $.ajax({
            url: 'upload.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
              if (response != 0) {
                $("#profilepic").attr("src", response);
                $("#profilepic3").attr("src", response);
                $(".preview img").show();
              } else {
                alert('file not uploaded');
              }
            },
          });
        }
      });
    });
  </script>
</head>

<body>
  <div id="nav" class="sticky-top"></div>
  <div id="loader-wrapper">
    <div class="load">
      <object type="image/svg+xml" data="img/mm.svg"></object>
    </div>
  </div>
  <main>

    <div class="container-fluid p-5 cwhite">
      <div class="row">
        <div class="col-md-6 my-5">
          <div class="card">
            <div class="card-body">
              <?php
                if($_SESSION['id']==$userid)
                  {
                    echo '<div class="d-flex align-content-center text-center">';
                    echo '<i class="demo-icon icon-pencil h3 my-1" onclick="edit(); reset();"></i> &emsp;';
                    echo '<form><input type="button" value="Reset" class="d-none btn btn-primary" onclick="reset()" id="reset"></form>&emsp;';
                    echo '<form action="editprofile.php" method="POST"><input id="submit" class="d-none btn btn-primary" value="Zapisz" type="submit" name="submit"></form>';
                    echo '</div>';
                  }
              ?>
              <div class="d-flex flex-column align-items-center text-center">
                <?php echo '<img id="profilepic" src="uploads/'.$profilepic.'" alt="Admin" class="rounded-circle" width="128" height="128">'; ?>
                <div id="profilepic2" class="d-none">
                  <form id="form4" action="editprofile.php" method="POST" enctype="multipart/form-data">
                    <label>
                      <?php echo '<div class="container position-relative"><img id="profilepic3" class="rounded-circle" width="128" height="128" src="uploads/'.$profilepic.'"><input id="file" class="d-none" type="file" name="file" accept="image/*"></img><i class="demo-icon icon-camera bottom-right"></i></div>';
                 ?>
                    </label>
                  </form>
                </div>
                <div class="mt-3">
                  <h4 id="profilename" class="profilename"><?php echo $username ;  ?>
                  </h4>
                  <div id="profilename2" class="d-none">
                    <form id="form5" action="editprofile.php" method="POST"><input id="profilename3"
                        class="form-control" value="<?php echo $username; ?>" type="text" name="profilename2">
                    </form>
                    <br />
                  </div>
                  <p class="text-card mb-1">ID: <?php echo $id; ?></p>
                  <p class="text-card font-size-sm">Ostatnio online: <?php echo $lastlogin; ?></p>
                  <p class="text-card mb-1">Status Konta: <?php echo $acc_verify; ?></p>
                  <p class="text-card mb-1">Ocena Konta: <?php echo $rating; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 my-auto">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">E-Mail:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo '<div id="email">'.$email.'</div>'; ?>
                  <div id="email2" class="d-none">
                    <form id="form1" action="editprofile.php" method="POST"><input id="email3" class="form-control"
                        value="<?php echo $email; ?>" type="email" name="email2">
                    </form>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Data utworzenia konta:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo $joindate; ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Data urodzenia:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo '<div id="brdate">'.$birthdate.'</div>'; ?>
                  <div id="brdate2" class="d-none">
                    <form id="form2" action="editprofile.php" method="POST"><input id="brdate3" class="form-control"
                        value="<?php echo $birthdate; ?>" type="date" name="brdate2">
                    </form>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Miasto:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo '<div id="city">'.$city.'</div>'; ?>
                  <div id="city2" class="d-none">
                    <form id="form3" action="editprofile.php" method="POST"><input id="city3" class="form-control"
                        value="<?php echo $city; ?>" type="text" name="city2"></form>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Województwo:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo $region; ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Wiek:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo $age; ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-6 text-card my-auto">
                  <h6 class="mb-0">Płeć:</h6>
                </div>
                <div class="col-sm-6 text-card">
                  <?php echo $gender; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade linkbl" id="MyModalLoad" tabindex="-1" role="dialog" aria-labelledby="MyModal"
          aria-hidden="true">
        </div>
        <div class="modal fade linkbl" id="MyModalSuccess" tabindex="-1" role="dialog" aria-labelledby="MyModal"
          aria-hidden="true">
        </div>
  </main>
  <div id="footer"></div>
  <?php 
?>
  <script defer>
    defaultvalues.email = document.getElementsByName("email2")[0].value;
    defaultvalues.brdate = document.getElementsByName("brdate2")[0].value;
    defaultvalues.city = document.getElementsByName("city2")[0].value;
    defaultvalues.nickname = document.getElementsByName("profilename2")[0].value;
  </script>
</body>

</html>