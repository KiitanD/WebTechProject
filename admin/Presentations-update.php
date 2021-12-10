
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
if(isset($_POST["pres_id"]) && !empty($_POST["pres_id"])){
    // Get hidden input value
    $pres_id = $_POST["pres_id"];

    $pres_title = trim($_POST["pres_title"]);
		$venue = trim($_POST["venue"]);
		$pres_time = trim($_POST["pres_time"]);
		$is_group = trim($_POST["is_group"]);
		$pres_description = trim($_POST["pres_description"]);
		

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

    $vars = parse_columns('Presentations', $_POST);
    $stmt = $pdo->prepare("UPDATE Presentations SET pres_title=?,venue=?,pres_time=?,is_group=?,pres_description=? WHERE pres_id=?");

    if(!$stmt->execute([ $pres_title,$venue,$pres_time,$is_group,$pres_description,$pres_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: Presentations-read.php?pres_id=$pres_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["pres_id"] = trim($_GET["pres_id"]);
    if(isset($_GET["pres_id"]) && !empty($_GET["pres_id"])){
        // Get URL parameter
        $pres_id =  trim($_GET["pres_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM Presentations WHERE pres_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $pres_id;

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

                    $pres_title = $row["pres_title"];
					$venue = $row["venue"];
					$pres_time = $row["pres_time"];
					$is_group = $row["is_group"];
					$pres_description = $row["pres_description"];
					

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

                        <input type="hidden" name="pres_id" value="<?php echo $pres_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Presentations-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
