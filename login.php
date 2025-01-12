<?php
session_start();

// Display SweetAlert if error is present in the URL
if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '$error_message',
                confirmButtonText: 'OK',
                confirmButtonColor: 'gray',
                background: '#0e0d0d',
                color: 'white',
                iconColor: 'gray'
            });
        });
    </script>
    ";
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

      <section class="normal-breadcrumb second" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                        <p>Welcome Back to AniXNobi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
     <section class="registration">

        <div class="login-form second">
            <div class="blur-container">
                <h1>Return, Brave Otaku!
                </h1>
                <h4>Your journey through the anime realms awaits!
                    <br>Login to:
                </h4>
                <ul>
                    <li><strong>Resume Your Quest:</strong> Access your watchlist and continue conquering episodes.
                    </li>
                    <li><strong>Unlock New Adventures:</strong> Discover fresh series and hidden treasures.
                    </li>
                    <li><strong>Stay in the Loop:</strong> Track the latest releases and trending sagas.
                    </li>
                    <li><strong>Unite with Fellow Fans:</strong> Share your thoughts and theories with the community.
                    </li>
                </ul>
                <h4>Log in now to reclaim your path as a true anime hero!
              </h4>
            </div>
            
         </div>
        <div class="login-form">
            <div class="text">
               LOGIN
            </div>
            <form method="POST" action="user-login-logic.php">
               <div class="field">
                <div class="fas">
                    <i class="fa-solid fa-user"></i>
                </div>
                <input type="text" placeholder="Username" name="username">
             </div>
               <div class="field">
                <div class="fas">
                    <i class="fa-solid fa-lock"></i>
                </div>
                  <input type="password" placeholder="Password" name="password">
               </div>
               <button>LOGIN</button>
               <div class="link">
                  Not a member?
                  <a href="register.php">Register Now!</a>
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