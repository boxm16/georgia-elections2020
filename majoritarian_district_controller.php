<?php

require_once 'Dao/elections_division.php';
require_once 'Dao/CandidateDao.php';
require_once 'Model/Party.php';
require_once 'Model/Candidate.php';

$districtFullName = getDistrictFullName($election_division);
$districtCandidates = getDistrictCandidates();

function getDistrictFullName($election_division) {
    $districId;
    if (isset($_POST["districtId_voting"])) {
        $districtId = $_POST["districtId_voting"];
    }
    return $election_division[$districtId];
}

function getDistrictCandidates() {
    if (isset($_POST["districtId_voting"])) {
        $districtId = $_POST["districtId_voting"];

        $candidateDao = new CandidateDao();
        $districtCandidates = $candidateDao->getDistrictCandidates($districtId);

        header("Location:majoritarian_voting_district.php");
    } elseif (isset($_POST["districtId_result"])) {
        echo "i came for resuts";
    }
}

;

