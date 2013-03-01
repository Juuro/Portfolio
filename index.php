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
                <li class="item"><a href="#photo" data-filter=".photo">Photography</a></li>
                <li class="item"><a href="#ps" data-filter=".ps">Photoshop</a></li>
            </ul>
        </nav>
    </section>
    
    <section id="blocksWrapper">
        
        <?php
        
        include 'php/functions.php';  
        
        $blocksArray = array_merge(photo(), ps()); 
        shuffle($blocksArray);
        
        foreach($blocksArray as $key => $value) {
            echo $value;
        }
        
        ?>
        
        
        
        
        <div class="cont scripts">
            <div class="block">
                <div class="front gradient">FRONT</div>
                <div class="back gradient">BACK</div>
            </div>
        </div>
        <div class="cont webdev">            
            <div class="block">
                <div class="front gradient">CSS3</div>
                <div class="back gradient">BACK</div>
            </div> 
        </div>
        <div class="cont scripts">            
            <div class="block">
                <div class="front gradient">... on Rails</div>
                <div class="back gradient">BACK</div>
            </div> 
        </div>
        <div class="cont webdev">            
            <div class="block">
                <div class="front gradient">Was mit Medien.</div>
                <div class="back gradient">BACK</div>
            </div> 
        </div>
        <div class="cont webdev">            
            <div class="block">
                <div class="front gradient">PHP und so.</div>
                <div class="back gradient">BACK</div>
            </div> 
        </div>   
        <div class="cont scripts">            
            <div class="block">
                <div class="front gradient">Ruby</div>
                <div class="back gradient">BACK</div>
            </div> 
        </div>
        <div class="cont webdev">
            <div class="block">
                <div class="front gradient">HTML5</div>
                <div class="back gradient">BACK</div>
            </div>
        </div>
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
