<?php

class District implements JsonSerializable {

    private $districtId;
    private $districtFullName;
    private $message;
    private $totalVotes;
    private $hasWinner;
    private $districtCandidates;
    private $restCandidatesPercent;

    public function __construct() {
        $this->totalVotes = 0;
        $this->message = "ამ შედეგებით გამარჯვებული ვერ ვლინდება, საჭიროა მეორე ტური";
    }

    public function jsonSerialize() {
        return array(
            'districtId' => $this->districtId,
            'districtFullName' => $this->districtFullName,
            'message' => $this->message,
            'totalVotes' => $this->totalVotes,
            'hasWinner' => $this->hasWinner,
            'districtCandidates' => $this->districtCandidates,
            'restCandidatesPercent' => $this->restCandidatesPercent
        );
    }

    public function getDistrictId() {
        return $this->districtId;
    }

    public function getDistrictFullName() {
        return $this->districtFullName;
    }

    public function getDistrictCandidates() {
        return $this->districtCandidates;
    }

    public function setDistrictId($districtId) {
        $this->districtId = $districtId;
    }

    public function setDistrictFullName($districtFullName) {
        $this->districtFullName = $districtFullName;
    }

    public function setDistrictCandidates($districtCandidates) {
        $this->districtCandidates = $districtCandidates;
    }

    public function getTotalVotes() {
        $this->totalVotes = 0;
        foreach ($this->districtCandidates as $candidate) {
            $this->totalVotes += $candidate->getVotes();
        }
        return $this->totalVotes;
    }

    public function getHasWinner() {
        return $this->hasWinner;
    }

    public function setHasWinner($hasWinner) {
        $this->hasWinner = $hasWinner;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function calculateDistrict() {
        $totalVotes = $this->getTotalVotes();
        if ($totalVotes > 0) {
            foreach ($this->districtCandidates as $candidate) {
                // echo $candidate->getLast_name() . "<br>";
                $percent = ((100 * $candidate->getVotes()) / $totalVotes);
                $percent= round($percent,2);
                $candidate->setPercent($percent);
               if ($percent > 50) {
                    $this->message = "ამ შედეგებით გამარჯვებული ვლინდება პირველივე ტურში";
                }
            }
        }
    }

}
