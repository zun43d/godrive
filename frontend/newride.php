<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Include database configuration
include_once "config.php";

// Handle form submission
if (isset($_POST['create_ride'])) {
  // Retrieve form data
  // $driver_id = ; // Assuming the logged-in user is a driver
  $pickup_location = $_POST['pickup_location'];
  $dropoff_location = $_POST['dropoff_location'];
  $ride_status = 'pending'; // Initial ride status
  $ride_date = date('Y-m-d H:i:s'); // Current date and time

  // Insert new ride into Rides table
  $sql_ride = "INSERT INTO rides (driver_id, rider_id, pickup_location, dropoff_location, ride_status, ride_date) VALUES (NULL, 1, '$pickup_location', '$dropoff_location', '$ride_status', '$ride_date')";

  if (mysqli_query($conn, $sql_ride)) {
    $ride_id = mysqli_insert_id($conn); // Get the ID of the newly inserted ride

    // Insert payment record into Payments table
    $amount = $_POST['fare'];
    $payment_date = date('Y-m-d H:i:s'); // Current date and time

    $sql_payment = "INSERT INTO payments (ride_id, amount, payment_date) VALUES ('$ride_id', '$amount', '$payment_date')";

    if (mysqli_query($conn, $sql_payment)) {
      $message = "Ride and payment created successfully!";
    } else {
      $message = "Error creating payment: " . mysqli_error($conn);
    }
  } else {
    $message = "Error creating ride: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Ride</title>
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
            <h1 class="card-title text-center">Create a New Ride</h1>
            <form action="newride.php" method="post">
              <div class="form-group">
                <label for="pickup_location">Pickup Location</label>
                <input type="text" class="form-control" id="pickup_location" name="pickup_location" placeholder="Enter pickup location" required>
              </div>
              <div class="form-group">
                <label for="dropoff_location">Dropoff Location</label>
                <input type="text" class="form-control" id="dropoff_location" name="dropoff_location" placeholder="Enter dropoff location" required>
              </div>
              <div class="form-group">
                <label for="fare">Fare</label>
                <input type="number" class="form-control" id="fare" name="fare" placeholder="Enter fare" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="create_ride">Create Ride</button>
            </form>
            <?php if (isset($message)): ?>
            <div class="alert alert-success mt-3" role="alert"><?php echo $message; ?></div>
            <?php endif; ?>
            <p class="text-center mt-3"><a href="dashboard.php">Back to Dashboard</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>