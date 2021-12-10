<?php
require 'speakersql.php';
require 'header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Speakers | Muse Fest </title>
    <link href="dist/output.css" rel="stylesheet">
    <script src="speaker-card.js"></script>
    <script src="speaker-modal.js"></script>
    <script src="modalHandling.js"></script>
</head>

<body>

    <div id="modal_overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick=CloseModal()> </div>

    <div id="grid" class="grid grid-cols-3 gap-x-8 gap-y-8 mx-52 justify-around mb-28">
        <h1 class="text-purple-400 col-span-3 "> Meet the speakers for Muse Fest 2022! </h1>
        <?php

        for ($count = 0; $count < $get_speakers->num_rows; $count++) {

            list($id, $name, $job, $bio, $picture, $pres_list) =
                getSpeakerInfo($conn, $get_speakers, $speaker_pres_query, $count)

        ?>

            <speaker-card onclick=OpenModal(event) card-id="<?php echo $id; ?>" name="<?php echo $name ?>" img-src="<?php echo $picture ?>" job="<?php echo $job ?>" bio="<?php echo $bio ?>"></speaker-card>
            <speaker-modal class="hidden" id="modal-<?php echo $id ?>" img-src="<?php echo $picture ?>" name="<?php echo $name ?>" job="<?php echo $job ?>" pres="<?php echo $pres_list ?>" bio="<?php echo $bio ?>"> </speaker-modal>
            <!-- solid to this point -->

        <?php } ?>
    </div>
    <div id="modal-div"></div>

</body>

</html>