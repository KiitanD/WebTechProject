<?php
require 'database_credentials.php';
//Connect to database    
$conn = new mysqli(servername, username, password, database);

$presentation_query = "SELECT Presentations.pres_id, Presentations.pres_title, Presentations.venue, 
            Presentations.pres_time, Presentations.is_group, Presentations.pres_description FROM Presentations ";

$get_presentations = $conn->query($presentation_query);

$pres_speakers_query = "SELECT PresentationSpeakers.is_moderator, People.person_id, People.fname, People.lname
            FROM PresentationSpeakers 
            JOIN People ON PresentationSpeakers.speaker_id = People.person_id
            WHERE PresentationSpeakers.pres_id = ";
$order_by = " ORDER BY PresentationSpeakers.is_moderator";

function getPresentationInfo($conn, $get_presentations, $pres_speakers_query, $count, $order_by)
{
    $get_presentations->data_seek($count);
    $presentation = $get_presentations->fetch_row();
    $id = $presentation[0];
    $title = $presentation[1];
    $venue = $presentation[2];
    $time = $presentation[3];
    $is_group = $presentation[4];
    $description = $presentation[5];
    $get_pres_speaker = $conn->query($pres_speakers_query . $id . $order_by)->fetch_all();
    $speaker_list = "";
    foreach($get_pres_speaker as $speaker) {
        if ($speaker[0] == 'no') {
            $speaker_list .=$speaker[2] . " ".$speaker[3]. "<br>";
        }
        else{
            $speaker_list .= "Moderated by " . $speaker[2] . " " . $speaker[3] . "<br>";
        }

    }
    return array($id, $title, $venue, $time, $is_group, $description, $speaker_list);

}
