<?php
include 'db.php';

// Definindo o nome de usuário e a senha
$username = 'Lui';
$password = password_hash('luigay', PASSWORD_BCRYPT);
$role = 'admin';

// Verifica se o usuário já existe
$sql_check = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "O usuário 'admin' já existe.";
} else {
    // Insere o novo usuário admin
    $sql_insert = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Admin user created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
