<?php
	$db = mysqli_connect('localhost', 'root', 'root', 'seo');
	$username = $_SESSION['username'];
    $result = mysqli_query($db, "SELECT * FROM user WHERE username='$username'");
    while ($row = $result->fetch_assoc()) {
    $fullname= $row['fullname'];
    $website= $row['website'];
    $url= $row['url'];
    $email= $row['email'];
}
	$res = mysqli_query($db, "SELECT * FROM site WHERE url='$url'");
    while ($row = $res->fetch_assoc()) {
    $webp= $row['webpage'];
    $error= $row['error'];
    $warning= $row['warning'];
    $optimized= $row['optimized'];
}
?>
