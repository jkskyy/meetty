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
  <meta name="title" content="Strona Główna - Meetty">
  <meta name="description"
    content="Meetty to strona na której możesz ogłosić własną imprezę i poznać, nowych ciekawych ludzi. Nie czekaj i już dziś dołącz do naszej społeczności!">
  <meta name="keywords" content="Meetty, imprezy, grupa, zapraszamy, grupa Meetty, zabawa">
  <meta name="robots" content="index, follow">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <meta name="language" content="Polish">
  <meta name="author" content="Jarosław Kulig">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">
  <link rel="icon" href="img/meettylogo.png" type="image/png" sizes="16x16">
  <script src="js/jquery-3.6.0.min.js"></script>
  <title>Strona Główna - Meetty</title>
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
    <div class="firstpanel">
      <div class="backpanel">
        <h1>Witaj w Meetty!</h1>
        <h2>
          Jesteśmy szczęśliwi że dotarłeś do naszej wciąż rozwijającej się społeczności!
          <br>
          Projekt stawia właśnie swoje pierwsze kroki, jeżeli trafiłeś tu zupełnym przypadkiem to nie przejmuj się,
          tylko korzystaj z funkcji udostępnionych na stronie &#128516;
          <br>
          Na dole strony znajduje się ważna informacja, którą warto się zainteresować. Czekamy na wasz odzew!
          <br>
          Mamy nadzieję że zostaniesz z nami na dłużej i będziesz zachwycony z działania naszego projektu!
          <br>
          Poniżej znajdziesz najlepsze imprezy które w najbliższym czasie mają swój początek!

        </h2>
        <h3>Zapraszamy do zabawy, grupa Meetty</h3>
      </div>
    </div>
    <?php
echo '<div class="row2 justify-content-center">';
$rez = @$polacz->query("SELECT parties.*, users.username, users.id FROM parties, users WHERE users.id=parties.uid AND trybik!='ZAKOŃCZONA' ORDER BY rating, startdate ASC LIMIT 4");
$rez2 = @$polacz->query("SELECT * FROM parties");
$wiersze = $rez2->num_rows;
$hm = $rez->num_rows;
if($hm>0) {
  while ($row=$rez->fetch_assoc()) {
    if($row['promoted'] == 1) echo '<div class="ticketWrap gradient-box">';
    else echo '<div class="ticketWrap">';
      echo '<div class="ticket ticketLeft">';
    if($row['promoted'] == 1) echo '<h1 class="promoted">'.strip_tags($row['partyname']).'<br /><i><small>PROMOTED</small></i></h1>';
    else echo '<h1>'.strip_tags($row['partyname']).'</h1>';
      echo '<div class="title">';
    if($row['promoted'] == 1) echo '<h2 class="promoted"><a class="text-decoration-none promoted" href="profil/'.$row['id'].'">'.$row['username'].'</a></h2>';
    else echo '<h2><a class="text-decoration-none" href="profil/'.$row['id'].'">'.$row['username'].'</a></h2>';
    if($row['promoted'] == 1) echo '<span class="promoted">TWÓRCA</span>';
    else echo '<span>TWÓRCA</span>';
      echo '</div>';
    if($row['promoted'] == 1) echo '<div class="name promoted">';
    else echo '<div class="name">';
    echo '<h2>'.$row['trybik'].'</h2>
      <span>STATUS</span>
      </div>';
    if($row['promoted'] == 1) echo '<div class="seat promoted">';
    else echo '<div class="seat">';
    echo '
      <h2>'.$row['startdate'].'</h2>
      <span>DATA</span>
      </div>';
    if($row['promoted'] == 1) echo '<div class="time promoted">';
    else echo '<div class="time">';
    echo '<h2>'.$row['starttime'].'</h2>
      <span>GODZINA</span>
      </div>
      </div>
      <div class="ticket ticketRight">
      <div class="number">';
    if($row['promoted'] == 1) echo '<span class="promoted"><b>ID</b></span>';
    else echo '<span><b>ID</b></span>';
    if($row['promoted'] == 1) echo '<h3 class="promoted"><b>'.$row['pid'].'</b></h3>';
    else echo '<h3><b>'.$row['pid'].'</b></h3>';
      echo '</div>';
    if($row['promoted'] == 1) echo '<a class="btn my-2 btn-dark kartabtn promoted" href="impreza/'.$row['pid'].'">DO IMPREZY</a>';
    else echo '<a class="btn my-2 btn-dark kartabtn" href="impreza/'.$row['pid'].'">DO IMPREZY</a>';
      echo '</div></div>';
  }
}
else echo '<h4 class="my-auto">Ojej! Wygląda na to że nic tu nie ma >.<</h4>';
echo '</div>';
?>
    <div class="secondpanel">
      <div class="backpanel2">
        <h5>Już dzisiaj!</h5>
        <h2>
          Jesteśmy rad ogłosić że udało nam się ukończyć fundamenty serwisu, nawet trochę więcej niż tylko fundamenty
          &#128516;
          <br>
          Jesteśmy pewni że znajdziecie jakieś błędy i niedociągnięcia, albo będziecie mieć uwagi co do designu strony.
          <br>
          W takim wypadku prosimy o kontakt na e-mail pomocy (<s>pomoc@meetty.net</s>) lub bezpośrednio do developera
          (<s>developer@meetty.net</s>).
          <br>

          A teraz zapraszamy do zabawy i przetrzepywania wszystkich zakamarków strony.
          <br>
          Wersja alpha Meetty jest cała wasza! &#129321;

        </h2>
        <h3>Powodzenia, grupa Meetty</h3>
      </div>
    </div>
  </main>
  <div id="footer"></div>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>