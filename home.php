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
?> 
<!DOCTYPE html>
<html>
<head>
<title>Home | SWS</title>
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
        <li><a id="sidebaractive" href="home">Home</a></li>
        <li><a href="analyse">Analyse SEO</a></li>
        <li><a href="support">Support</a></li>
        <li><a href="account">Account</a></li>
    </div>
    <div class="content">
<h2 class="conthead">Hello, <?php echo $_SESSION['username']; ?>! </h2>
<div class="helphome">
<h3 class="webpage">What are the factors in <span class="analysewebpage">On-page SEO</span>?</h3>
<p class="parahome">On-page SEO is the practice of optimizing individual web pages in order to rank higher and earn more relevant traffic in search engines. On-page refers to both the content and HTML source code of a page that can be optimized, as opposed to off-page SEO which refers to links and other external signals.</p>
<ol>
<li>Use SEO-Friendly URLs</li>
</ol>
<p>Google has stated that the first 3-5 words in a URL are given more weight. And our ranking factors study found that short URLs may have an edge in the search results.</p>
<p>So I recommend making your URLs short and sweet.</p>
<p>And always include your target keyword in your URL.</p>
<ol start="2">
<li>Start Title with Keyword</li>
</ol>
<p>Your title tag is the most important on-page SEO factor.</p>
<p>In general, the closer the keyword is to the beginning of the title tag, the more weight it has with search engines.</p>
<ol start="3">
<li>Add Modifiers to Your Title</li>
</ol>
<p>Using modifiers like “2018”, “best”, “guide”, “checklist” and “review” can help you rank for long tail versions of your target keyword.</p>
<ol start="4">
<li>Wrap Your Blog Post Title in an H1 Tag</li>
</ol>
<p>The H1 tag is your “headline tag”. Most CMS’s (like WordPress) automatically add the H1 tag to your blog post title. If that’s the case, you’re all set.</p>
<p>But some themes override this setting. Check your site’s code to make sure your title gets the H1 love it deserves.</p>
<ol start="5">
<li>Dazzle with Multimedia</li>
</ol>
<p>Text can only take your content so far. Engaging images, videos and diagrams can reduce bounce rate and increase time on site: two critical user interaction ranking factors.</p>
<ol start="6">
<li>Wrap Subheadings in H2 Tags</li>
</ol>
<p>Include your target keyword in at least one subheading and wrap it in an H2 tag.</p>
<ol start="7">
<li>Drop Keyword in First 100 Words</li>
</ol>
<p>Your keyword should appear in the first 100-150 words of your article.</p>
<ol start="8">
<li>Use Responsive Design</li>
</ol>
<p>Google started penalizing mobile unfriendly sites in 2015. And they’re likely crack down even more in the future. If you want to make your site mobile-friendly, I recommend Responsive Design.</p>
<ol start="9">
<li>Use Outbound Links</li>
</ol>
<p>This is an easy, white hat SEO strategy to get more traffic.</p>
<p>Outbound links to related pages helps Google figure out your page’s topic. It also shows Google that your page is a hub of quality info.</p>
<ol start="10">
<li>Use Internal Links</li>
</ol>
<p>Internal linking is SO money. Use 2-3 in every post.</p>
<ol start="11">
<li>Boost Site Speed</li>
</ol>
<p>Google has stated on the record that page loading speed is an SEO ranking signal (and they recently made PageSpeed even MORE important). You can boost your site speed by using a CDN, compressing images, and switching to faster hosting.</p>
<p>Make sure your site doesn’t take more than 4 seconds to load: MunchWeb found that 75% of users wouldn’t re-visit a site that took longer than 4 seconds to load.</p>
<ol start="12">
<li>Sprinkle LSI Keywords</li>
</ol>
<p>LSI keywords are synonyms that Google uses to determine a page’s relevancy (and possibly quality). Sprinkle them into every post.</p>
<ol start="13">
<li>Image Optimization</li>
</ol>
<p>Make sure at least one image file name includes your target keyword (for example, on_page_SEO.png) and that your target keyword is part of your image Alt Text.</p>
<ol start="14">
<li>Use Social Sharing Buttons</li>
</ol>
<p>Social signals may not play a direct role in ranking your site. But social shares generate more eyeballs on your content.</p>
<p>And the more eyeballs you get, the more likely someone is to link to you. So don’t be shy about placing social sharing buttons prominently on your site.</p>
<ol start="15">
<li>Post Long Content</li>
</ol>
<p>The SEO adage “length is strength” was supported by our industry study which found that longer content tends to rank significantly higher on Google’s first page.</p>
<p>Aim for at least 1800 words for every piece of content that you publish.</p>
<ol start="16">
<li>Boost Dwell Time</li>
</ol>
<p>If someone hits their back button immediately after landing on a page, it tells Google in black-and-white: this is low quality page.</p>
<p>That’s why Google uses “dwell time” to size up your content’s quality. Increase your average dwell time by writing long, engaging content that keeps people reading.</p>
<ol start="17">
<li>Quality Content</li>
</ol>
<p>Even though search engines have no direct way of determining quality, they have plenty of indirect methods, such as:</p>
<p>&#8211; Repeat visitors</p>
<p>&#8211; Chrome bookmarks</p>
<p>&#8211; Time on site</p>
<p>&#8211; Dwell time</p>
<p>&#8211; Google searches for your brand</p>
<p>In other words, great content definitely won’t hurt you. So there’s no reason NOT to publish awesome stuff every single time.</p>
<p>Encourage Blog Comments: I’ve long suspected that sites with lots of high-quality blog comments get a slight edge in Google’s search results.</p>
<ol start="18">
<li>Maximize Organic CTR</li>
</ol>
<p>There’s no doubt in my mind that Google uses organic click-through-rate as a ranking signal.</p>
<p>And even if they don’t, you STILL want to optimize your Google listing for CTR.</p>
<p>(More clicks=more traffic)</p>
<ol start="19">
<li>User Intent</li>
</ol>
<p>In other words, does your content match user intent? If not, it’s going to be VERY hard to rank (even if your page is keyword-optimized).</p>
<p>But if you create a page that makes users happy, Google is going to rocket you to the top of the SERPs.</p>
<div class="abtt"><a href="analyse" class="abtn">Analyse On-page SEO</a></div>
</div>
</div>
</div>
</div>
<div class="footer_long">
<?php include('footer.php') ?>
</div>
</html>