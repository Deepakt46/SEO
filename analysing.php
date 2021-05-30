<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>
<?php include('du.php') ?>
<!DOCTYPE html>
<html>
<head>
<title>Analysing Report | SWS</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  <div id="container">
<div class="header">
<div class="top-head">
    <div class="top-left"><div class="logo"><a href="/">sws</a></div></div>
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
<?php
$page = "";
$keywordtext = "";
$keyword = "";
$webpage = "";
$htmlfile = "";
$webfile = "";
$errors = array();
if (isset($_POST['analyse'])) {
  $page = mysqli_real_escape_string($db, $_POST['page']);
  $keywordtext = mysqli_real_escape_string($db, $_POST['keywordtext']);
  if ($page == "Type your webpage url..." || empty($page)) { array_push($errors,  "<div class='error_msg'>* Webpage URL is required</div>"); }
  if ($keywordtext == "Type your keyword..." || empty($keywordtext)) { array_push($errors, "<div class='error_msg'>* Keyword is required</div>"); }
  if (preg_match('/\s/',$page) ) {array_push($errors, "<div class='error_msg'>* Ensure that the value entered is a webpage url</div>");}
  $webpage = $url . '/' .$page;
  include('errors.php');
  if (count($errors) == 0) {
?>
  <h2>Onpage SEO report of <?php echo $website; ?></h2>
  <h3 class="webpage">Webpage: <span class="analysewebpage"><?php echo $webpage; ?></span></h3>
  <div id="piechart" class="piechart"></div>
  <?php
  $htmlfile = file_get_contents('http://'.$webpage);
  $webfile = $website . '.html';
  file_put_contents("websites/" .$webfile, $htmlfile);
  $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
  $DOCUMENT_ROOT .=  "/seo/websites/";
  $file = $DOCUMENT_ROOT . ''. $webfile;          //Root address of the source code

$filepointer = fopen($file, "r");           //File pointer for the files
$keyword="";
$keyword=$keywordtext;                        //Target Keyword
$metadescription="";                  //Meta Description
$metakeywordarray=array();

$URL=$webpage;
$urlkeywordcount;                   //count of keywords in URL
$urllength;                       //URL length


$countofkey=0;                      //Total count of key except in h1,h2 & title
$countofh1=0;                     //Count of h1
$countofh2=0;                     //Count of h2
$countofh3=0;                     //Count of h3


$contentnumberofwords=0;          //Count of words in Content (total)
$countofkeyincontentbeforehundred=0;    //Count of Key in content before hundred
$totalcountofkeysincontent=0;       //Total count of keys in content
$wordsinparalessthanhundredflag=0;      //Flag used to detect hundred words in content
$keyworddensity=0;              //Keyword Density
$countofkeyinboldincontent=0;       //Count of keyword in bold in content
$countofkeyinitalicsincontent=0;      //Count of keyword in italics in content
$countofkeyinunderlineincontent=0;      //Count of keyword in underline in content
$countofkeyinlinktext=0;          //Count of keyword in link text (used as flag)
$countofsitemaphtml=0;            //Count of sitemap.html in link (used as flag)
$countofsitemapxml=0;           //Count of sitemap.xml in link (used as flag)

$countoferror=0;              //Count of Error throughout the file
$countofwarning=0;              //Count of Warning throughout the file
$countofoptimised=0;            //Count of Optimized throughout the file

$imagefilenamekeywordcount=0;      //Count of keyword in image's file name
$imagefilenamekeywordnotfoundcount=0;   //Count of images which doesnt have keyword in it's file name
$imagealttextkeywordcount=0;      //Count of keyword in image's Alternate text
$imagealttextkeywordnotfoundcount=0;    //Count of images which doesnt have keyword in it's alternate text
$imagefilenameunderscorecount=0;        //Count of underscores in file name of the image
$imagewithoutalttextcount=0;            //Count of images without alternate texts


rewind($filepointer);    //rewinding filepointer to the starting point

?>
<script>
$(document).ready(function(){
    $("#cond1").click(function(){
        $("#tog1").slideToggle();
    });
});
</script>
<div class="section">
  <button class="condition" id="cond1"><h3>Meta Description</h3></button>
  <div id="tog1" class="taggle">
<?php
//selecting Meta description
while(!feof($filepointer))
{
  $line= fgets($filepointer);

  if(stripos($line, 'name="description"') !== false || stripos($line, "og:description") !== false || stripos($line, "twitter:description") !== false)
  {

    $first = stripos($line , "content=")+9;
    $second = strlen($line);
    $string = substr($line, $first, $second);
    $array=explode('"',$string);
    $GLOBALS['metadescription']=$array[0];
    echo "Meta Description Character Count is " .strlen($GLOBALS['metadescription']);

    if(strlen($GLOBALS['metadescription'])>160)
    {
      echo "<li class='anlist'><span class='warn'>Warning</span> : Description contains more than 160 characters</li>";
      $GLOBALS['countofwarning']++;
    }
    else if(strlen($GLOBALS['metadescription'])<160)
    {
      echo "<li class='anlist'><span class='opt'>Optimized</span> : Description contains less than 160 characters</li>";
      $GLOBALS['countofoptimised']++;
    }

    $x=stripos(strtolower($GLOBALS['metadescription']) , strtolower($GLOBALS['keyword']));
    if($x==NULL)
    {
      echo "<li class='anlist'><span class='warn'>Warning</span> : Meta Description doesnt contain keyword</li>";
      $GLOBALS['countofwarning']++;
    }
    else
    {
      echo "<li class='anlist'><span class='opt'>Optimized</span> : Meta Description contains keyword</li>";
      $GLOBALS['countofoptimised']++;
    }
    break;
  }

  if(stripos($line,"</head>") !== false)
  {
    break;
  }
}
if(strlen($GLOBALS['metadescription'])==0 || strlen($GLOBALS['metadescription'])==NULL)       //If no meta description found
  {
    echo "<li class='anlist'><span class='err'>Error</span> : Description not found</li>";
    $GLOBALS['countoferror']++;
  }

?>
</div>
</div>
<script>
$(document).ready(function(){
    $("#cond2").click(function(){
        $("#tog2").slideToggle();
    });
});
</script>
<div class="section">
  <button class="condition" id="cond2"><h3>Webpage URL</h3></button>
  <div id="tog2" class="taggle">
<?php

    //Checking the URL
    $keyurl = str_replace(" ", "-", $GLOBALS['keyword']);
    $urlkeywordcount = substr_count(strtolower($URL),strtolower($keyurl));
    echo "URL contains the keyword ".$urlkeywordcount. " times";

    if(stripos($URL,'_')!==false)
    {
      echo "<li class='anlist'><span class='warn'>Warning</span> : URL contains underscores. Try to eliminate them </li>";
      $GLOBALS['countofwarning']++;
    }
    else
    {
      echo "<li class='anlist'><span class='opt'>Optimized</span> : URL doesn't contain underscores </li> ";
      $GLOBALS['countofoptimised']++;
    }

    $urllength = strlen($URL);
    echo "URL length : ".$urllength. " ";

    if($urllength>3 && $urllength<30)
    {
      echo "<li class='anlist'><span class='opt'>Optimized</span> : Your URL is SEO friendly</li>";
      $GLOBALS['countofoptimised']++;
    }
    else if($urllength>30 && $urllength<70)
    {
      echo "<li class='anlist'><span class='warn'>Warning</span> : You can improve your URL length</li>";
      $GLOBALS['countofwarning']++;
    }
    else if($urllength>70)
    {
      echo "<li class='anlist'><span class='err'>Error</span> : Your URL is too big</li>";
      $GLOBALS['countoferror']++;
    }
?>
</div>
</div>
<?php
//Counting the number of times the keyword comes in tags except h1 , h2, title
function countkey($string)
{
  $GLOBALS['countofkey']=$GLOBALS['countofkey']+substr_count(strtolower($string),strtolower($GLOBALS['keyword']));
}

rewind($filepointer);    //rewinding filepointer to the starting point

//Selecting line by line from sourcecode and checking the tags
while(!feof($filepointer))
{
  $line= fgets($filepointer);

  //for checking sitemap.html and .xml
  if(stripos($line, "<a ") !== false)
  {
    $second=0;
    for($i=0; $i<str_word_count($line); $i++)
    {
      $start = stripos($line, "<a" ,$second) +3;
      $first = stripos($line, ">", $start ) +1;
      $stringtocheckforsitemap = substr($line, $start, $first);
      $GLOBALS['countofsitemaphtml'] = substr_count(strtolower($stringtocheckforsitemap), "sitemap.html" );
      $GLOBALS['countofsitemapxml'] = substr_count(strtolower($stringtocheckforsitemap), "sitemap.xml" ) ;
    }
  }

  //Counting the characters in h1
  if(stripos($line, "<h1") !== false)
    {
      $start = stripos($line, "<h1 ") +4;
      $first = stripos($line, ">", $start ) +1;
      $second = stripos($line, "</h1>",$first);
      $a = substr($line, $first, $second);
      $string = strip_tags($a);
      $GLOBALS['countofh1']++;
    }

  //Counting the characters in h2
  if(stripos($line, "<h2") !== false)
    {
      $start = stripos($line, "<h2 ") +4;
      $first = stripos($line, ">", $start ) +1;
      $second = stripos($line, "</h2>",$first);
      $a = substr($line, $first, $second);
      $string = strip_tags($a);
      $GLOBALS['countofh2']++;
    }

  // Counting the characters in h3
  if(stripos($line, "<h3") !== false)
    {
      $start = stripos($line, "<h3 ") +4;
      $first = stripos($line, ">", $start ) +1;
      $second = stripos($line, "</h3>",$first);
      $a = substr($line, $first, $second);
      $string = strip_tags($a);
      countkey($string);                //adding the number of keys in h3 to the total count of keys
      $GLOBALS['countofh3']++;
    }

//Counting the character in paragraphs
  if(stripos($line, "<p") !== false)
    {
      $start = stripos($line, "<p") +2;
      $first = stripos($line, ">", $start ) +1;
      $second = stripos($line, "</p>",$first);

      $a = substr($line, $first, $second);
      $string = $a;

      countkey($string);    //adding the number of keys in content to the total count of keys

    // checking the whether img tags has alternate texts
      if(stripos($string, "<img") !== false)
        {
          $first = stripos($string , "<img")+1;
          $second = stripos($string, ">", $first);
          $stringimg = substr($string, $first, $second);

          //image file name
          $first = stripos($stringimg , "name=")+6;
          $second = strlen($stringimg);
          $nme = substr($stringimg, $first, $second);
          $array=explode('"',$nme);
          $nme=$array[0];
          $keycount=substr_count(strtolower($nme),strtolower($GLOBALS['keyword']));

          if($keycount==0)
          {
             $GLOBALS['imagefilenamekeywordnotfoundcount']++;           //image name doesnt contain the keyword
          }
          else
          {
            $GLOBALS['imagefilenamekeywordcount']++;                    //image name contains the keyword
          }

          if(strpos($nme,'_') !=0)
          {
            $GLOBALS['imagefilenameunderscorecount']++;                 //image name contains underscores
            $GLOBALS['countofwarning']++;
          }
          else
          {
             $GLOBALS['countofoptimised']++;                             //image name does not contain underscores
          }

          //image alternative text
          if(stripos($stringimg,"alt"))
          {
            $first = stripos($stringimg , "alt=")+5;
            $second = strlen($stringimg);
            $alt = substr($stringimg, $first, $second);
            $array=explode('"',$alt);
            $alt=$array[0];
            countkey($alt);               //adding the number of keys in img alt to the total count of keys
            $keycount=substr_count(strtolower($alt),strtolower($GLOBALS['keyword']));
            if($keycount==0)
            {
              $GLOBALS['imagealttextkeywordnotfoundcount']++;           //image altername text doesnt contain keywords
            }
            else
            {
              $GLOBALS['imagealttextkeywordcount']++;                   //image alternate text contains the keyword
            }
          }
          else
          {
            $GLOBALS['imagewithoutalttextcount']++;                   //images without alternate texts
            $GLOBALS['countoferror']++;
            $GLOBALS['imagealttextkeywordnotfoundcount']++;           //image altername text doesnt contain keywords

          }

        }

      //checking for bold keywords
      if(strpos($string, "<b>" ) !== false)
      {
        for($i=0; $i<str_word_count($string); $i++)
        {
          $first = strpos($string, "<b>" ) +3;
          $second = strpos($string, "</b>",$first);
          $boldstring = substr($string, $first, $second );
          $GLOBALS['countofkeyinboldincontent']=$GLOBALS['countofkeyinboldincontent']+substr_count(strtolower($boldstring),strtolower($GLOBALS['keyword']) );
        }
      }

      //checking for italics keywords
      if(strpos($string, "<i>" ) !== false)
      {
        for($i=0; $i<str_word_count($string); $i++)
        {
          $first = strpos($string, "<i>" ) +3;
          $second = strpos($string, "</i>",$first);
          $italicsstring = substr($string, $first, $second );
          $GLOBALS['countofkeyinitalicsincontent']=$GLOBALS['countofkeyinitalicsincontent']+substr_count(strtolower($italicsstring),strtolower($GLOBALS['keyword']) );
        }
      }

      //checking for underlined keywords
      if(strpos($string, "<u>" ) !== false)
      {
        for($i=0; $i<str_word_count($string); $i++)
        {
          $first = strpos($string, "<u>" ) +3;
          $second = strpos($string, "</u>",$first);
          $underlinedstring = substr($string, $first, $second );
          $GLOBALS['countofkeyinunderlineincontent']=$GLOBALS['countofkeyinunderlineincontent']+substr_count(strtolower($underlinedstring),strtolower($GLOBALS['keyword'] ));
        }
      }

      //checking for keywords in Hyperlinks
      if(strpos($string, "<a " ) !== false)
      {
        $second=0;
        for($i=0; $i<str_word_count($string); $i++)
        {
          $start = strpos($string, "<a" ,$second) +3;
          $first = strpos($string, ">", $start ) +1;
          $second = strpos($string, "</u>",$first);
          $linktextstring = substr($string, $first, $second );
          $GLOBALS['countofkeyinlinktext'] = substr_count(strtolower($linktextstring),strtolower($GLOBALS['keyword']));
          $second = $second+4;
        }
      }

      $GLOBALS['totalcountofkeysincontent']=$GLOBALS['totalcountofkeysincontent'] + substr_count(strtolower($string), strtolower($GLOBALS['keyword']));
      $GLOBALS['contentnumberofwords']=$GLOBALS['contentnumberofwords']+str_word_count($string);

      if($GLOBALS['wordsinparalessthanhundredflag']==0)
      {
        if($GLOBALS['contentnumberofwords']<100)
        {
          $GLOBALS['countofkeyincontentbeforehundred'] = $GLOBALS['countofkeyincontentbeforehundred'] + substr_count(strtolower($string),strtolower($GLOBALS['keyword']));
        }

        if($GLOBALS['contentnumberofwords']>100)
        {
          $GLOBALS['wordsinparalessthanhundredflag']=1;
        }
      }
      countkey($string);
    }

// Counting the character in Title
  if(stripos($line, "<title>") !== false)
    {
      $first = stripos($line , "<title>") + 7;
      $second = stripos($line, "</title>", $first);
      $a = substr($line, $first, $second);
      $string = strip_tags($a);
 ?>
    <script>
$(document).ready(function(){
    $("#cond3").click(function(){
        $("#tog3").slideToggle();
    });
});
</script>
<div class="section">
  <button class="condition" id="cond3"><h3>Title</h3></button>
  <div id="tog3" class="taggle">
<?php
      if(strlen($string)>70)
      {
        echo "<li class='anlist'><span class='warn'>Warning</span> : Title is too long</li>";
        $GLOBALS['countofwarning'];
      }
      else if(strlen($string)<70)
      {
        echo "<li class='anlist'><span class='opt'>Optimized</span> : Title is Optimized</li>";
        $GLOBALS['countofoptimised'];
      }

      $keywordcount = substr_count(strtolower($string),strtolower($GLOBALS['keyword']));

      if($keywordcount!=0)
        { echo "Targeted Keyword found on Title ";
          if(stripos($string, $GLOBALS['keyword'])==0)
          {
            echo "<li class='anlist'><span class='opt'>Optimized</span> : Keyword found as the first word in title</li>";
            $GLOBALS['countofoptimised']++;
          }
          else
          {
            echo "<li class='anlist'><span class='warn'>Warning</span> : Targeted keyword not the first word in title ";
            $GLOBALS['countofwarning'];
          }
        }
        else
        {
          echo "<li class='anlist'><span class='warn'>Warning</span> : Targeted keyword not found in title";
          $GLOBALS['countofwarning'];
          echo "<li class='anlist'><span class='warn'>Warning</span> : Targeted keyword not the first word in title ";
          $GLOBALS['countofwarning'];
        }

?>
</div></div><?php
    }
  }

//Checking the
         ?>
    <script>
$(document).ready(function(){
    $("#cond5").click(function(){
        $("#tog5").slideToggle();
    });
});
</script>
<div class="section">
  <button class="condition" id="cond5"><h3>Headings</h3></button>
  <div id="tog5" class="taggle">
<?php
if($countofh1 == 0)
{
  echo "<li class='anlist'><span class='err'>Error</span> : No H1 tags found</li>";
  $GLOBALS['countoferror']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : H1 tags found</li>";
  $GLOBALS['countofoptimised']++;
}

if($countofh2 == 0)
{
  echo "<li class='anlist'><span class='err'>Error</span> : No H2 tags found</li>";
  $GLOBALS['countoferror']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : H2 tags found</li>";
  $GLOBALS['countofoptimised']++;
}

if($countofh3 == 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : No H3 tags found</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : H3 tags found</li>";
  $GLOBALS['countofoptimised']++;
}
?>
</div></div>
<?php
?>
    <script>
$(document).ready(function(){
    $("#cond6").click(function(){
        $("#tog6").slideToggle();
    });
});
</script>
<div class="section">
  <button class="condition" id="cond6"><h3>Content</h3></button>
  <div id="tog6" class="taggle">
<?php
echo "Total document contain the keywords ".$countofkey. " times";
if($countofkeyincontentbeforehundred == 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : No keyword before 100 words in the content</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Keyword found before 100 words in the content</li>";
  $GLOBALS['countofoptimised']++;
}

if($contentnumberofwords < 1800)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : Improve your content words to 1800+ words</li>";
  $GLOBALS['countofwarning']++;
}
else if($contentnumberofwords > 1800)
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Your content is of good length</li>";
  $GLOBALS['countofoptimised']++;
}

$keyworddensity = $totalcountofkeysincontent / $contentnumberofwords * 100;       //Calculating keyword density

if($keyworddensity>1 && $keyworddensity<8)
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Optimum use of keywords</li>";
  $GLOBALS['countofoptimised'];
}
else if($keyworddensity < 1)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : Less use of keywords. Improve usage of keywords</li>";
  $GLOBALS['countofwarning']++;
}
else if($keyworddensity > 8)
{
  echo "<li class='anlist'><span class='err'>Error</span> : Too many keywords</li>";
  $GLOBALS['countoferror']++;
}

if($countofkeyinboldincontent == 0 && $countofkeyinitalicsincontent == 0 && $countofkeyinunderlineincontent == 0 )
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : No keyword in bold/italics/underlined</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Content includes keywords in bold/italics/underlined</li>";
  $GLOBALS['countofoptimised']++;
}


if($countofkeyinlinktext == 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : Hyperlink texts doesnt include Keywords</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Hyperlink texts include Keywords</li>";
  $GLOBALS['countofoptimised']++;
}

if($countofsitemaphtml == 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : Website doesnt contain sitemap.html</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Website contains sitemap.html</li>";
  $GLOBALS['countofoptimised']++;
}

if($countofsitemapxml == 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : Website doesnt contain sitemap.xml</li>";
  $GLOBALS['countofwarning']++;
}
else
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Website contains sitemap.xml</li>";
  $GLOBALS['countofoptimised']++;
}

if($imagefilenamekeywordnotfoundcount > 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : ".$imagefilenamekeywordnotfoundcount." image(s) doesnt have keyword in it's file name</li>";
  $GLOBALS['countofwarning']++;
}
if($imagefilenamekeywordnotfoundcount==0 && $imagefilenamekeywordcount>0)
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Images have keywords in it's file name</li>";
  $GLOBALS['countofoptimised']++;
}

if($imagefilenameunderscorecount==0)
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Images doesnt have underscores in it's file name</li>";
  $GLOBALS['countofoptimised']++;
}
else
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : ".$imagefilenameunderscorecount." image(s) have underscores in its file name</li>";
  $GLOBALS['countofwarning']++;
}

if($imagealttextkeywordnotfoundcount > 0)
{
  echo "<li class='anlist'><span class='warn'>Warning</span> : ".$imagealttextkeywordnotfoundcount." image(s) doesnt have keyword in it's alternate text</li>";
  $GLOBALS['countofwarning']++;
}
if($imagealttextkeywordnotfoundcount==0 && $imagealttextkeywordcount>0)
{
  echo "<li class='anlist'><span class='opt'>Optimized</span> : Images have keywords in it's alternate text</li>";
  $GLOBALS['countofoptimised']++;
}

if($imagewithoutalttextcount > 0)
{
  echo "<li class='anlist'><span class='err'>Error</span> : ".$imagewithoutalttextcount." image(s) doesnt have an alternate text</li>";
}

?></div></div><?php
$err=$GLOBALS['countoferror'];
$warn=$GLOBALS['countofwarning'];
$opt=$GLOBALS['countofoptimised'];
$site_check_query = "SELECT * FROM site WHERE url='$url' LIMIT 1";
$result = mysqli_query($db, $site_check_query);
$site = mysqli_fetch_assoc($result);
if ($site) { // if site exists
    if ($site['url'] === $url) {
    $que = "UPDATE site SET webpage = '$webpage', Error = '$err', Warning = '$warn', optimized = '$opt' WHERE url='$url'";
    mysqli_query($db, $que);
    }
}
    else {
    $que = "INSERT INTO site (url, webpage, Error, Warning, optimized)
              VALUES('$url', '$webpage', '$err', '$warn', '$opt')";
    mysqli_query($db, $que);
}
$Q1 = $opt;
 $Q2 = $err;
 $Q3 = $warn;

 $pieData = array(
              array('Quarter', 'Number'),
              array('Optimized', (double)$Q1),
              array('Error', (double)$Q2),
              array('Warning', (double)$Q3)
);

 $jsonTable = json_encode($pieData);
 ?><script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable(
        <?php  echo $jsonTable; ?>
    );

    var options = {
      title: "SEO Report"
    };

    var chart = new google.visualization.PieChart(document.getElementById("piechart"));

    chart.draw(data, options);
  }
</script><?php
}
else {
    ?><div class="analyseform"><form action="analysing.php" align="center" method="POST">
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
<?php }
}
}
?>
</div>
</div>
</div>
<div class="footer_long">
<?php include('footer.php') ?>
</div>
</html>
