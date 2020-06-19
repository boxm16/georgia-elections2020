<?php

if (isset($_POST['partyId'])) {
    $partyId = $_POST['partyId'];
    require_once '../Dao/PartyDao.php';
    $partyDao = new PartyDao();
    $partyDao->voteParty($partyId);



    header('Location:../majoritarian_voting_map.php');
}else {
    header('Location:errorPage.php');
}