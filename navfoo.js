$(function () {
  $("#nav").load("navbar.php");
  $("#footer").load("footer.html");
  $("#MyModalLoad").load("modal1.html");
  $("#MyModalSuccess").load("modal2.html");
});

$(window).on('load', function () {
  $("#loader-wrapper").fadeOut();
});