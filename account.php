<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
  include('du.php');
?> 
<!DOCTYPE html>
<html>
<head>
<title>Account | SWS</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div class="header">
<div class="top-head">
    <div class="top-left"><div class="logo"><a href="/seo">sws</a></div></div>
<div class="top-right">
<div id="reg"><a href="Logout">Logout</a></div>
</div>
</div>
</div>
<div class="wrap">
<div class="details">
      <div class="sidebar">
        <li><a href="home">Home</a></li>
        <li><a href="analyse">Analyse SEO</a></li>
        <li><a href="support">Support</a></li>
        <li><a id="sidebaractive" href="account">Account</a></li>
    </div>
    <div class="content">
<h2 class="conthead">Account</h2>
<p>Would you like to delete your account?</p>
<?php 
  $del = "";
  $errors = array();
if (isset($_POST['delete'])) {
  $del = mysqli_real_escape_string($db, $_POST['del']);
  if (!( ($del == "DELETE")||($del == "delete")||($del == "Delete"))) { array_push($errors, "<b>* Fill the box before clicking on deactivate button</b>"); }
  if (count($errors) == 0) {
  $rs = mysqli_query($db, "DELETE FROM site WHERE url='$url'");
  $ss = mysqli_query($db, "DELETE FROM user WHERE username='$username'");
  header('location: logout.php');
}
}
?>
<form action="" method="POST">
<p>Type "DELETE" and click on delete button to deactivate this account</p>
<?php include('errors.php'); ?>
<input type="text" name="del">
<button type="submit" name="delete" class="button">Deactivate my Account</button></form>
</div>
</div>
</div>
</div>
<div class="footer_short">
<?php include('footer.php') ?>
</div>
</html>