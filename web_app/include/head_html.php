<script src="style/js/jquery.js"></script>
<link rel="stylesheet" href="style/css/style.css">
<script src="style/js/index.js" defer></script>
<link rel="icon" href="">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css"
      integrity="sha512-NaaXI5f4rdmlThv3ZAVS44U9yNWJaUYWzPhvlg5SC7nMRvQYV9suauRK3gVbxh7qjE33ApTPD+hkOW78VSHyeg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
session_start();
if (!isset($_SESSION['user']) OR !isset($_GET['id'])) {
    session_destroy();
    header('location: login.php');
}

require_once 'include/User.php';
require_once 'include/Page.php';
$user = unserialize($_SESSION['user']);
?>