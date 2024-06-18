<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$comment_sent = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['user'];
    $comment = sanitize($_POST['comment']);

    $sql = "INSERT INTO comments (username, email, comment, approved) VALUES ('$username', '', '$comment', 0)";

    if ($conn->query($sql) === TRUE) {
        $comment_sent = true;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie um comentário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Envie um comentário</h2>
    <?php if ($comment_sent) { ?>
        <div class="alert alert-success text-center">Comentário enviado com sucesso! Você será redirecionado para a página de comentários em breve.</div>
        <script>
            setTimeout(function() {
                window.location.href = 'view_comments.php';
            }, 3000); // Redireciona após 3 segundos
        </script>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <?php if (!$comment_sent) { ?>
        <form method="POST" class="w-50 mx-auto">
            <div class="mb-3">
                <label for="comment" class="form-label">Comentário</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </form>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
