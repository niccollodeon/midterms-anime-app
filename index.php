<?php
session_start();
include('connection.php');

// Check if the user is logged in and if not redirect to landing page
if (!isset($_SESSION['username'])) {
  header("Location: landing.php");
  exit();
}

// Sweet alert if login is successful
if (isset($_SESSION['login_success'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Login Successful",
                text: "Welcome to your watchlist page!",
                confirmButtonText: "OK",
                confirmButtonColor: "gray",
                background: "#0e0d0d",
                color: "white",
                iconColor: "gray"
            });
        });
    </script>';
  unset($_SESSION['login_success']);
}

// Sweet alert if update is successful
if (isset($_SESSION['update_success'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Update Successful",
                text: "Welcome to your watchlist page!",
                confirmButtonText: "OK",
                confirmButtonColor: "gray",
                background: "#0e0d0d",
                color: "white",
                iconColor: "gray"
            });
        });
    </script>';
  unset($_SESSION['update_success']);
}

// Sweet alert if login is successful
if (isset($_SESSION['update_error'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Update Error",
                text: "Return to your Watchlist page!",
                confirmButtonText: "OK",
                confirmButtonColor: "gray",
                background: "#0e0d0d",
                color: "white",
                iconColor: "gray"
            });
        });
    </script>';
  unset($_SESSION['update_error']);
}

// Sweet alert if login is successful
if (isset($_SESSION['add_success'])) {
  echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "success",
                title: "Anime Added Successfully",
                text: "Welcome to your watchlist page!",
                confirmButtonText: "OK",
                confirmButtonColor: "gray",
                background: "#0e0d0d",
                color: "white",
                iconColor: "gray"
            });
        });
    </script>';
  unset($_SESSION['add_success']);
}

// Check if the user is logged in and if not redirect to landing page
if (!isset($_SESSION['username'])) {
  header("Location: landing.php");
  exit();
}

$user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session

// Fetch anime for the logged-in user, filtered by category
function fetchAnime($category, $user_id)
{
  global $con;
  $stmt = $con->prepare("SELECT * FROM anime WHERE categories = ? AND user_id = ?");
  $stmt->bind_param("si", $category, $user_id);
  $stmt->execute();
  return $stmt->get_result();
}

// Fetching anime for different categories
$watchingAnime = fetchAnime('Watching', $user_id);
$onHoldAnime = fetchAnime('Onhold', $user_id);
$completedAnime = fetchAnime('Completed', $user_id);
$droppedAnime = fetchAnime('Dropped', $user_id);


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

  <link rel="stylesheet" href="./styles/index.css">
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle user" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="./logout.php">Logout</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <section class="index-container">
    <div class="watchlist-container">
      <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Watching')">Watching</button>
        <button class="tablinks" onclick="openCity(event, 'Onhold')">On Hold</button>
        <button class="tablinks" onclick="openCity(event, 'Completed')">Completed</button>
        <button class="tablinks" onclick="openCity(event, 'Dropped')">Dropped</button>
      </div>

      <!-- Tab content -->

      <div id="Watching" class="tabcontent">
        <div class="card-container d-flex flex-wrap justify-content-evenly">
          <?php
          if ($watchingAnime->num_rows > 0) {
            while ($row = $watchingAnime->fetch_assoc()) {
              $defaultImage = "./styles/uploads/6870066_0.webp";
              echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . htmlspecialchars($defaultImage) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                    <div class="card-body d-flex justify-content-center">
                        <button data-bs-toggle="modal" data-bs-target="#editPage" class="card-text" data-id="' . htmlspecialchars($row['anime_id']) . '">' . htmlspecialchars($row['title']) . '</button>
                    </div>
                </div>';
            }
          } else {
            echo '<p>No anime found in the "Watching" category.</p>';
          }
          ?>

        </div>
      </div>

      <div id="Onhold" class="tabcontent">
        <div class="card-container d-flex flex-wrap justify-content-evenly">
        <?php
          if ($onHoldAnime->num_rows > 0) {
            while ($row = $onHoldAnime->fetch_assoc()) {
              $defaultImage = "./styles/uploads/6870066_0.webp";
              echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . htmlspecialchars($defaultImage) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                    <div class="card-body d-flex justify-content-center">
                        <button data-bs-toggle="modal" data-bs-target="#editPage" class="card-text" data-id="' . htmlspecialchars($row['anime_id']) . '">' . htmlspecialchars($row['title']) . '</button>
                    </div>
                </div>';
            }
          } else {
            echo '<p>No anime found in the "On Hold" category.</p>';
          }
          ?>
        </div>
      </div>

      <div id="Completed" class="tabcontent">
        <div class="card-container d-flex flex-wrap justify-content-evenly">
        <?php
          if ($completedAnime->num_rows > 0) {
            while ($row = $completedAnime->fetch_assoc()) {
              $defaultImage = "./styles/uploads/6870066_0.webp";
              echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . htmlspecialchars($defaultImage) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                    <div class="card-body d-flex justify-content-center">
                        <button data-bs-toggle="modal" data-bs-target="#editPage" class="card-text" data-id="' . htmlspecialchars($row['anime_id']) . '">' . htmlspecialchars($row['title']) . '</button>
                    </div>
                </div>';
            }
          } else {
            echo '<p>No anime found in the "Completed" category.</p>';
          }
          ?>
        </div>
      </div>

      <div id="Dropped" class="tabcontent">
        <div class="card-container d-flex flex-wrap justify-content-evenly">
        <?php
          if ($droppedAnime->num_rows > 0) {
            while ($row = $droppedAnime->fetch_assoc()) {
              $defaultImage = "./styles/uploads/6870066_0.webp";
              echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . htmlspecialchars($defaultImage) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                    <div class="card-body d-flex justify-content-center">
                        <button data-bs-toggle="modal" data-bs-target="#editPage" class="card-text" data-id="' . htmlspecialchars($row['anime_id']) . '">' . htmlspecialchars($row['title']) . '</button>
                    </div>
                </div>';
            }
          } else {
            echo '<p>No anime found in the "Dropped" category.</p>';
          }
          ?>
        </div>
      </div>
    </div>

    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addPage">
      <i class="fa-solid fa-plus"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addPage" tabindex="1000" aria-labelledby="AnimeAdd" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="AnimeAdd">Add Anime To Your Watchlist</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="add-anime.php" method="POST" class="addAnime">
              <label for="animeName">Anime Name: </label>
              <input type="text" name="animeName" placeholder="Enter the Anime">
              <br><br>
              <label for="watchlist-s">Watchlist Categories: </label>
              <select name="watchlist-s" id="watchlist-s" class="watchlist-s">
                <option value="Watching">Watching</option>
                <option value="Onhold">On Hold</option>
                <option value="Completed">Completed</option>
                <option value="Dropped">Dropped</option>
              </select>
              <br><br>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editPage" tabindex="1000" aria-labelledby="editAnime" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editAnime">Updating your Progress</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="update-anime.php" method="post" class="animeEdit">
              <input type="hidden" name="anime_id" id="anime_id">
              <label for="watchlist-s">Watchlist Categories: </label>
              <select name="watchlist-s" id="watchlist-s" class="watchlist-s">
                <option value="Watching">Watching</option>
                <option value="Onhold">On Hold</option>
                <option value="Completed">Completed</option>
                <option value="Dropped">Dropped</option>
              </select>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


  </section>



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>