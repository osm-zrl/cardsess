<?php

session_start();
$servername = "localhost:3030"; 
$username = 'root';
$password = ""; 
$dbname = 'atdc'; 
$errorMessage = '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

if(isset($_POST['username']) && isset($_POST['password'])){
    $usernameInput = $_POST['username'];
    $passwordInput = md5($_POST['password']);

    // hada 3la 8bel sql injection (khouk professionell)
    $usernameInput = $conn->real_escape_string($usernameInput);
    $passwordInput = $conn->real_escape_string($passwordInput);

    $sql = "SELECT * FROM admin WHERE username = '$usernameInput' AND password = '$passwordInput'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $usernameInput;
        
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = "<p>Nom d'utilisateur ou mot de passe incorrect</p>";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
        /*  colors  */
        --first-color : #15214a;
        --second-color : #CDD8FD;
        --third-color : #414D75;
        --white-color : #ffffff;
        --grey-color : #e4e2e2;
        --black-color : #000000;
        --text-grey : #898989;
        /*  transitions  */
        --transition : all 300ms ease-in-out;
        /*  border  */
        --border : 1px solid var(--second-color);
        --border-radius : 12px;
        /*  gap  */
        --gap-grid : 1rem;
        /*  cursor  */
        --cursor : pointer;
        /*  font-family  */
        --font-family : 'Roboto', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f1f1f1;
      font-family: Arial, sans-serif;
      background: var(--first-color);
      background: linear-gradient(180deg, var(--first-color) 35%, var(--grey-color) 35%);
    }

    .card {
      width: 300px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .card img {
      width: 100px;
      height: 100px;
      margin-bottom: 20px;
    }

    .card .input-container {
      position: relative;
      width: 90%;
    }

    .card input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .card input[type="text"]{
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .card .password-toggle {
      position: absolute;
      right: 2px;
      top: 40%;
      transform: translateY(-50%);
      cursor: pointer;
      opacity: 0.5;
    }

    .card button {
      width: 100%;
      padding: 10px;
      background-color: #15214a;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: 0.5s;
    }

    .card button:hover {
      background-color: #414D75;
    }
  </style>
</head>
<body>
  <div class="card">
    <img src="img/Logo_ofppt.png" alt="Logo">
    <form method='POST'>
      <?php echo $errorMessage; ?>
      <input type="text" name="username" placeholder="Nom d'utilisateur" required>
      <br>
      <div class="input-container">
        <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        <span class="password-toggle" onclick="togglePassword()"><i class="far fa-eye" style="font-size: 14px;"></i></span>
      </div>
      <br>
      <button type="submit">Se connecter</button>
    </form>
  </div>

  <script>
    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var passwordToggle = document.querySelector(".password-toggle");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.style.opacity = "0.5";
      } else {
        passwordInput.type = "password";
        passwordToggle.style.opacity = "1";
      }
    }
  </script>
</body>
</html>
