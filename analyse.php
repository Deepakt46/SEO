<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
} include('du.php');
  $chk = "SELECT * FROM site WHERE url='$url' LIMIT 1";
  $rlt = mysqli_query($db, $chk);
  $site = mysqli_fetch_assoc($rlt);
if ($site) { // if site exists
    if ($site['url'] === $url) {
 $Q1 = $optimized;
 $Q2 = $error;
 $Q3 = $warning;

 $pieData = array(
              array('Quarter', 'Number'),
              array('Optimized', (double)$Q1),
              array('Error', (double)$Q2),
              array('Warning', (double)$Q3)
);

 $jsonTable = json_encode($pieData);
}}
?>  
<!DOCTYPE html>
<html>
<head>
<title>Analyse | SWS</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable(
        <?php  echo $jsonTable; ?>
    );

    var options = {
      
    };

    var chart = new google.visualization.PieChart(document.getElementById("piechart"));

    chart.draw(data, options);
  }
</script>
</head>
<body>
	<div id="container">
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
        <li><a id="sidebaractive" href="analyse" type='active'>Analyse SEO</a></li>
        <li><a href="support">Support</a></li>
        <li><a href="account">Account</a></li>
    </div>
    <div class="content">
<h2>Analyse On-Page SEO</h2>
<span>Analyse &amp; auditor each page's SEO of <?php echo $url ?> by typing the page's url and clicking on "Analyse SEO" button.</span>
<div class="analyseform"><form action="analysing.php" align="center" method="POST">
<p><b><i><?php echo $url ?></i></b>/ <input type="text" name="page" class="urlpage" value="Type your webpage url..."  onfocus="this.value = this.value=='Type your webpage url...'?'':this.value;" onblur="this.value = this.value==''?'Type your webpage url...':this.value;"> <input type="text" class="keypage" name="keywordtext" value="Type your keyword..."  onfocus="this.value = this.value=='Type your keyword...'?'':this.value;" onblur="this.value = this.value==''?'Type your keyword...':this.value;"> <input type="submit" name="analyse" value="Analyse SEO" class="button"></p>
</form></div>
<?php
  $chk = "SELECT * FROM site WHERE url='$url' LIMIT 1";
  $rlt = mysqli_query($db, $chk);
  $site = mysqli_fetch_assoc($rlt);
if ($site) { // if site exists
    if ($site['url'] === $url) { ?>
<div>
<h3 class="webpage">Previous SEO Report of: <span class="analysewebpage"><?php echo $webp; ?></span></h3>
<div id="piechart" class="piechart"></div>
<?php
} }
else {
?>
<div class="help">
<h3 class="webpage">Would you like to know more about <span class="analysewebpage">On-page SEO</span>?</h3>
<p class="para">On-page SEO is the practice of optimizing individual webpages in order to rank higher and earn more relevant traffic from search engines. On-page refers to both the content and HTML source code of a page that can be optimized, as opposed to off-page SEO which refers to links and other external signals (basically known as backlinks).</p> <p class="para">By analysing here, you can monitor what all errors and warnings are there on your webpage; and so you can change them with your skill or with developer's. <a href="home">Learn More &gt;&gt; </a></p>
</div>
<?php }  ?>
</div>
</div>
</div>
</div>
<div class="footer_long">
<?php include('footer.php') ?>
</div>
</html>