
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

if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];
    $person = $_POST['person'];
    $date = $_POST['date'];


    if (empty(trim($task))) {
        header('Location: index.php?message=Feladat megadása kötelező!');
        exit;
    }

    if (empty(trim($task_description))) {
        header('Location: index.php?message=Feladat leírása kötelező!');
        exit;
    }

    if (empty(trim($status))) {
        header('Location: index.php?message=Állapot megadása kötelező!');
        exit;
    }

    if (empty(trim($person))) {
        header('Location: index.php?message=Dolgozó megadása kötelező!');
        exit;
    }

    if (empty(trim($date))) {
        header('Location: index.php?message=Dátum megadása kötelező!');
        exit;
    }

    try {
        $query = "INSERT INTO tasks (name, description, status, person, date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$task, $task_description, $status, $person, $date]);

        header('Location: index.php?insert_msg=Feladat sikeresen hozzáadva!');
        exit;
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
?>
