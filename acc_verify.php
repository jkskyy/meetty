<?php
session_start();
if(isset($_GET['user']))
{
require_once "baza.php";
$polacz = @new mysqli($host, $dbuser, $dbpass, $dbname);
$polacz->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$verifycode = $_GET['user'];
$polacz->query("UPDATE users SET acc_verify=2 WHERE verify_code='$verifycode'");
$_SESSION['verifying']="<span style='color: #00FF00;'>Konto pomyślnie zweryfikowane!</span>";
$polacz->close();
header("Location: logowanie");
exit;
}
else
{
header("Location: /");
exit;
}
?>