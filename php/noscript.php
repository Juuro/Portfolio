<?php

$name = check_input($_POST["name"]);
$emailaddress = check_input($_POST["emailaddress"]);
$message = check_input($_POST["message"]);

$data = array();

$url = "http://localhost/~juuro/portfolio/php/send.php";
$data["name"] = $name;
$data["emailaddress"] = $emailaddress;
$data["message"] = $message;

$result = post_request($url, $data, $referer='');

// print_r($result);

if ($result["content"] != "true"){
    echo "<! doctype html>
    <html>
    <head>
    <meta http-equiv=\"refresh\" content=\"0; URL=../contact.html\">
    <!-- ... andere Angaben im Dateikopf ... -->
    </head>
    <body>
    Sie werden zu http://blog.twoseb.de weitergeleitet....
    <br />
    <br />
    <br />
    Wenn Sie nach 5 Sekunden nicht weitergeleitet werden, klicken Sie bitte <a href=\"http://blog.twoseb.de\">hier</a>!
    </body>
    </html>"; 
}
else {
   
   echo "<! doctype html>
   <html>
   <head>
   <meta http-equiv=\"refresh\" content=\"0; URL=../thankyou.html\">
   <!-- ... andere Angaben im Dateikopf ... -->
   </head>
   <body>
   Sie werden zu http://blog.twoseb.de weitergeleitet....
   <br />
   <br />
   <br />
   Wenn Sie nach 5 Sekunden nicht weitergeleitet werden, klicken Sie bitte <a href=\"http://blog.twoseb.de\">hier</a>!
   </body>
   </html>";
}

function post_request($url, $data, $referer='') {

    // Convert the data array into URL Parameters like a=b&foo=bar etc.
    $data = http_build_query($data);

    // parse the given URL
    $url = parse_url($url);

    if ($url['scheme'] != 'http') { 
        die('Error: Only HTTP request are supported !');
    }

    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];

    // open a socket connection on port 80 - timeout: 30 sec
    $fp = fsockopen($host, 80, $errno, $errstr, 30);

    if ($fp){

        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");

        if ($referer != '')
            fputs($fp, "Referer: $referer\r\n");

        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: ". strlen($data) ."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);

        $result = ''; 
        while(!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }
    }
    else { 
        return array(
            'status' => 'err', 
            'error' => "$errstr ($errno)"
        );
    }

    // close the socket connection:
    fclose($fp);

    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);

    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';

    // return as structured array:
    return array(
        'status' => 'ok',
        'header' => $header,
        'content' => $content
    );
}

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>