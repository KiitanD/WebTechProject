    <?php require "header.php"; ?>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="registration.js"></script>
    </head>


    <body>
        <div id="modal_overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick=CloseModal()> </div>
        <div id="modal-div">
            <div id="success" class="hidden modal w-96 h-60 border-2 border-teal-400 !px-10 !py-4 z-20 ">
                <p class="text-3xl text-teal-400 text-center mb-10"> Registration sucessful! </p>
                <p class="text-justify"> Now you can add presentations to your conference calendar.
                    Go to the panels page to see what's on offer. </p>
                <a href="panels.php">
                    <button class="m-auto w-1/3 h-8 absolute bottom-5 inset-x-0 bg-teal-400 grid place-items-center"> Take me there! </button>
                </a>
            </div>
        </div>
        <h1 class="text-teal-400"> Register for Muse! </h1>
        <p class="w-1/2 mt-10 mx-auto text-xl"> We're so glad you want to join us at Muse Fest! Fill out this form so we can keep in touch with updates.
        </p>
        <hr class=" text-teal-400 w-2/3 mt-5 mx-auto">

        <form class="mt-10" id="signup" method="POST" action="registersql.php">
            <div class=" text-lg grid grid-cols-2 w-2/3 m-auto gap-4 justify-center">
                <div class="flex mr-20">
                    <label for="fname"> First:</label>
                    <input id="fname" class="required" maxlength="30" type="text" name="fname">
                </div>
                <div class="flex mr-20">
                    <label for="lname"> Last Name: </label>
                    <input id="lname" class="required" maxlength="30" type="text" name="lname">
                </div>
                <div class="flex mr-20">
                    <label for="email"> Email: </label>
                    <input id="email" class="required" maxlength="30" type="email" name="email">
                </div>
                <div class="flex mr-20">
                    <label for="pword"> Password: </label>
                    <input id="pword" class="required" type="password" name="pword">

                </div>
                <div class="flex mr-20">
                    <label for="job_title"> Occupation: </label>
                    <input id="job_title" maxlength="30" type="text" name="job_title">

                </div>
                <div class="flex mr-20">
                    <label for="org_name"> Employer:</label>
                    <input maxlength="50" type="text" name="org_name">

                </div>
            </div>
            <div class="mt-10 grid place-items-center">
                <button id="submit" class="bg-teal-400 disabled:bg-gray-200 w-fit object-center p-2 mb-10" disabled type="submit"> Submit! </button>
            </div>
        </form>


    </body>

    </html>

    <script>
        $("#signup").submit(function(event) {
            event.preventDefault();
            var formValues = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "registersql.php",
                data: formValues
            }).done(function() {
                OpenModal(event);

            });
        });
    </script>
    <script>
        const fname = document.querySelector('input[name="fname"]');
        const lname = document.querySelector('input[name="lname"]');
        const email = document.querySelector('input[name="email"]');
        const pwd = document.querySelector('input[name="pword"]');
        const form = document.querySelector('form');
        fname.addEventListener('blur', (e) => {
            const isValid = /^[a-zA-Z]{2,}[a-zA-Z\-\s]*$/.test(fname.value)
            const message = '<p id="fname-error" class="error"> First name is required </p>'
            if (!isValid) {
                if (!document.querySelector('#fname-error')) {
                    document.querySelector('form').insertAdjacentHTML('afterend', message);
                }
            } else {
                document.querySelector("#fname-error").remove()
            }
        })

        lname.addEventListener('blur', (e) => {
            const isValid = /^[a-zA-Z]{2,}[a-zA-Z\-\s]*$/.test(lname.value)
            const message = '<p id = "lname-error" class="error"> Last name is required</p>'
            if (!isValid) {
                if (!document.querySelector('#lname-error')) {
                    document.querySelector('form').insertAdjacentHTML('afterend', message);
                }
            } else {
                document.querySelector("#lname-error").remove()
            }
        })

        pwd.addEventListener('blur', (e) => {
            const isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/.test(pwd.value);
            const message = '<p id = "pwd-error" class="error"> ' +
                'Passwords must contain at least 8 characters including one uppercase letter,' +
                'one lowercase letter, one digit and one special character</p>'
            if (!isValid) {
                if (!document.querySelector("#pwd-error")) {
                    document.querySelector('form').insertAdjacentHTML('afterend', message);
                }
            } else {
                document.querySelector("#pwd-error").remove()
            }
        })
        email.addEventListener('blur', (e) => {
            const isValid = /\S+@\S+\.\S+/.test(email.value);
            const message = '<p id = "email-error" class="error m-auto inset-0">' +
                'Please enter a valid email address </p>'
            if (!isValid) {
                if (!document.querySelector("#email-error")) {
                    document.querySelector('form').insertAdjacentHTML('afterend', message);
                }
            } else {
                document.querySelector("#email-error").remove()
            }
        })


        $('form  .required').change(function() {

            var empty = false;
            $('form  .required').each(function() {
                if ($(this).val() == '') {
                    empty = true;
                }
            });

            if (empty) {
                $('#submit').attr('disabled', 'disabled');
            } else {

                setTimeout(function() {
                    if (!document.querySelector(".error")) {
                        $('#submit').removeAttr('disabled');
                    }
                }, 100)
            }
        });
    </script>