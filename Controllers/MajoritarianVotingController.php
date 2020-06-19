<?php

if (isset($_POST['candidateId'])) {
    $candidateId = $_POST['candidateId'];
    require_once '../Dao/CandidateDao.php';
    $candidateDao = new CandidateDao();
    $candidateDao->voteCandidate($candidateId);



    header('Location:../results.php');
} else {
    header('Location:errorPage.php');
}