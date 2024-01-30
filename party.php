<?php
 session_start();
 require('baza.php');
 $polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
 $polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
 $partyid=$_GET['pid'];
 $_SESSION['partyid']=$_GET['pid'];
 if(!isset($_GET['pid']))
 {
	 header("Location: /");
 }
 if(isset($_GET['pid']))
{
$rez = @$polacz->query("SELECT * FROM parties WHERE pid=$partyid");
$hm = $rez->num_rows;
  if($hm>0)
  {
	$wiersz = $rez->fetch_assoc();
	$pid = $wiersz['pid'];
	$uid = $wiersz['uid'];
                 $partyname = $wiersz['partyname'];
                 $createdate = $wiersz['createdate'];
                 $agemin = $wiersz['agemin'];
                 $agemax = $wiersz['agemax'];
				 $startdate = $wiersz['startdate'];
				 $starttime = $wiersz['starttime'];
				 $city = $wiersz['city'];
				 $place = $wiersz['place'];
				 $trybik = $wiersz['trybik'];
				 $rating = $wiersz['rating'];
				 $rating_count = $wiersz['rating_count'];
         $miejsca = $wiersz['miejsca'];
         $opis = $wiersz['opis'];
  }
  else
  {
	  header("Location: /");
  }
  $rez1 = @$polacz->query("SELECT username FROM users WHERE id=$uid");
$hm1 = $rez1->num_rows;
  if($hm1>0)
  {
	$wiersz1 = $rez1->fetch_assoc();
	$username = $wiersz1['username'];
}
}
$rez2 = $polacz->query("SELECT * FROM party_joined WHERE pid='$partyid'");
$hm2 = $rez2->num_rows;
if($hm2>0)
{
  $wiersz2 = $rez2->fetch_assoc();
  $joined = $wiersz2['joined'];
  $zapisani = explode(',', $joined);
  !empty($zapisani) && !empty($zapisani[0]) ? $zapisani_length = sizeof($zapisani) : $zapisani_length = 0;
}
$joinedusrnm = array();
for($i=0; $i<$zapisani_length; $i++)
{
  echo $zapisani_length;
  $rez3 = $polacz->query("SELECT username FROM users WHERE id='$zapisani[$i]'");
  $wiersz3 = $rez3->fetch_assoc();
  array_push($joinedusrnm, $wiersz3['username']);
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php echo '<meta name="title" content="'.$partyname.' - Meetty">'; ?>
  <meta name="description" content="<?php echo $opis; ?>">
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
  <?php echo '<title>'.$partyname.' - Meetty</title>'; ?>
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

    <div class="container-fluid cwhite text-uppercase">
      <div class="row m-5">
        <div class="col">
          <div class="card1">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <h1>Informacje o imprezie:</h1>
                <h4 class="wrap">
                  Twórca: <?php echo '<a class="proflink" href="profile?uid='.$uid.'">@'.$username.'</a>'; ?>
                  <br />
                  Data utworzenia: <?php echo $createdate; ?>
                  <br />
                  Zakres wiekowy: <?php echo $agemin.' - '.$agemax; ?>
                  <br />
                  Data rozpoczęcia: <?php echo $startdate.' '.$starttime; ?>
                  <br />
                  Miejsce: <?php echo $city.', '.$place; ?>
                  <br />
                  Status: <?php echo $trybik; ?>
                  <br />
                  Ocena: <?php echo $rating.'/'.$rating_count; ?>
                </h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card1">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <h1>Zapisani użytkownicy: <?php
                     echo '('.$zapisani_length.'/'.$miejsca.')'; 
                     ?></h1>
                <table>
                  <colgroup>
                    <col style="width: 29px">
                    <col style="width: 110px">
                  </colgroup>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
for($i=0; $i<$zapisani_length; $i++)
{
  echo '
  <tr>
    <td>'.$zapisani[$i].'</td>
    <td>'.$joinedusrnm[$i].'</td>
  </tr>
  ';
}
?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-5">
        <div class="col">
          <div class="card1">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <h1>Opis imprezy:</h1>
                <h4 class="wrap">
                  <?php echo $opis; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card1">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <h1>Dołącz do imprezy:</h1>
                <h1 class="wrap">
                  <?php 
                    $miejsca_int = (int)$miejsca;
                    $diffmiejsca = $miejsca_int - $zapisani_length;
                    if($diffmiejsca>0)
                    {
                    echo 'Są jeszcze wolne miejsca! Dokładnie: '.$diffmiejsca;
                    }
                    else if ($diffmiejsca<=0)
                    {
                    echo 'Niestety nie ma już wolnych miejsc :(';
                    }
                    ?>
                  <br />
                  <br />
                  <?php
                  $not_joined = true;
                    for($z=0; $z<$zapisani_length; $z++)
                    {
                      if(isset($_SESSION['zalogowany']))
                      {
                        if($_SESSION['id']===$zapisani[$z])
                        {
                          echo 'Już dołączyłeś do tej imprezy!
                          <br />
                          Czy chciałbyś zrezygnować?
                          <br />
                          <form method="POST" action="dolusn.php">
                          <input class="btn btn-dark" type="submit" name="usun" value="Wypisz się">
                          </form>';
                          $not_joined=false;
                          break;
                        }
                      } else $not_joined=false;
                    }
                    if($not_joined==true && isset($_SESSION['zalogowany']))
                    {
                    echo '<form method="POST" action="dolusn.php">
                    <input class="btn btn-dark" type="submit" name="dolacz" value="Dołącz">
                    </form>';
                    }
                    if(!isset($_SESSION['zalogowany']))
                    {
                      echo 'Zaloguj się by dołączyć lub zrezygnować z udziału w imprezie!';
                    }
                    ?>
                  </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
  <div id="footer"></div>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $('.auto-clear').on('shown.bs.modal', function () {
      $(this).delay(1000).fadeOut(200, function () {
        $(this).modal('hide');
      });
    })
  </script>
</body>

</html>