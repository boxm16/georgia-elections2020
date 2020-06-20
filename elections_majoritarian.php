<?php

class Majoritarian {

    private $name;
    private $number;
    private $logo_name;
    private $color;
    private $color_HEX;
    private $votes;

    function __construct($number, $logo_name, $color) {
        $this->number = $number;
        $this->logo_name = $logo_name;
        $this->color_HEX = $color;
        $this->color = $this->hex2rgb($color);
    }

    public function getName() {
        return $this->name;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getLogo_name() {
        return $this->logo_name;
    }

    public function getColor() {
        return $this->color;
    }

    public function getColor_HEX() {
        return $this->color_HEX;
    }

    public function getVotes() {
        return $this->votes;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function setLogo_name($logo_name) {
        $this->logo_name = $logo_name;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setColor_HEX($color_HEX) {
        $this->color_HEX = $color_HEX;
    }

    public function setVotes($votes) {
        $this->votes = $votes;
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

}
