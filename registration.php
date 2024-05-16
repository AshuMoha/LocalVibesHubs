<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0d3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
			background-image: url('./login\ page\ background.jpg');
    		background-size: cover;
    		background-position: center;
    		background-repeat: no-repeat;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
		input[type="tel"],
        input[type="password"]{
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form method="post" action="registration.php">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
			<input type="tel" name="mobile" placeholder="Mobile no" required>
            <label for="user">User: </label>
                <input type="radio" name="user" id="admin">Admin
                <input type="radio" name="user" id="customer">Customer
                <input type="radio" name="user" id="vendor">Vendor
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Your Password" required>
            <input type="submit" value="Register">
        </form>
    </div>
   
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    require_once "db-con.php";
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["mobile"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["user"])) {
        // Retrieve form data
        $name = $_POST["fullname"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $user_type = $_POST["user"];

        // Validate password and confirm password match
        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
            exit;
        }

        // Insert user data into the appropriate table based on user type
        switch ($user_type) {
            case "admin":
                 $qry= "INSERT INTO admin_table (admin_name, admin_email, admin_mobile, admin_password) VALUES ('$name','$email',$mobile,'$password')";
                 break;
            case "customer":
                // Insert into customer table
                $qry= "INSERT INTO customer_table (customer_name, customer_email, customer_mobile, customer_password) VALUES ('$name','$email','$mobile','$password')";
                break;
            case "vendor":
                // Insert into vendor table
                $qry= "INSERT INTO vendor_table (vendor_vendor_name, vendor_email, vendor_mobile, vendor_password) VALUES ('$name','$email','$mobile','$password')";
                break;
            default:
                // Handle invalid user type
                echo "Invalid user type.";
                exit;
        }
        // Executing Query
        $res = $conn->query($qry);
            
        // Check for error / success
        if($res){
            echo "You are successfully registered";
        } else {
            echo "Error: ".$conn->error;
        }

        // Close Connection
        $conn->close();
        // Redirect user to different homepages based on their roles
        /*switch ($user_type) {
            case "admin":
                header("Location: admin_homepage.php");
                break;
            case "customer":
                header("Location: customer_homepage.php");
                break;
            case "vendor":
                header("Location: vendor_homepage.php");
                break;
            default:
                // Handle invalid user type
                echo "Invalid user type.";
                exit;
        }*/
    } else {
        // Handle case where required fields are not filled
        echo "All fields are required.";
    }
}
?>
