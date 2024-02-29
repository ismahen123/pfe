<?php
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "akwel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inscription de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $familyname = $_POST['familyname'];
    $poste = $_POST['poste'];
    $email = $_POST['email'];
    $cin = $_POST['cin'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, familyname, poste, email, CIN, password) VALUES ('$username', '$familyname', '$poste', '$email', '$cin', '$hashed_password')";

    if ($conn->query($query) === TRUE) {
        echo "Inscription réussie.";
    } else {
        echo "Erreur lors de l'inscription: " . $conn->error;
    }
}

// Connexion de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "Connexion réussie.";
        } else {
            echo "Identifiants incorrects.";
        }
    } else {
        echo "Identifiants incorrects.";
    }
}

$conn->close();
?>