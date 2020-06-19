<?php

require_once 'DataBaseConnection.php';
$election_division = array(
    1 => "საარჩევნო ოლქი #1: მთაწმინდისა და კრწანისის რაიონები",
    2 => "საარჩევნო ოლქი #2: ვაკის რაიონი",
    3 => "საარჩევნო ოლქი #3: საბურთალოს რაიონი",
    4 => "საარჩევნო ოლქი #4: ისნის რაიონი",
    5 => "საარჩევნო ოლქი #5: სამგორის რაიონი",
    6 => "საარჩევნო ოლქი #6: დიდუბისა და ჩუღურეთის რაიონები",
    7 => "საარჩევნო ოლქი #7: გლდანის რაიონი",
    8 => "საარჩევნო ოლქი #8: ნაძალადევის რაიონი",
    9 => "საარჩევნო ოლქი #9: თელავის, ახმეტის, ყვარლისა და ლაგოდეხის მუნიციპალიტეტები",
    10 => "საარჩევნო ოლქი #10: გურჯაანის, საგარეჯოს, დედოფლისწყაროსა და სიღნაღის მუნიციპალიტეტები",
    11 => "საარჩევნო ოლქი #11: რუსთავის მუნიციპალიტეტი და გარდაბნის 10 ადმინისტრაციული ერთეულები",
    12 => "საარჩევნო ოლქი #12: მარნეულის მუნიციპალიტეტი და გარდაბნის  მუნიციპალიტეტის ნაწილი",
    13 => "საარჩევნო ოლქი #13: ბოლნისის, დმანისის, თეთრიწყაროსა და წალკის მუნიციპალიტეტები",
    14 => "საარჩევნო ოლქი #14: მცხეთის, დუშეთის, თიანეთისა და ყაზბეგის მუნიციპალიტეტები;",
    15 => "საარჩევნო ოლქი #15: კასპის მუნიციპალიტეტი და გორის მუნიციპალიტეტის ნაწილი",
    16 => "საარჩევნო ოლქი #16: ხაშურისა და ქარელის მუნიციპალიტეტები და გორის მუნიციპალიტეტის ნაწილი",
    17 => "საარჩევნო ოლქი #17: ახალციხის, ბორჯომის, ადიგენისა და ასპინძის მუნიციპალიტეტები",
    18 => "საარჩევნო ოლქი #18: ახალქალაქისა და ნინოწმინდის მუნიციპალიტეტები",
    19 => "საარჩევნო ოლქი #19: ქუთაისის მუნიციპალიტეტი",
    20 => "საარჩევნო ოლქი #20: საჩხერის, ჭიათურისა და ხარაგაულის მუნიციპალიტეტები",
    21 => "საარჩევნო ოლქი #21: ტყიბულის, თერჯოლის, ზესტაფონისა და ბაღდათის მუნიციპალიტეტები",
    22 => "საარჩევნო ოლქი #22: სამტრედიის, წყალტუბოს, ვანისა და ხონის მუნიციპალიტეტები",
    23 => "საარჩევნო ოლქი #23: ზუგდიდის მუნიციპალიტეტი",
    24 => "საარჩევნო ოლქი #24: ფოთის, ხობისა და სენაკის მუნიციპალიტეტები",
    25 => "საარჩევნო ოლქი #25: წალენჯიხის, ჩხოროწყუს, მარტვილისა და აბაშის მუნიციპალიტეტები",
    26 => "საარჩევნო ოლქი #26: ოზურგეთის, ლანჩხუთისა და ჩოხატაურის მუნიციპალიტეტები",
    27 => "საარჩევნო ოლქი #27: ბათუმის მუნიციპალიტეტი",
    28 => "საარჩევნო ოლქი #28: ქობულეთის მუნიციპალიტეტი და ხელვაჩაურის მუნიციპალიტეტის ნაწილი",
    29 => "საარჩევნო ოლქი #29: ხელვაჩაურის მუნიციპალიტეტის ნაწილი, ქედის, შუახევისა და ხულოს მუნიციპალიტეტები",
    30 => "საარჩევნო ოლქი #30: ამბროლაურის, ონის, ცაგერის, ლენტეხისა და მესტიის მუნიციპალიტეტები",
    31 => "თბილისი",
    32 => "აფხაზეთი-რუსეთის მიერ ოკუპირებული რეგიონი",
    33 => "შიდა ქართლის რუსეთის მიერ  ოკუპირებული ტერიტორიები",
);


$DataBaseConnection = new DataBaseConnection();
$db_connection = $DataBaseConnection->getConnection();


/*
  for ($x = 1; $x < 31; $x++) {
  $county_number=$x;
  $query = "INSERT INTO elections_majoritarians (first_name, last_name, county_number, supporting_party_number) VALUES('ჯერ არ დასახელებულა', 'ჯერ არ დასახელებულა', $county_number, '15')";

  if (!($result = $db_connection->query($query))) {
  echo 'Could not connect to db<br />';
  printf("Errormessage: %s\n", $db_connection->error);
  exit;
  }
  }


 */

$query = "SELECT first_name, last_name, county_number, supporting_party_number, t1.votes, party_name, party_logo_name, party_color"
        . " FROM elections_majoritarians t1 INNER JOIN elections t2 ON t1.supporting_party_number=t2.party_number "
        . " ORDER BY county_number, supporting_party_number";
if (!($result = $db_connection->query($query))) {
//header('Location:errorPage.php');
    echo 'Could not connect to db<br />';
    printf("Errormessage: %s\n", $db_connection->error);
    exit;
} else {
    $county_number_pacer = 1;
    $county_candidates = array();
    $election_candidates = array();
    while ($row = $result->fetch_object()) {
        $first_name = $row->first_name;
        $last_name = $row->last_name;
        $full_name = $first_name . " " . $last_name;
        $county_number = $row->county_number;
        $supporting_party_number = $row->supporting_party_number;
        $party_logo_name = $row->party_logo_name;
        $party_name = $row->party_name;
        $party_color = $row->party_color;

        if ($county_number_pacer == $county_number) {

            $candidate = array($supporting_party_number, $full_name, $party_name, $party_logo_name);
            array_push($county_candidates, $candidate);
            if ($county_number_pacer == 30) {
                $election_candidates = array_push_assoc($election_candidates, $county_number_pacer, $county_candidates);
            }
        } else {

            $election_candidates = array_push_assoc($election_candidates, $county_number_pacer, $county_candidates);

            $county_candidates = array();
            $candidate = array($supporting_party_number, $full_name, $party_name, $party_logo_name);
            array_push($county_candidates, $candidate);
            $county_number_pacer ++;
        }
    }
    $tbilisi = 31;
    $abkhazia = 32;
    $samachablo = 33;
    $candidate = array("თბილისის საარჩევნო ოლქების სანახავად დააწკაპუნე ");
    $county_candidates = array();
    array_push($county_candidates, $candidate);
    $election_candidates = array_push_assoc($election_candidates, $tbilisi, $county_candidates);

    $candidate = array("ოკუპაციის გამო ამ ტერიტორიაზე არჩევნები არ ტარდება");
    $county_candidates = array();
    array_push($county_candidates, $candidate);
    $election_candidates = array_push_assoc($election_candidates, $abkhazia, $county_candidates);

    $candidate = array("ოკუპაციის გამო ამ ტერიტორიაზე არჩევნები არ ტარდება");
    $county_candidates = array();
    array_push($county_candidates, $candidate);
    $election_candidates = array_push_assoc($election_candidates, $samachablo, $county_candidates);
}

function array_push_assoc($array, $key, $value) {
    $array[$key] = $value;
    return $array;
}
