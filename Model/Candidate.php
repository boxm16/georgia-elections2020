<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Candidate
 *
 * @author Michail Sitmalidis
 */
class Candidate {

    private $id;
    private $first_name;
    private $last_name;
    private $votes;
    private $percent;
    private $district;
    private $supporting_party;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    public function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    public function setVotes($votes) {
        $this->votes = $votes;
    }

    public function setPercent($percent) {
        $this->percent = $percent;
    }

    public function setDistrict($district) {
        $this->district = $district;
    }

    public function setSupporting_party($supporting_party) {
        $this->supporting_party = $supporting_party;
    }

    public function getFirst_name() {
        return $this->first_name;
    }

    public function getLast_name() {
        return $this->last_name;
    }

    public function getVotes() {
        return $this->votes;
    }

    public function getPercent() {
        return $this->percent;
    }

    public function getDistrict() {
        return $this->district;
    }

    public function getSupporting_party() {
        return $this->supporting_party;
    }

}
