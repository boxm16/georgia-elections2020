<?php

require_once 'elections_seat_creator.php';
require_once 'Dao/DataBaseConnection.php';
require_once 'Model/Party.php';
require_once 'elections_majoritarian.php';

class elections_seats_calculator {

//prosoxi, functions change field variables
    private $db_connection;
    private $total_votes_count;
    private $qualified_votes_count;
    private $all_parties = array();
    private $qualified_parties = array();
    private $left_mandates_count;

    const PROPORTIONAL_SEATS = 120;

    private $majoritarianMandates;

    function __construct() {

        $this->majoritarianMandates = array(0, 0, 0, 6, 0, 41, 0, 5, 41, 0, 5, 0, 2, 41, 0, 10, 0, 41, 41, 0, 41, 41, 0, 41, 41, 41, 0, 41, 0, 41);

        $this->getDatabaseConnection();
        $this->calculateTotalVotes();
        $this->calculateQualifiedParties();
        $this->calculateMandatesForEachParty();
        $this->calculateGhostMandates();
        $this->addMajoritarianMandatesToParty();
    }

    private function getDatabaseConnection() {
        $DataBaseConnection = new DataBaseConnection();
        $this->db_connection = $DataBaseConnection->getConnection();
    }

    private function calculateTotalVotes() {
        $query = "SELECT * FROM elections ORDER BY votes DESC, party_number ASC ;";
        if (!($result = @$this->db_connection->query($query))) {
//header('Location:errorPage.php');
            echo 'Could not connect to db<br />';
            exit;
        }

        while ($row = $result->fetch_object()) {
            $this->total_votes_count += $row->votes;


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
            $party->setParty_color_HEX($party_color);
            $party->setVotes($votes);




            $this->all_parties = $this->array_push_assoc($this->all_parties, $party_number, $party);
        }
    }

//this is function to push key=>values into associative array
    private function array_push_assoc($array, $key, $value) {
        $array[$key] = $value;
        return $array;
    }

    private function calculateQualifiedParties() {//this is to remove parties that took less than 1 %
        $party_number;
        foreach ($this->all_parties as $party) {
//if party takes less than 1 percent of total votes, it is disqualified. Votes for those party are also disqualified
            $percent = ($party->getVotes() / $this->total_votes_count) * 100;
            if ($percent > 1) {
                $this->qualified_votes_count = $this->qualified_votes_count + $party->getVotes();
                $party_number = $party->getParty_number();
                $this->qualified_parties = $this->array_push_assoc($this->qualified_parties, $party_number, $party);
            }
        }
    }

    private function calculateMandatesForEachParty() {

        $total_mandates = 0;
        $parties_nashtebi = array();
        foreach ($this->qualified_parties as $party) {
            $party_votes = $party->getVotes();
            $party_number = $party->getParty_number();
            $full_number = (($party_votes * self::PROPORTIONAL_SEATS) / $this->total_votes_count);
            $mandates = (intval($full_number));
            $nashti = $full_number - $mandates;
            $parties_nashtebi = $this->array_push_assoc($parties_nashtebi, $party_number, $nashti);

            $total_mandates += $mandates;
            $party->setParty_mandates($mandates);
        }
//if , due to rounding to the integer part of decimal number that comes from calculating
//mandates, there are still left mandates, we distribute them to the smallest parties one by one,
//from bootom to top
        arsort($parties_nashtebi);
        $left_mandates = $this->left_mandates_count = 120 - $total_mandates;

        $index = 0;
        $key_nashti = array_keys($parties_nashtebi);
        while ($left_mandates > 0) {

            $left_mandates = $left_mandates - 1;
            $party_number = $key_nashti[$index];
            $party = $this->qualified_parties[$party_number];
            $mandates = $party->getParty_mandates();
            $mandates ++;
            $party->setParty_mandates($mandates);
            $this->qualified_parties[$party_number] = $party;
            $index = $index + 1;
            if ($index > count($this->qualified_parties)) {//if we are at the top of list, and still left mandates, we go again to te bottom
                $index = 0;
            }
        }
    }

    private function calculateGhostMandates() {
        foreach ($this->qualified_parties as $party) {
            $percent = ($party->getVotes() / $this->total_votes_count) * 100;
            $closing_mechanism_percentage = $percent + ($percent / 4);
            $top_possible_namdates = intval((150 * $closing_mechanism_percentage) / 100);
            $ghost_mandates = $top_possible_namdates - $party->getParty_mandates();
            $party->setGhostMandates($ghost_mandates);
        }
    }

    public function getAllParties() {
        return $this->all_parties;
    }

    public function getQualifiedParties() {
        return $this->qualified_parties;
    }

    public function getTotalVotesCount() {
        return $this->total_votes_count;
    }

    public function getQualifiedVotesCount() {
        return $this->qualified_votes_count;
    }

    public function getLeftMandatesCount() {
        return $this->left_mandates_count;
    }

//this part is for majoritaria, i just write them, no calculationg

    public function getMajoritarians() {
        $majoritarians = array();
        foreach ($this->majoritarianMandates as $majoritarianNumber) {
            if ($majoritarianNumber > 0) {
                $supportingParty = $this->all_parties[$majoritarianNumber];
                $logo_name = $supportingParty->getParty_name();
                $color = $supportingParty->getParty_color_HEX();

                $majoritarian = new Majoritarian($majoritarianNumber, $logo_name, $color);
                array_push($majoritarians, $majoritarian);
            } else {
                $supportingParty = new Party();
                $logo_name = "0.png";
                $color = "black";

                $majoritarian = new Majoritarian($majoritarianNumber, $logo_name, $color);
                array_push($majoritarians, $majoritarian);
            }
        }
        return $majoritarians;
    }

    public function addMajoritarianMandatesToParty() {

        foreach ($this->majoritarianMandates as $majoritarianMandate) {
            if ($majoritarianMandate > 0) {
                $party = $this->qualified_parties[$majoritarianMandate];
                $party->setMajoritarian_mandates($party->getMajoritarian_mandates() + 1);
            }
        }
    }

}
