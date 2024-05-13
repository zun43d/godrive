<?php
// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}

// Include database configuration
include_once "config.php";

// Function to generate a random user ID
function generateUserID() {
  return uniqid(); // You can use other methods to generate a unique ID as well
}

// Handle sign up logic
if (isset($_POST['signup'])) {
  // Retrieve form data
  $username = $_POST['username'];
  $password = $_POST['password'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
  $user_type = $_POST['user_type'];

  // Generate user ID
  $user_id = generateUserID();

  // Insert user into Users table
  $sql_user = "INSERT INTO Users (user_id, username, password, email, phone_number) VALUES ('$user_id', '$username', '$password', '$email', '$phone_number')";
  
  if (mysqli_query($conn, $sql_user)) {
    if ($user_type == 'driver') {
      // Retrieve additional driver details
      $license_number = $_POST['license_number'];
      $car_model = $_POST['car_model'];
      $car_registration_number = $_POST['car_registration_number'];

      // Insert driver details into Drivers table with manually entered driver_id
      $driver_id = generateUserID(); // Generate driver ID
      $sql_driver = "INSERT INTO Drivers (driver_id, user_id, license_number, car_model, car_registration) VALUES ('$driver_id', '$user_id', '$license_number', '$car_model', '$car_registration_number')";
      $result_driver = mysqli_query($conn, $sql_driver);
    } elseif ($user_type == 'rider') {
      // Retrieve additional rider details
      $payment_method = $_POST['payment_method'];

      // Insert rider details into Riders table with manually entered rider_id
      $rider_id = generateUserID(); // Generate rider ID
      $sql_rider = "INSERT INTO Riders (rider_id, user_id, payment_method) VALUES ('$rider_id', '$user_id', '$payment_method')";
      $result_rider = mysqli_query($conn, $sql_rider);
    }

    $signup_message = "User signed up successfully!";
  } else {
    $signup_message = "Error: " . $sql_user . "<br>" . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ride Sharing App - Sign Up</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title text-center">Sign Up</h1>
            <form action="signup.php" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
              </div>
              <div class="form-group">
                <select class="form-control" name="user_type" required>
                  <option value="">Select User Type</option>
                  <option value="rider">Sign Up as a Rider</option>
                  <option value="driver">Sign Up as a Driver</option>
                </select>
              </div>
              <div id="driver-details" style="display: none;">
                <div class="form-group">
                  <input type="text" class="form-control" name="license_number" placeholder="License Number">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="car_model" placeholder="Car Model">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="car_registration_number" placeholder="Car Registration Number">
                </div>
              </div>
              <div id="rider-details" style="display: none;">
                <div class="form-group">
                  <select class="form-control" name="payment_method">
                    <option value="">Select Payment Method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bkash">Bkash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Card">Card</option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="signup">Sign Up</button>
            </form>
            <?php if (isset($signup_message)): ?>
            <div class="alert alert-success mt-3" role="alert"><?php echo $signup_message; ?></div>
            <?php endif; ?>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Log in here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Show/hide additional fields based on selected user type
    document.querySelector('select[name="user_type"]').addEventListener('change', function() {
      var userType = this.value;
      if (userType === 'driver') {
        document.getElementById('driver-details').style.display = 'block';
        document.getElementById('rider-details').style.display = 'none';
      } else if (userType === 'rider') {
        document.getElementById('driver-details').style.display = 'none';
        document.getElementById('rider-details').style.display = 'block';
      } else {
        document.getElementById('driver-details').style.display = 'none';
        document.getElementById('rider-details').style.display = 'none';
      }
    });
  </script>
</body>
</html>
