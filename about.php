<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: register.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            max-width: 50%;
            margin: auto;
            margin-top: 50px;
        }
        @media (max-width: 768px) {
            .card {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">User Details</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user']['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
            <p><strong>Facebook URL:</strong> <a href="<?php echo htmlspecialchars($_SESSION['user']['url']); ?>" target="_blank"><?php echo htmlspecialchars($_SESSION['user']['url']); ?></a></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['user']['phone']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION['user']['gender']); ?></p>
            <p><strong>Country:</strong> <?php echo htmlspecialchars($_SESSION['user']['country']); ?></p>
            <p><strong>Skills:</strong> <?php echo implode(", ", $_SESSION['user']['skills']); ?></p>
            <p><strong>Biography:</strong> <?php echo htmlspecialchars($_SESSION['user']['biography']); ?></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
