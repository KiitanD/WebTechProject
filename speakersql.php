
<?php
require 'database_credentials.php';
//Connect to database    
$conn = new mysqli(servername, username, password, database);

//Query the database to get all the speaker information
$speaker_query =
    "SELECT People.person_id, People.fname, People.lname, People.job_title, People.org_name,
        Speakers.bio, Speakers.picture FROM People 
        JOIN Speakers ON People.person_id = Speakers.speaker_id
        WHERE People.is_presenter = 'yes'";

$get_speakers = $conn->query($speaker_query);

$speaker_pres_query =
    "SELECT PresentationSpeakers.is_moderator, Presentations.pres_title
        FROM PresentationSpeakers 
        JOIN Presentations ON PresentationSpeakers.pres_id = Presentations.pres_id
        WHERE PresentationSpeakers.speaker_id = ";

function getSpeakerInfo($conn, $get_speakers, $speaker_pres_query, $count)
{
    $get_speakers->data_seek($count);
    $speaker = $get_speakers->fetch_row();
    $id = $speaker[0];
    $name = $speaker[1] . " " . $speaker[2];
    // $lname = $speaker[2];
    $job = $speaker[3] . " at " . $speaker[4];
    // $org_name = $speaker[4];
    $bio = $speaker[5];
    $picture = $speaker[6];
    $get_speaker_pres = $conn->query($speaker_pres_query . $id)->fetch_all();
    $pres_list = "";
    foreach ($get_speaker_pres as $presentation) {
        if ($presentation[0] == 'no') {
            $pres_list .= "Speaker: " . $presentation[1] . "<br>";
        } else {
            $pres_list .= "Moderator: " . $presentation[1] . "<br>";
        }
    }
    return array($id, $name, $job, $bio, $picture, $pres_list);
}




// $presentation_query = "SELECT Presentations.pres_id, Presentations.pres_title, Presentations.venue, 
//     Presentations.pres_time, Presentations.is_group, Presentations.pres_description FROM Presentations 
//     JOIN PresentationSpeakers ON Presentations.pres_id = PresentationSpeakers.pres_id 
//     ORDER BY Presentations.pres_id";

//     $get_presentations = $conn->query($presentation_query);

//     $pres_speakers_query = "SELECT PresentationSpeakers.is_moderator, Speakers.speakers_id
//     FROM PresentationSpeakers 
//     JOIN Speakers ON PresentationSpeakers.speaker_id = Speakers.speaker_id
//     WHERE PresentationSpeakers.speaker_id = ";
//     $order_by = " ORDER BY PresentationSpeakers.is_moderator";

// function getPresentationInfo($conn, $get_presentations, $pres_speakers_query, $count, $order_by) {
//     $get_presentations->data_seek($count);
//     $presentation = $get_presentations->fetch_row();
//     $id = $presentation[0];
//     $title = $presentation[1];
//     $venue = $presentation[2];
//     $time = $presentation[3];
//     $is_group = $presentation[4];
//     $description = $presentation[5];
//     $get_pres_speaker = $conn->query($pres_speakers_query. $id. $order_by)->fetch_all();
//     echo($id);
// $speaker_list = "";
// foreach($get_pres_speaker as $speaker) {
//     if ($is_group == true && $speaker[0] == 'no') {
//         $speaker_list .= "Moderated by ". $presentation[1] . "<br>";
//     }
//     else{
//         $speaker_list .= $speaker ."<br>";
//     }

// }
// return array($id, $title, $venue, $time, $is_group, $description, $speaker_list);

// }

?>