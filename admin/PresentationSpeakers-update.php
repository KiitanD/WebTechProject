
<?php
    // Made with CRUDDIY
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$pres_id = "";
$speaker_id = "";
$is_moderator = "";

$pres_id_err = "";
$speaker_id_err = "";
$is_moderator_err = "";


// Processing form data when form is submitted
if(isset($_POST["person_id"]) && !empty($_POST["person_id"])){
    // Get hidden input value
    $person_id = $_POST["person_id"];

    $pres_id = trim($_POST["pres_id"]);
		$speaker_id = trim($_POST["speaker_id"]);
		$is_moderator = trim($_POST["is_moderator"]);
		

    // Prepare an update statement
    $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    try {
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Something weird happened');
    }

    $vars = parse_columns('PresentationSpeakers', $_POST);
    $stmt = $pdo->prepare("UPDATE PresentationSpeakers SET pres_id=?,speaker_id=?,is_moderator=? WHERE person_id=?");

    if(!$stmt->execute([ $pres_id,$speaker_id,$is_moderator,$person_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: PresentationSpeakers-read.php?person_id=$person_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["person_id"] = trim($_GET["person_id"]);
    if(isset($_GET["person_id"]) && !empty($_GET["person_id"])){
        // Get URL parameter
        $person_id =  trim($_GET["person_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM PresentationSpeakers WHERE person_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $person_id;

            // Bind variables to the prepared statement as parameters
			if (is_int($param_id)) $__vartype = "i";
			elseif (is_string($param_id)) $__vartype = "s";
			elseif (is_numeric($param_id)) $__vartype = "d";
			else $__vartype = "b"; // blob
			mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $pres_id = $row["pres_id"];
					$speaker_id = $row["speaker_id"];
					$is_moderator = $row["is_moderator"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.<br>".$stmt->error;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                                <label>pres_id</label>
                                    <select class="form-control" id="pres_id" name="pres_id">
                                    <?php
                                        $sql = "SELECT *,pres_id FROM Presentations";
                                        $result = mysqli_query($link, $sql);
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            array_pop($row);
                                            $value = implode(" | ", $row);
                                            if ($row["pres_id"] == $pres_id){
                                            echo '<option value="' . "$row[pres_id]" . '"selected="selected">' . "$value" . '</option>';
                                            } else {
                                                echo '<option value="' . "$row[pres_id]" . '">' . "$value" . '</option>';
                                        }
                                        }
                                    ?>
                                    </select>
                                <span class="form-text"><?php echo $pres_id_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>speaker_id</label>
                                    <select class="form-control" id="speaker_id" name="speaker_id">
                                    <?php
                                        $sql = "SELECT *,speaker_id FROM Speakers";
                                        $result = mysqli_query($link, $sql);
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            array_pop($row);
                                            $value = implode(" | ", $row);
                                            if ($row["speaker_id"] == $speaker_id){
                                            echo '<option value="' . "$row[speaker_id]" . '"selected="selected">' . "$value" . '</option>';
                                            } else {
                                                echo '<option value="' . "$row[speaker_id]" . '">' . "$value" . '</option>';
                                        }
                                        }
                                    ?>
                                    </select>
                                <span class="form-text"><?php echo $speaker_id_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>is_moderator</label>
                                <select name="is_moderator" class="form-control" id="is_moderator">
						<?php
                                            $sql_enum = "SELECT COLUMN_TYPE as AllPossibleEnumValues
                                            FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'PresentationSpeakers'  AND COLUMN_NAME = 'is_moderator'";
                                            $result = mysqli_query($link, $sql_enum);
                                            while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                                            preg_match('/enum\((.*)\)$/', $row[0], $matches);
                                            $vals = explode("," , $matches[1]);
                                            foreach ($vals as $val){
                                                $val = substr($val, 1);
                                                $val = rtrim($val, "'");
                                                if ($val == $is_moderator){
                                                echo '<option value="' . $val . '" selected="selected">' . $val . '</option>';
                                                } else
                                                echo '<option value="' . $val . '">' . $val . '</option>';
                                                        }
                                            }?>
						</select>
                                <span class="form-text"><?php echo $is_moderator_err; ?></span>
                                </div>

                        <input type="hidden" name="person_id" value="<?php echo $person_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="PresentationSpeakers-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
