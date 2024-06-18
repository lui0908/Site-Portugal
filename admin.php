<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment_id']) && isset($_POST['action'])) {
        $comment_id = sanitize($_POST['comment_id']);
        $action = sanitize($_POST['action']);

        if ($action == 'approve') {
            $sql = "UPDATE comments SET approved=1 WHERE id='$comment_id'";
        } elseif ($action == 'delete') {
            $sql = "DELETE FROM comments WHERE id='$comment_id'";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Action successful";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_FILES['json_file'])) {
        $json_data = file_get_contents($_FILES['json_file']['tmp_name']);
        $comments = json_decode($json_data, true);

        foreach ($comments as $comment) {
            $nome = sanitize($comment['nome']);
            $email = sanitize($comment['email']);
            $comentario = sanitize($comment['comentario']);
            $sql = "INSERT INTO comments (username, email, comment, approved) VALUES ('$nome', '$email', '$comentario', 0)";
            $conn->query($sql);
        }
        echo "Comments imported successfully";
    }
}

$sql = "SELECT * FROM comments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Painel Administrativo</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="view_comments.php" class="btn btn-secondary me-2">Voltar para Comentários</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Comentário</th>
                <th>Aprovado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['comment']); ?></td>
                <td><?php echo $row['approved'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Aprovar</button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm">Rejeitar</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3 class="mt-5">Importar Comentários via JSON</h3>
    <form method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <input type="file" name="json_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
