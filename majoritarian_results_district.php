<?php
require_once 'Controllers/DistrictController.php';
require_once 'Dao/CandidateDao.php';
require_once 'Model/Party.php';
require_once 'Model/Candidate.php';
require_once 'Model/District.php';
require_once 'Controllers/majoritarians_results.php';

if (isset($_POST["districtId_results"])) {
    //no sanitation for now, later maybe, if
    $districtId = $_POST["districtId_results"];

    $majoritarian_results = new Majoritarian_Results();

    $districts_results = $majoritarian_results->getDistricts_results();
    $district = $districts_results[$districtId];

    $candidates = $district->getDistrictCandidates();
} else {
    header("Location:errorPage.php");
}
?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ELECETION-MAJORITARIAN-DISTRICT</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <body>
        <div class="container">
            <div class="row">


                <div class="form-group">
                    <div class="custom-file">

                        <?php
                        echo "<h2>" . $district->getDistrictFullName() . "</h2><hr>";
                        echo "<h4>საერთო ხმები: ".$district->getTotalVotes()."</h4>";
                        ?>
                        <hr>
                        <a href="majoritarian_results_map.php">Click here to go back to map</a>
                        <hr>
                        <?php
                        echo "<hr>";
                        if (count($candidates) != 0) {
                            echo '<div style ="font-size:24px;" class="table-responsive"><table class="table table-bordered table-hover">';
                            echo '<thead>'
                            . '<tr>'
                            . '<td>Number</td>'
                            . '<td>Party Logo</td>'
                            . '<td>Name</td>'
                            . '<td>Votes</td>'
                            . '</tr>'
                            . '</thead>';
                            foreach ($candidates as $candidate) {
                                $party = $candidate->getSupporting_party();
                                echo $party->getParty_color();
                                echo "<tr>"
                                . "<td >" . $party->getParty_number() . "</td>"
                                . "<td style=\"background-color:" . $party->getParty_color_HEX() . "\"><img width=\"40px\" heigth=\"40px\" src=\"party_logos/" . $party->getParty_logo_name() . "\" ></td>"
                                . "<td><span style=\"font-weight:bold\" >" . $candidate->getFirst_name() . " " . $candidate->getLast_name() . "</span><br><span class=\"small\">" . $party->getParty_name() . "</span></td> "
                                . "<td><span style=\"font-weight:bold\" >".$candidate->getPercent()."% </span><br><span class =\"small\">".$candidate->getVotes()." ხმა</span></td>"
                                . ''
                                . ' </tr>';
                            }
                            echo '</table></div>';
                            ?>                        
                        </div>
                        <?php
                    } else {
                        echo "<h1>ოკუპირებულ ტერიტორიებზე არჩევნები არ ტარდება</1> ";
                    }
                    ?>

                </div>

            </div>
            <hr>

        </div>
    </div>



    <script>

        function select_candidate(node) {
            //if clicked it means you choose your party, so i charge the shooter with apropriate modal, 
            //otherwise it is charged with blank "partyNotSelectedModal" modal
            var modalShooter = document.getElementById("modalShooter");
            modalShooter.setAttribute("data-target", "#confirmationModal");

            var row = node.parentNode.parentNode.parentNode;
            var clone_row = row.cloneNode(true);
            clone_row.removeChild(clone_row.lastElementChild);
            var confirmation_table = document.getElementById("confirmation_table");
            confirmation_table.deleteRow(0);
            confirmation_table.appendChild(clone_row);
        }


    </script>

</body>
</html>