<?php
require 'panelsql.php';
require 'header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Presentations | Muse Fest </title>
    <link href="dist/output.css" rel="stylesheet">
    <!-- <script src="test.js"></script> -->
    <!-- <script src="test2.js"></script> -->
    <script src="panel-card.js"></script>
    <script src="panel-modal.js"></script>
    <script src="modalHandling.js"></script>
</head>

<body>


    <div id="modal_overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick=CloseModal()> </div>

    <div id="grid" class="grid grid-cols-3 gap-x-8 gap-y-8 mx-52 justify-around mb-28">
        <h1 class=" text-pink-400 col-span-3"> What's On at Muse Fest 2022 </h1>
        <?php

        for ($count = 0; $count < $get_presentations->num_rows; $count++) {
            list($id, $title, $venue, $time, $is_group, $description, $speaker_list) =
                getPresentationInfo($conn, $get_presentations, $pres_speakers_query, $count, $order_by);
            //echo ($id . " " . $title . " " . $venue . " " . $time . " " . $is_group . " DESCRIPTION" . $description . " SPEAKER LIST " . $speaker_list);
        ?>
            <panel-card onclick=OpenModal(event) card-id="<?php echo $id; ?>" title="<?php echo $title ?>" time="<?php echo $time ?>"> </panel-card>
            <panel-modal class="hidden" id="modal-<?php echo $id ?>" title="<?php echo $title ?>" time="<?php echo $time ?>" venue="<?php echo $venue ?>" description="<?php echo $description ?>" speakers="<?php echo $speaker_list ?>"> </panel-modal>
        <?php } ?>

    </div>
    <div id="modal-div"></div>

</body>

</html>