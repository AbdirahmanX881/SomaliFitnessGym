<?php
session_start();

require_once "../includes/config.php";

$fname = $lname = $email = $phone = $password = $confirm_password = "";
$fname_err = $lname_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter your first name.";
    } else {
        $fname = trim($_POST["fname"]);
    }

    // Validate last name
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter your last name.";
    } else {
        $lname = trim($_POST["lname"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $sql = "SELECT p_no FROM people WHERE email = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = trim($_POST["email"]);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passwords did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if (empty($fname_err) && empty($lname_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err)) {
        
        $sql = "INSERT INTO people (fname, lname, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)";
         
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_fname, $param_lname, $param_email, $param_phone, $param_password, $param_role);
            
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_phone = $phone;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_role = 'member'; // Default role for signup
            
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Somali Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .signup-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
            width: 100%;
        }
        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .signup-header img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .form-floating {
            margin-bottom: 15px;
        }
        .btn-signup {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-signup:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <img src="../assets/img/logo.png" alt="Somali Fitness Logo">
            <h2>Create an Account</h2>
            <p>Join Somali Fitness today!</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" id="floatingFirstName" placeholder="First Name" value="<?php echo $fname; ?>">
                        <label for="floatingFirstName">First Name</label>
                        <div class="invalid-feedback"><?php echo $fname_err; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" id="floatingLastName" placeholder="Last Name" value="<?php echo $lname; ?>">
                        <label for="floatingLastName">Last Name</label>
                        <div class="invalid-feedback"><?php echo $lname_err; ?></div>
                    </div>
                </div>
            </div>

            <div class="form-floating">
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="floatingEmail" placeholder="name@example.com" value="<?php echo $email; ?>">
                <label for="floatingEmail">Email address</label>
                <div class="invalid-feedback"><?php echo $email_err; ?></div>
            </div>

            <div class="form-floating">
                <input type="tel" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="floatingPhone" placeholder="Phone Number" value="<?php echo $phone; ?>">
                <label for="floatingPhone">Phone Number</label>
                <div class="invalid-feedback"><?php echo $phone_err; ?></div>
            </div>

            <div class="form-floating">
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <div class="invalid-feedback"><?php echo $password_err; ?></div>
            </div>

            <div class="form-floating">
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="floatingConfirmPassword" placeholder="Confirm Password">
                <label for="floatingConfirmPassword">Confirm Password</label>
                <div class="invalid-feedback"><?php echo $confirm_password_err; ?></div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-signup" type="submit">Sign Up</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php" class="text-decoration-none">Login</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
