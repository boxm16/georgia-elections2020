<?php
require_once 'Controllers/DistrictController.php';
require_once 'Dao/CandidateDao.php';
require_once 'Model/Party.php';
require_once 'Model/Candidate.php';

if (isset($_POST["districtId_voting"])) {
    //no sanitation for now, later maybe, if
    $districtId = $_POST["districtId_voting"];

    $districtController = new DistrictController();
    $district = $districtController->getDistrictCandidates($districtId);
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
                <form action="Controllers/MajoritarianVotingController.php" method="post" > 
                    <div class="form-group">
                        <div class="custom-file">

                            <?php
                            echo "<h4>" . $district->getDistrictFullName() . "</h4>";
                            echo "<hr>";
                            if (count($candidates) != 0) {
                                echo '<div style ="font-size:24px;" class="table-responsive"><table class="table table-bordered table-hover">';
                                echo '<thead>'
                                . '<tr>'
                                . '<td>Number</td>'
                                . '<td>Party Logo</td>'
                                . '<td>Name</td>'
                                . '<td>VOTE</td>'
                                . '</tr>'
                                . '</thead>';
                                foreach ($candidates as $candidate) {
                                    $party = $candidate->getSupporting_party();
                                    echo $party->getParty_color();
                                    echo "<tr>"
                                    . "<td >" . $party->getParty_number() . "</td>"
                                    . "<td style=\"background-color:". $party->getParty_color_HEX() . "\"><img width=\"40px\" heigth=\"40px\" src=\"party_logos/" . $party->getParty_logo_name() . "\" ></td>"
                                    . "<td><span style=\"font-weight:bold\" >" . $candidate->getFirst_name() . " " . $candidate->getLast_name() . "</span><br><span class=\"small\">" . $party->getParty_name() . "</span></td> "
                                    . '<td><div class="form-check">'
                                    . '<input class="form-check-input" type="radio" name="candidateId" id="' . $candidate->getId() . '" value="' . $candidate->getId() . '" onclick="select_candidate(this)">'
                                    . ' </div> </td>'
                                    . ''
                                    . ' </tr>';
                                }
                                echo '</table></div>';
                                echo "    <input type=\"button\" id=\"modalShooter\"  data-toggle=\"modal\" data-target=\"#candidateNotSelectedModal\" class=\"btn btn-primary btn-block btn-lg\" value=\"VOTE\"/>";
                                ?>                        
                            </div>
                            <?php
                        } else {
                            echo "<h1>ოკუპირებულ ტერიტორიებზე არჩევნები არ ტარდება</1> ";
                        }
                        ?>



                        <!-- Modal for pick-up cancel start -->
                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title" id="exampleModalLabel"> ATTANTION, CONFIRMATION IS FINAL</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3><center>YOU VOTE FOR</center></h3>
                                            <table style ="font-size:36px;" id="confirmation_table" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Logo</td>
                                                        <td>Number</td>
                                                        <td>Name</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <h3><center>CONFIRM YOU VOTE</center></h3>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL AND GO BACK</button>
                                            <button type="submit" class="btn btn-primary" >COFIRM MY VOTE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of modal window for pick-up cancel--> 
                        <!-- start of modal window for Candidate NOT Selected -->

                        <div class="modal fade" id="candidateNotSelectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Warning</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h2>თქვენ ჯერ არ აგირჩევიათ თქვენთვის სასურველი პარტია</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end of window for Party NOT Selecetd -->
                    </div>
                </form>
            </div>
            <hr>
            <a href="majoritarian_voting_map.php">Click here to go back to map</a>
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