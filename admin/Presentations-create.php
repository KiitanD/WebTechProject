
<?php
    // Made with CRUDDIY
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$pres_title = "";
$venue = "";
$pres_time = "";
$is_group = "";
$pres_description = "";

$pres_title_err = "";
$venue_err = "";
$pres_time_err = "";
$is_group_err = "";
$pres_description_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $pres_title = trim($_POST["pres_title"]);
		$venue = trim($_POST["venue"]);
		$pres_time = trim($_POST["pres_time"]);
		$is_group = trim($_POST["is_group"]);
		$pres_description = trim($_POST["pres_description"]);
		

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

        $vars = parse_columns('Presentations', $_POST);
        $stmt = $pdo->prepare("INSERT INTO Presentations (pres_title,venue,pres_time,is_group,pres_description) VALUES (?,?,?,?,?)");

        if($stmt->execute([ $pres_title,$venue,$pres_time,$is_group,$pres_description  ])) {
                $stmt = null;
                header("location: Presentations-index.php");
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
                                <label>pres_title</label>
                                <input type="text" name="pres_title" maxlength="100"class="form-control" value="<?php echo $pres_title; ?>">
                                <span class="form-text"><?php echo $pres_title_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>venue</label>
                                <input type="text" name="venue" maxlength="8"class="form-control" value="<?php echo $venue; ?>">
                                <span class="form-text"><?php echo $venue_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>pres_time</label>
                                <input type="datetime-local" name="pres_time" class="form-control" value="<?php echo date("Y-m-d\TH:i:s", strtotime($pres_time)); ?>">
                                <span class="form-text"><?php echo $pres_time_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>is_group</label>
                                <select name="is_group" class="form-control" id="is_group">
						<?php
                                            $sql_enum = "SELECT COLUMN_TYPE as AllPossibleEnumValues
                                            FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Presentations'  AND COLUMN_NAME = 'is_group'";
                                            $result = mysqli_query($link, $sql_enum);
                                            while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                                            preg_match('/enum\((.*)\)$/', $row[0], $matches);
                                            $vals = explode("," , $matches[1]);
                                            foreach ($vals as $val){
                                                $val = substr($val, 1);
                                                $val = rtrim($val, "'");
                                                if ($val == $is_group){
                                                echo '<option value="' . $val . '" selected="selected">' . $val . '</option>';
                                                } else
                                                echo '<option value="' . $val . '">' . $val . '</option>';
                                                        }
                                            }?>
						</select>
                                <span class="form-text"><?php echo $is_group_err; ?></span>
                                </div>
						<div class="form-group">
                                <label>pres_description</label>
                                <input type="text" name="pres_description" maxlength="500"class="form-control" value="<?php echo $pres_description; ?>">
                                <span class="form-text"><?php echo $pres_description_err; ?></span>
                            </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Presentations-index.php" class="btn btn-secondary">Cancel</a>
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
