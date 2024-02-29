<?php
// Connexion à la base de données
$servername = "localhost";
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
    $cin = $_POST['id'];
    $password = $_POST['pswd'];
    $confirmPassword = $_POST['confirm_password'];

    // Validation des données
    if (empty($username) || empty($familyname) || empty($poste) || empty($email) || empty($cin) || empty($password) || empty($confirmPassword)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email invalide.";
        exit;
    }

    if (strlen($password) < 8) {
        echo "Le mot de passe doit comporter au moins 8 caractères.";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Vérification si l'email est déjà utilisé
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
        exit;
    }

    // Hashage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion des données dans la base de données
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

    // Validation des données
    if (empty($email) || empty($password)) {
        echo "Email et mot de passe sont obligatoires.";
        exit;
    }

    // Récupération de l'utilisateur depuis la base de données
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
