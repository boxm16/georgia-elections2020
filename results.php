<?php ?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ELECETION-VOTER</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <body>
        <div class="container">
            <h1>პროპორციული შედეგები</h1>
            <hr>
            <div class="row">

                <div class="row"> 

                    <img src='proportional_results.php' width="800" height="400" style="border-style:solid;border-color:black;border-width:1px;">
                </div>

                <br>

            </div>

            <div >
                <h1 >SEATS</h1>
                <iframe  src='elections_seats.php' width='1200' height='800'></iframe>
            </div>
        </div>


        <script>
            function select_party(node) {
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