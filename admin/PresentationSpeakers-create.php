
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $pres_id = trim($_POST["pres_id"]);
		$speaker_id = trim($_POST["speaker_id"]);
		$is_moderator = trim($_POST["is_moderator"]);
		

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
          exit('Something weird happened'); //something a user can understand
        }

        $vars = parse_columns('PresentationSpeakers', $_POST);
        $stmt = $pdo->prepare("INSERT INTO PresentationSpeakers (pres_id,speaker_id,is_moderator) VALUES (?,?,?)");

        if($stmt->execute([ $pres_id,$speaker_id,$is_moderator  ])) {
                $stmt = null;
                header("location: PresentationSpeakers-index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add a record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="PresentationSpeakers-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
