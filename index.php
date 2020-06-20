<?php
require_once 'Dao/DataBaseConnection.php';
$DataBaseConnection = new DataBaseConnection();
$db_connection = $DataBaseConnection->getConnection();
?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ELECETION-PARTY</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <body>
        <div class="container">
            <h1>VOTE FOR FAVORITE PARTY</h1>
            <div class="row">
                <form action="Controllers/PartyVotingController.php" method="post" > 
                    <div class="form-group">
                        <div class="custom-file">
                            <?php
                            $query = "SELECT * FROM elections ORDER BY party_number";
                            if (!($result = @$db_connection->query($query))) {
                                echo 'OOPS, DataBase Connection is down, try again later';
                            }
                            echo '<div style ="font-size:24px;" class="table-responsive"><table class="table table-bordered table-striped table-hover">';
                            echo '<thead>'
                            . '<tr>'
                            . '<td>Party Logo</td>'
                            . '<td>Party Number</td>'
                            . '<td>Party Name</td>'
                            . '<td> VOTE</td>'
                            . '</tr>'
                            . '</thead>';
                            while ($row = $result->fetch_object()) {
                                echo '<tr>'
                                . '<td style="background-color:' . $row->party_color . '"><img src="party_logos/' . $row->party_logo_name . '" widht="50" height="50"></td>'
                                . '<td>' . $row->party_number . '</td>'
                                . '<td>' . $row->party_name . '</td>'
                                . '<td><div class="form-check">
                                         <input class="form-check-input" type="radio" name="partyId" id="' . $row->party_number . '" value="' . $row->party_number . '" onclick="select_party(this)">
                                      
                                         </div> </td>'
                                . '</tr>';
                            }
                            echo '</table></div>';
                            ?>

                            <input type="button" id="modalShooter"  data-toggle="modal" data-target="#partyNotSelectedModal" class="btn btn-primary btn-block btn-lg" value="VOTE"/>
                        </div>
                    </div>

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
                    <!-- start of modal window for Party NOT Selected -->

                    <div class="modal fade" id="partyNotSelectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                </form>
            </div>
            <hr>
            <a href="majoritarian_voting_map.php">Click here to vote for you favorite majoritarian candidate</a>
            <hr>
        </div>



        <script>

            function select_party(node) {
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