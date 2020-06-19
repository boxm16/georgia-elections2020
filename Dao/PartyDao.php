<?php
require_once 'DataBaseConnection.php';
class PartyDao {

    private $db_connection;

    public function __construct() {
        $DataBaseConnection = new DataBaseConnection();
        $this->db_connection = $DataBaseConnection->getConnection();
    }

    public function voteParty($party) {
        $query = "UPDATE elections SET votes=votes+1 where party_number=$party";
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
