<?php

class Party {

    private $party_name;
    private $party_number;
    private $party_logo_name;
    private $party_color;
    private $party_color_HEX;
    private $votes;
    private $party_mandates;
    private $ghost_mandates;
    private $majoritarian_mandates = 0;

   

    public function setParty_name($party_name) {
        $this->party_name = $party_name;
    }

    public function setParty_number($party_number) {
        $this->party_number = $party_number;
    }

    public function setParty_logo_name($party_logo_name) {
        $this->party_logo_name = $party_logo_name;
    }

    public function setParty_color_HEX($party_color_HEX) {
        $this->party_color_HEX = $party_color_HEX;
    }

    public function setVotes($votes) {
        $this->votes = $votes;
    }

    public function setParty_color($party_color) {
        $this->party_color = $this->hex2rgb($party_color);
        
    }

    private function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    public function getParty_name() {
        return $this->party_name;
    }

    public function getParty_number() {
        return $this->party_number;
    }

    public function getParty_logo_name() {
        return $this->party_logo_name;
    }

    public function getParty_color() {
        return $this->party_color;
    }

    public function getVotes() {
        return $this->votes;
    }

    public function getGhost_mandates() {
        return $this->ghost_mandates;
    }

    public function getMajoritarian_mandates() {
        return $this->majoritarian_mandates;
    }

    public function getParty_mandates() {
        return $this->party_mandates;
    }

    public function setParty_mandates($party_mandates) {
        $this->party_mandates = $party_mandates;
    }

    public function setGhost_mandates($ghost_mandates) {
        $this->ghost_mandates = $ghost_mandates;
    }

    public function setMajoritarian_mandates($majoritarian_mandates) {
        $this->majoritarian_mandates = $majoritarian_mandates;
    }

    public function getGhostMandates() {
        return $this->ghost_mandates;
    }

    public function setGhostMandates($ghost_mandates) {
        $this->ghost_mandates = $ghost_mandates;
    }

    public function getParty_color_HEX() {
        return $this->party_color_HEX;
    }

    public function getResizedLogo() {
        $logo;
        $file = 'party_logos/' . $this->party_logo_name;

        $info = getimagesize($file);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $logo = imagecreatefromjpeg($file);
                break;

            case 'image/png':
                $logo = imagecreatefrompng($file);
                break;

            case 'image/gif':
                $logo = imagecreatefromgif($file);
                break;

            default:
                throw new Exception('Unsuported image type.');
        }

        $base_image = imagecreatetruecolor(40, 40);
        list($W, $H) = getimagesize($file);
        imagecopyresampled($base_image, $logo, 0, 0, 0, 0, 40, 40, $W, $H);

        return $base_image;
    }

    public function saveSeatLogo() {
        $filename = 'party_logos/' . $this->party_logo_name;
        $image_s = imagecreatefromstring(file_get_contents($filename));
        $width = imagesx($image_s);
        $height = imagesy($image_s);
        $newwidth = 40;
        $newheight = 40;
        $image = imagecreatetruecolor($newwidth, $newheight);
        // imagealphablending($image, true);
        imagecopyresampled($image, $image_s, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//create masking
        $mask = imagecreatetruecolor($newwidth, $newheight);
        $transparent = imagecolorallocate($mask, 255, 0, 0);
        imagecolortransparent($mask, $transparent);
        imagefilledellipse($mask, $newwidth / 2, $newheight / 2, $newwidth, $newheight, $transparent);
        $red = imagecolorallocate($mask, 0, 0, 0);
        imagecopymerge($image, $mask, 0, 0, 0, 0, $newwidth, $newheight, 100);
        imagecolortransparent($image, $red);
        imagefill($image, 0, 0, $red);
        Header('Content-type:image/png');
        imagepng($image, 'party_logos/' . $this->party_number . '.png');
        imagedestroy($image);
        // return $image;
    }

    public function getSeatLogo() {
        $filename = 'party_logos/' . $this->party_logo_name;
        $image_s = imagecreatefromstring(file_get_contents($filename));
        $width = imagesx($image_s);
        $height = imagesy($image_s);
        $newwidth = 40;
        $newheight = 40;
        $image = imagecreatetruecolor($newwidth, $newheight);
        // imagealphablending($image, true);
        imagecopyresampled($image, $image_s, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//create masking
        $mask = imagecreatetruecolor($newwidth, $newheight);
        $transparent = imagecolorallocate($mask, 255, 0, 0);
        imagecolortransparent($mask, $transparent);
        imagefilledellipse($mask, $newwidth / 2, $newheight / 2, $newwidth, $newheight, $transparent);
        $red = imagecolorallocate($mask, 0, 0, 0);
        imagecopymerge($image, $mask, 0, 0, 0, 0, $newwidth, $newheight, 100);
        imagecolortransparent($image, $red);
        imagefill($image, 0, 0, $red);

        return $image;
    }

    public function getFinal_mandates() {
        $final_mandates = $this->party_mandates;
        if ($this->majoritarian_mandates > $this->ghost_mandates) {
            $final_mandates = $this->party_mandates - ($this->majoritarian_mandates - $this->ghost_mandates);
        }
        return $final_mandates;
    }

}
