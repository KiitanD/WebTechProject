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
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $fname = trim($_POST["fname"]);
		$lname = trim($_POST["lname"]);
		$email = trim($_POST["email"]);
		$pword = trim($_POST["pword"]);
		$job_title = trim($_POST["job_title"]);
		$org_name = trim($_POST["org_name"]);
		$is_presenter = trim($_POST["is_presenter"]);
		

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

        $vars = parse_columns('People', $_POST);
        $stmt = $pdo->prepare("INSERT INTO People (fname,lname,email,pword,job_title,org_name,is_presenter) VALUES (?,?,?,?,?,?,?)");

        if($stmt->execute([ $fname,$lname,$email,$pword,$job_title,$org_name,$is_presenter  ])) {
                $stmt = null;
                header("location: People-index.php");
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="People-index.php" class="btn btn-secondary">Cancel</a>
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
