<?php
session_start();
include('connection.php');

// Check if user is logged in
if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the inputs
    if (empty($email) || empty($username) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $password)) {
        $error = "Password must be at least 8 characters long, contain at least one uppercase letter and one special character.";
    } else {
       // Check if the email already exists
       $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
       $stmt->bind_param("s", $email);
       $stmt->execute();
       $result = $stmt->get_result();

       if ($result->num_rows > 0) {
           // If the email already exists
           $error = "Email is already been used. Please use a different one.";
       } else {
           // Check if the username already exists or is too similar
           $stmt = $con->prepare("SELECT * FROM users WHERE username LIKE ?");
           $searchUsername = "%" . $username . "%";  // Add wildcard for similar usernames
           $stmt->bind_param("s", $searchUsername);
           $stmt->execute();
           $result = $stmt->get_result();

           if ($result->num_rows > 0) {
               // If a similar username is found
               $error = "Username is already taken. Please choose a different one.";
           } else {
               // Hash the password for storage
               $hashed_password = password_hash($password, PASSWORD_DEFAULT);

               // Insert user into the database
               $stmt = $con->prepare("INSERT INTO users (email, username, user_pass) VALUES (?, ?, ?)");
               $stmt->bind_param("sss", $email, $username, $hashed_password);

               if ($stmt->execute()) {
                   // Redirect to login page with success message
                   header("Location: login.php?success=Account created successfully. Please log in.");
                   exit(); // Ensure no further code is executed after the redirect
               } else {
                   $error = "Error creating account. Please try again.";
               }
               $stmt->close();
           }
       }
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniXNobi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./styles/register.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <img src="./styles/uploads/aninobi-red.png" alt="" class="nav-brand">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars navbar-toggler-icon"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./landing.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
               <li class="nav-item">
                 <a href="login.php" class="nav-link user"><i class="fa-solid fa-user"></i></a>
               </li>
            </ul>
          </div>
        </div>
      </nav>

      <section class="normal-breadcrumb" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Registration Form</h2>
                        <p>Welcome to AniXNobi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
     <section class="registration">

        <div class="register-form second">
            <div class="blur-container">
                <h1>Join the AniXNobi Today!
                </h1>
                <h4>Take control of your anime journey by registering for our Anime Tracker. 
                    <br>Sign up to:
                </h4>
                <ul>
                    <li><strong>Track Your Progress:</strong> Create a personalized watchlist and mark episodes as you go.
                    </li>
                    <li><strong>Discover New Favorites:</strong> Get tailored recommendations based on your watch history.
                    </li>
                    <li><strong>Stay Updated:</strong> Never miss a release with alerts for upcoming episodes.
                    </li>
                    <li><strong>Connect with the Community:</strong> Share reviews, discuss theories, and find fellow fans.
                    </li>
                </ul>
                <h4>Start your adventure now—register for free and dive into the ultimate anime experience!
              </h4>
            </div>
            
         </div>
        <div class="register-form">
            <div class="text">
               REGISTER
            </div>
            <form method="POST" action="">
            <?php if (isset($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <?php if (isset($success)) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php } ?>
                
               <div class="field">
                <div class="fas">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                  <input type="text" placeholder="Email" name="email" required>
               </div>
               <div class="field">
                <div class="fas">
                    <i class="fa-solid fa-user"></i>
                </div>
                <input type="text" placeholder="Username" name="username" required>
             </div>
               <div class="field">
                <div class="fas">
                    <i class="fa-solid fa-lock"></i>
                </div>
                  <input type="password" placeholder="Password" name="password" required>
               </div>
               <button>SIGN UP</button>
               <div class="link">
                  Already a member?
                  <a href="login.php">Login!</a>
               </div>
            </form>
         </div>

         
     </section>

     <footer class="footer">
        <div class="footer-container">
          <div class="row">
            <div class="footer-col">
              <h4>ANI X NOBI</h4>
              <ul>
                <li><a href="#">about us</a></li>
                <li><a href="#">our services</a></li>
                <li><a href="#">privacy policy</a></li>
              </ul>
            </div>
            <div class="footer-col">
              <h4>Future Endeavour</h4>
              <ul>
                <li><a href="#">Anime Streaming App</a></li>
                <li><a href="#">Anime AI Image Generation</a></li>
                <li><a href="#">Anime Random Pictures</a></li>
                <li><a href="#">Anime Random Quotes</a></li>
              </ul>
            </div>
            <div class="footer-col">
              <h4>follow us</h4>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
      </footer>
      
    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="app.js"></script>
</body>
</html>