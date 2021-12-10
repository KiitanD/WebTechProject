<?php
    // Made with CRUDDIY
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$username = "";
$pword = "";

$username_err = "";
$pword_err = "";


// Processing form data when form is submitted
if(isset($_POST["admin_id"]) && !empty($_POST["admin_id"])){
    // Get hidden input value
    $admin_id = $_POST["admin_id"];

    $username = trim($_POST["username"]);
		$pword = trim($_POST["pword"]);
		

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

    $vars = parse_columns('Admins', $_POST);
    $stmt = $pdo->prepare("UPDATE Admins SET username=?,pword=? WHERE admin_id=?");

    if(!$stmt->execute([ $username,$pword,$admin_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: Admins-read.php?admin_id=$admin_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["admin_id"] = trim($_GET["admin_id"]);
    if(isset($_GET["admin_id"]) && !empty($_GET["admin_id"])){
        // Get URL parameter
        $admin_id =  trim($_GET["admin_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM Admins WHERE admin_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $admin_id;

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

                    $username = $row["username"];
					$pword = $row["pword"];
					

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
                                <label>username</label>
                                <input type="text" name="username" maxlength="30"class="form-control" value="<?php echo $username; ?>">
                                <span class="form-text"><?php echo $username_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>pword</label>
                                <input type="text" name="pword" class="form-control" value="<?php echo $pword; ?>">
                                <span class="form-text"><?php echo $pword_err; ?></span>
                            </div>

                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Admins-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
