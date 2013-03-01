<?php



function photo() {
    $filename = "photo";
    return deviantart($filename);
}

function ps() {
    $filename = "ps";
    return deviantart($filename);
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
        $photoUrl = $photo["thumbnail_url"];
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
            <a href="$val">$val</a>
        </div>
    </div>
</div>
EOT;
        
        $blocksArray[] = $html;
        
        $i++;
    }
    
    shuffle($blocksArray);
    return $blocksArray;
}

function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

?>