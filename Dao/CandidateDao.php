<?php

require_once 'DataBaseConnection.php';

class CandidateDao {

    private $db_connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->db_connection = $dataBaseConnection->getConnection();
    }

    public function getDistrictCandidates($districtId) {
        $districtCandidates = array();
        $query = "SELECT id, first_name, last_name, county_number, supporting_party_number, t1.votes, party_name, party_logo_name, party_color"
                . " FROM elections_majoritarians t1 INNER JOIN elections t2 ON t1.supporting_party_number=t2.party_number "
                . " WHERE t1.county_number=" . $districtId . " ORDER BY county_number, supporting_party_number";
        if (!($result = $this->db_connection->query($query))) {
//header('Location:errorPage.php');
            echo 'Could not connect to db<br />';
            printf("Errormessage: %s\n", $db_connection->error);
            exit;
        } else {
            while ($row = $result->fetch_object()) {
                $id = $row->id;
                $first_name = $row->first_name;
                $last_name = $row->last_name;

                $district = $row->county_number; //why on earth i named this field in mySQL "county" and not "district"????????
                $supporting_party_number = $row->supporting_party_number;
                $party_logo_name = $row->party_logo_name;
                $party_name = $row->party_name;
                $party_color = $row->party_color;
                $supporting_party = new Party();
                $supporting_party->setParty_number($supporting_party_number);
                $supporting_party->setParty_logo_name($party_logo_name);
                $supporting_party->setParty_name($party_name);
                $supporting_party->setParty_color_HEX($party_color);

                $candidate = new Candidate();
                $candidate->setSupporting_party($supporting_party);
                $candidate->setId($id);
                $candidate->setFirst_name($first_name);
                $candidate->setLast_name($last_name);
                $candidate->setDistrict($district);
                array_push($districtCandidates, $candidate);
            }
        } return $districtCandidates;
    }

    public function voteCandidate($candidateId) {
        $query = "UPDATE elections_majoritarians SET votes=votes+1 where id=$candidateId";
        if (!($result = $this->db_connection->query($query))) {
            echo '<h1>Ουπς, κάτι πήγε στραβά με τη βάση δεδομένων.</h1> ';
            echo "<a href=\"../index.php\"";
            exit;
            //echo '<h1>Ουπς, κάτι πήγε στραβά με τη βάση δεδομένων.</h1> ' . $db_connection->error;
        } else {
            //do nothing
        }
    }

}
