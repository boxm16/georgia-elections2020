<?php

require_once 'Dao/DataBaseConnection.php';
require_once 'Model/Party.php';
$DataBaseConnection = new DataBaseConnection();
$db_connection = $DataBaseConnection->getConnection();

$image_length = 800;
$image_heigth = 400;

$total_votes = 0;
$total_parties = 0;
$parties = array();
//creating image
$image = imagecreatetruecolor($image_length, $image_heigth);
$color_white = imagecolorallocate($image, 255, 255, 255);
$color_blue = imagecolorallocate($image, 0, 0, 255);
$color_red = imagecolorallocate($image, 255, 0, 0);
$color_green = imagecolorallocate($image, 0, 255, 0);
$color_black = imagecolorallocate($image, 0, 0, 0);
$image_background_color = $color_white;
$candidate_colore = $color_blue;
$border_color = $color_red;
$query = "SELECT * FROM elections ORDER BY votes DESC, party_number ASC";
if (!($result = @$db_connection->query($query))) {
    echo 'Could not connect to db<br />';
    exit;
}
while ($row = $result->fetch_object()) {
    //calculate total vores
    $total_votes += $row->votes;
    $total_parties = $total_parties + 1;
    //create and fill a party
    $party_logo_name = $row->party_logo_name;
    $party_name = $row->party_name;
    $party_number = $row->party_number;
    $party_color = $row->party_color;

    $votes = $row->votes;
    $party = new Party();
    $party->setParty_logo_name($party_logo_name);
    $party->setParty_number($party_number);
    $party->setParty_name($party_name);
    $party->setParty_color($party_color);
    $party->setVotes($votes);
    array_push($parties, $party);
}

$result->data_seek(0);

//creaing "canvas" to draw on
imagefilledrectangle($image, 0, 0, $image_length, $image_heigth, $image_background_color);


$candidate_block_width = $image_length / $total_parties;
$canditate_block_start_point = 0;
$canditate_block_end_point = $canditate_block_start_point + $candidate_block_width;
$main_size = 12;
$font = 'C:\WINDOWS\Fonts\arial.ttf';
for ($x = 0; $x < count($parties); $x++) {
    $party = $parties[$x];


    if ($total_votes > 0) {
        $percent = round((($party->getVotes() / $total_votes) * 100), 2);
    } else {
        $percent = 0;
    }
    $party_color = $party->getParty_color();

//create colors for $image and fill the color array with them
    $color = imagecolorallocate($image, (int) $party_color[0], (int) $party_color[1], (int) $party_color[2]);



    $pole_point = ($image_heigth - 100) / 100;


    $candidate_pole = $canditate_block_start_point + ($candidate_block_width / 2);
    imagefilledrectangle($image, $candidate_pole - 20, $image_heigth - 45, $candidate_pole + 20, $image_heigth - 45 - ($pole_point * $percent), $color);

    $logo = $party->getResizedLogo();
    imagecopy($image, $logo, $candidate_pole - 20, $image_heigth - 40, 0, 0, 40, 40);


    //imagettftext($image, $main_size, 0, $candidate_pole - 40, $image_heigth - ($pole_point * $percent) - 40, $color, $font, $party->getParty_name());
    imagettftext($image, $main_size, 0, $candidate_pole - 20, $image_heigth - ($pole_point * $percent) - 55, $color_black, $font, $percent . '%');


    $canditate_block_start_point = $canditate_block_start_point + $candidate_block_width - 1;
    $canditate_block_end_point = $canditate_block_start_point + $candidate_block_width;
}
Header('Content-type:image/png');
imagepng($image);
imagedestroy($image);
imagedestroy($logo);










