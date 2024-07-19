<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Nincs jogosultságod ehhez a művelethez.";
    exit();
}

include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        header("Location: index.php?delete_msg=Feladat sikeresen törölve!");
        exit;
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: index.php?message=");
    exit;
}
?>
