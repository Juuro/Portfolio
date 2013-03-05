<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

$reqfilename = basename($_SERVER['PHP_SELF'], ".php");

$cachefile = "cache/".$reqfilename.".html";


// Serve from the cache if it is the same age or younger than the last 
// modification time of the included file (includes/$reqfilename)

if (file_exists($cachefile) && (filemtime($reqfilename.".php") < filemtime($cachefile))) {

    include($cachefile);
    
    echo "<!-- Cached ".date('H:i', filemtime($cachefile))." 
    -->";
    
    
    exit;
}


 // start the output buffer
ob_start();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sebastian Engel — Portfolio</title> 

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Miss+Fajardose' rel='stylesheet' type='text/css'>
    
    <link href="css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="css/print.css" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
        <link href="/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->
    
    <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {
           /* filter: none; */
        }
      </style>
    <![endif]--> 
</head>

<body>
    <div class="vignette"></div>
    
    <header>
        <h1><a href="cv.html">Sebastian Engel</a></h1>
        <h2>Portfolio</h2>        
    </header>
    
    <section id="navWrapper">
        <nav id="menu" class="menu gradient" role="navigation">
            <ul>
                <li class="marker"></li>
                <li class="item"><a href="#all" data-filter="*">All</a></li>
                <li class="item"><a href="#webdev" data-filter=".webdev">Webdevelopment</a></li>
                <li class="item"><a href="#scripts" data-filter=".scripts">Scripts</a></li>
                <li class="item"><a href="#apps" data-filter=".apps">Apps</a></li>
                <li class="item"><a href="#photo" data-filter=".photo">Photography</a></li>
                <li class="item"><a href="#ps" data-filter=".ps">Graphic design</a></li>
            </ul>
        </nav>
    </section>
    
    <section id="blocksWrapper">
        
        <?php
        
        include 'php/functions.php';  
        
        $blocksArray = array_merge(webdev(), scripts(), photo(), ps(), apps()); 
        shuffle($blocksArray);
        
        foreach($blocksArray as $key => $value) {
            echo $value;
        }
        
        ?>
                
    </section>
    
    <noscript>
        <div class="noscript">
            <p>In order for this site to work as intended, you should enable JavaScript in your browser.</p>
        </div>
    </noscript>

    <footer>
        <ul>
            <li><a href="sources.html">Sources</a></li>
        </ul>
        <ul>
            <li><a href="imprint.html">Imprint</a></li>
        </ul>
        <ul>
            <li><a href="contact.html">Contact</a></li>            
        </ul>
        <ul>
            <li><a href="cv.html">Curriculum vitae</a></li>
        </ul>
    </footer>
    
    <script type="text/javascript" src="js/jquery-latest.pack.js"></script>
    <script type="text/javascript" src="js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="js/isotope.min.js"></script>
    <script type="text/javascript" src="js/script.min.js"></script>   
    
</body>
</html>

<?php

// open the cache file for writing
$fp = fopen($cachefile, 'w');

 // save the contents of output buffer to the file
fwrite($fp, ob_get_contents());

 // close the file
fclose($fp);

 // Send the output to the browser
ob_end_flush();

?>