<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM comments WHERE approved = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <nav class="header-bg navbar navbar-expand-lg" id="nav">
        <div class="container">
            <a class="navbar-brand" href="index.html" id="logo"><span id="logosep">Portugal</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span><i class="fa-solid fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="sobre.html">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="culinaria.html">Culinária</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="selecao.html">Seleção</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CR7.html">CR7</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_comments.php">Comentários</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php"><i class="fas fa-user-cog"></i> Painel Admin</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Comentários</h2>
        <div class="text-center mb-3">
            <a href="comment.php" class="btn btn-primary">Fazer Novo Comentário</a>
        </div>
        <?php if ($result->num_rows > 0) { ?>
            <ul class="list-group">
                <?php while($row = $result->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($row['username']); ?></h5>
                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="alert alert-info text-center">Nenhum comentário aprovado ainda.</div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
