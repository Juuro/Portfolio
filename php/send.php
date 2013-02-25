<?php

// validation

$name = check_input($_POST["name"]);
$emailaddress = check_input($_POST["emailaddress"]);
$message = check_input($_POST["message"]);

$to = "portfolio@sebastian-engel.de";
$subject = "Mail from ".$name;
$message;

$extra = "From: $name <$emailaddress>\n";

if (strlen($name) < 2) {
    echo json_encode(false);
    return;
}

if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(false);
    return;
}

if (str_word_count($message) < 3) {
    echo json_encode(false);
    return;
}

if (mail($to, $subject, $message, $extra)) {
    echo json_encode(true);
    return;
} else {
    echo json_encode(false);
    return;
}

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>