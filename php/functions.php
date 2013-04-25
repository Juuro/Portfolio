<?php

function itunes() {
    $filename = "apps";    

    $string = file_get_contents("files/".$filename.".json");
    $blocksArray = array();

    $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($string, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

    foreach ($jsonIterator as $key => $val) {
        $app =  json_decode(get_data($val), true);
        $app = $app['results'][0];

        $title = $app['trackName'];
        $description = $app['description'];
        $url = $app['trackViewUrl'];
        $image = $app['artworkUrl60'];

$html = <<< EOT
<div class="cont $filename">
    <div class="block">
        <div class="front gradient">
            <h3>$title</h3>
            <div class="description">$description
                <div class="blender"></div>    
            </div>
        </div>
        <div class="back gradient">
            <h3>$title</h3>
            <img src="$image" class="appIcon">
            <a href="$url">view in iTunes</a>
        </div>
    </div>
</div>
EOT;
        $blocksArray[] = $html;

    }

    return $blocksArray;

}

function apps() {
    $filename = "apps";
    return github($filename);
}

function webdev() {
    $filename = "webdev";
    return github($filename);
}

function scripts() {
    $filename = "scripts";
    return github($filename);
}

function photo() {
    $filename = "photo";
    return deviantart($filename);
}

function ps() {
    $filename = "ps";
    return deviantart($filename);
}

function github($filename){
    $githubAuth = "?client_id=01a4c8a1b5de89a35313&client_secret=16d581468ffadf0137de5f790985c69622eae9e9";
    $string = file_get_contents("files/".$filename.".json");
    $blocksArray = array();

    $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($string, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

    foreach ($jsonIterator as $key => $val) {
        $url = $val.$githubAuth;       
        $repo = json_decode(get_data($url), true);
        if (!isset($repo['message']) || $repo['message'] != 'Not Found') {
            
            $repoName = $repo['name'];
            $repoDesc = $repo['description'];
            $repoLang = $repo['language'];
            $repoUrl = $repo['html_url'];
            $repoDemo = $repo['homepage'];
            $repoUpdated = date_create($repo['updated_at']);
            $repoUpdated = date_format($repoUpdated, 'd.m.Y');



$html = <<<EOT
<div class="cont $filename">
    <div class="block">
        <div class="front gradient">
            <h3>$repoName</h3>
            <div class="description">$repoDesc
                <div class="blender"></div>
            </div>            
        </div>
        <div class="back gradient">
            <h3>$repoName</h3>
            <a href="$repoUrl" class="url" data-icon="&#xe00f;"> view on GitHub</a>
EOT;

            if ($repoDemo != ""){
                $html .= "<a href=\"".$repoDemo."\" class=\"demo\" data-icon=\"&#xe01c;\"> demo</a>";                
            }            

$html .= <<<EOT
            <span class="lang">Programming language: $repoLang</span>
            <span class="updated">Updated: $repoUpdated</span>
        </div>
    </div>
</div>
EOT;


            $blocksArray[] = $html;
        }
    }

    return $blocksArray;
}

function deviantart($filename) {
    $oembedUrl = "http://backend.deviantart.com/oembed?url=";
    $string = file_get_contents("files/".$filename.".json");
    $blocksArray = array();

    $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($string, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

    $i = 0;
    foreach ($jsonIterator as $key => $val) {
        $url = $oembedUrl.$val;

        // picture cached?
        if (true){

        }
        else {

        }

        $photo = json_decode(get_data($url), true);
        $thumbUrl = $photo["thumbnail_url"];
        $photoUrl = $photo["url"];
        $photoTitle = $photo["title"];
        $photoWidth = $photo["width"];
        $photoHeight = $photo["height"];

        $backgroundSize = "160px 160px";
        if ($photoWidth >= $photoHeight) {
            //horizontal
            $backgroundSize = "auto 160px";
        }
        else {
            //vertical
            $backgroundSize = "160px auto";        
        }

$html = <<< EOT
<div class="cont $filename">
    <div class="block">
        <div class="front gradient" style="background:url('$photoUrl'); background-size: $backgroundSize; background-position: center; background-repeat:no-repeat;">

        </div>
        <div class="back gradient">
            <h3>$photoTitle</h3>
            <a href="$photoUrl" rel="lightbox[$filename]" title="$photoTitle" class="url" data-icon="&#xe01a;"> view full-size</a>
            <a href="$val" class="url da" data-icon="&#xe00c;"> view on deviantArt</a>
        </div>
    </div>
</div>
EOT;

        $blocksArray[] = $html;

        $i++;
    }

    return $blocksArray;
}

function get_data($url) {
    $ch = curl_init();
    $timeout = 5;

    if (strstr($url, "github") != false) {
        // set SSL certificate for GitHub
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/files/githubca.cer");
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $data = curl_exec($ch);

    if (curl_exec($ch) === false) {
        echo "cURL error: ".curl_error($ch);
    }

    curl_close($ch);

    return $data;
}

?>