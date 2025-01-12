<?php
session_start();
include('connection.php');

// Sweet alert if login is successful
if (isset($_SESSION['delete_success'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "User Deleted Successfully",
                text: "Head Back to your users page!",
                confirmButtonText: "OK",
                confirmButtonColor: "gray",
                background: "#0e0d0d",
                color: "white",
                iconColor: "gray"
            });
        });
    </script>';
  unset($_SESSION['delete_success']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AniXNobi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="styles/admin.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <img src="./styles/uploads/aninobi-red.png" alt="" class="nav-brand">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars navbar-toggler-icon"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./landing.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Watchlist</a>
          </li>
          <li class="nav-item">
            <a href="./logout.php" class="nav-link user"><i class="fa-solid fa-right-from-bracket"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="table-section">
    <div class="table-container">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email Address</th>
            <th>Account Type</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'connection.php'; // Include database connection
          
          // Query to fetch all users
          $sql = "SELECT user_id, username, email, account_type FROM users";
          $result = $con->query($sql);

          // Check if there are results
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['user_id']}</td>
                      <td>{$row['username']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['account_type']}</td>
                      <td>
                          <button class='edit-btn btn btn-primary' data-bs-toggle='modal' data-bs-target='#editUser' type='button' data-id='{$row['user_id']}'>
                              <i class='fas fa-edit'></i>
                          </button>
                      </td>
                      <td>
                          <form method='POST' action='delete-user.php' onsubmit='return confirm(\"Are you sure you want to delete this user?\")'>
                              <input type='hidden' name='user_id' value='{$row['user_id']}'>
                              <button type='submit' class='btn btn-danger'>
                                  <i class='fa-solid fa-trash'></i>
                              </button>
                          </form>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No users found</td></tr>";
          }

          $con->close(); // Close the database connection
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>