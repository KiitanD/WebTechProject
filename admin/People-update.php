<?php
    // Made with CRUDDIY
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$fname = "";
$lname = "";
$email = "";
$pword = "";
$job_title = "";
$org_name = "";
$is_presenter = "";

$fname_err = "";
$lname_err = "";
$email_err = "";
$pword_err = "";
$job_title_err = "";
$org_name_err = "";
$is_presenter_err = "";


// Processing form data when form is submitted
if(isset($_POST["person_id"]) && !empty($_POST["person_id"])){
    // Get hidden input value
    $person_id = $_POST["person_id"];

    $fname = trim($_POST["fname"]);
		$lname = trim($_POST["lname"]);
		$email = trim($_POST["email"]);
		$pword = trim($_POST["pword"]);
		$job_title = trim($_POST["job_title"]);
		$org_name = trim($_POST["org_name"]);
		$is_presenter = trim($_POST["is_presenter"]);
		

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

    $vars = parse_columns('People', $_POST);
    $stmt = $pdo->prepare("UPDATE People SET fname=?,lname=?,email=?,pword=?,job_title=?,org_name=?,is_presenter=? WHERE person_id=?");

    if(!$stmt->execute([ $fname,$lname,$email,$pword,$job_title,$org_name,$is_presenter,$person_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: People-read.php?person_id=$person_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["person_id"] = trim($_GET["person_id"]);
    if(isset($_GET["person_id"]) && !empty($_GET["person_id"])){
        // Get URL parameter
        $person_id =  trim($_GET["person_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM People WHERE person_id = ?";
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

                    $fname = $row["fname"];
					$lname = $row["lname"];
					$email = $row["email"];
					$pword = $row["pword"];
					$job_title = $row["job_title"];
					$org_name = $row["org_name"];
					$is_presenter = $row["is_presenter"];
					

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
                                <label>fname</label>
                                <input type="text" name="fname" maxlength="30"class="form-control" value="<?php echo $fname; ?>">
                                <span class="form-text"><?php echo $fname_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>lname</label>
                                <input type="text" name="lname" maxlength="30"class="form-control" value="<?php echo $lname; ?>">
                                <span class="form-text"><?php echo $lname_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>email</label>
                                <input type="text" name="email" maxlength="30"class="form-control" value="<?php echo $email; ?>">
                                <span class="form-text"><?php echo $email_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>pword</label>
                                <input type="text" name="pword" class="form-control" value="<?php echo $pword; ?>">
                                <span class="form-text"><?php echo $pword_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>job_title</label>
                                <input type="text" name="job_title" maxlength="30"class="form-control" value="<?php echo $job_title; ?>">
                                <span class="form-text"><?php echo $job_title_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>org_name</label>
                                <input type="text" name="org_name" maxlength="50"class="form-control" value="<?php echo $org_name; ?>">
                                <span class="form-text"><?php echo $org_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>is_presenter</label>
                                <select name="is_presenter" class="form-control" id="is_presenter">
						<?php
                                            $sql_enum = "SELECT COLUMN_TYPE as AllPossibleEnumValues
                                            FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'People'  AND COLUMN_NAME = 'is_presenter'";
                                            $result = mysqli_query($link, $sql_enum);
                                            while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                                            preg_match('/enum\((.*)\)$/', $row[0], $matches);
                                            $vals = explode("," , $matches[1]);
                                            foreach ($vals as $val){
                                                $val = substr($val, 1);
                                                $val = rtrim($val, "'");
                                                if ($val == $is_presenter){
                                                echo '<option value="' . $val . '" selected="selected">' . $val . '</option>';
                                                } else
                                                echo '<option value="' . $val . '">' . $val . '</option>';
                                                        }
                                            }?>
						</select>
                                <span class="form-text"><?php echo $is_presenter_err; ?></span>
                                </div>

                        <input type="hidden" name="person_id" value="<?php echo $person_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="People-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
