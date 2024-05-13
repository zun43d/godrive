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

// Retrieve user information
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM Users WHERE user_id = '$user_id'";
$result_user = mysqli_query($conn, $sql_user);
$row_user = mysqli_fetch_assoc($result_user);

$sql_rider_id = "SELECT Riders.rider_id FROM Riders JOIN Users ON Riders.user_id = Users.user_id WHERE Users.user_id = '$user_id';";
$result_rider_id = mysqli_query($conn, $sql_rider_id);

if (mysqli_num_rows($result_rider_id) == 1) {
	$rider_row = mysqli_fetch_assoc($result_rider_id);
	$GLOBALS["rider_id"] = $rider_row['rider_id'];
} else {
	$GLOBALS["rider_id"] = NULL;
}

// Retrieve user's rides
$rider= $GLOBALS["rider_id"];
$sql_rides = "SELECT * FROM Rides WHERE rider_id = '$rider_id'";
$result_rides = mysqli_query($conn, $sql_rides);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ride Sharing App - Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
</head>
<body class="bg-light">
  <div class="container">
    <h1 class="mt-5 text-center">Welcome, <?php echo $row_user['username']; ?>!</h1>
    <h2 class="text-center">User Dashboard</h2>
	<div class="d-flex justify-content-between mt-5">
	  <h3 class="">Your Rides</h3>
	  <a href="newride.php" class="btn btn-primary">Create New Ride</a>
	</div>
    <?php if (mysqli_num_rows($result_rides) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered mt-3">
        <thead class="thead-dark">
          <tr>
            <th>Ride ID</th>
            <th>Driver ID</th>
			<th>Rider ID</th>
            <th>Pickup Location</th>
            <th>Dropoff Location</th>
            <th>Ride Status</th>
            <th>Ride Date</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row_ride = mysqli_fetch_assoc($result_rides)): ?>
          <tr>
            <td><?php echo $row_ride['ride_id']; ?></td>
            <td><?php echo $row_ride['driver_id']; ?></td>
			<td><?php echo $row_ride['rider_id']; ?></td>
            <td><?php echo $row_ride['pickup_location']; ?></td>
            <td><?php echo $row_ride['dropoff_location']; ?></td>
            <td><?php echo $row_ride['ride_status']; ?></td>
            <td><?php echo $row_ride['ride_date']; ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <p>No rides found.</p>
    <?php endif; ?>
    <p class="text-center"><a href="logout.php" class="btn btn-danger">Log out</a></p>
  </div>
</body>
</html>




