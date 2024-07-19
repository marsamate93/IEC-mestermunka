
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


include('header.php');
include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $query = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $task = $stmt->fetch();

        if (!$task) {
            die("Feladat nem található");
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}

if (isset($_POST['update_task'])) {
    $task = $_POST['task'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];
    $person = $_POST['person'];
    $date = $_POST['date'];

    if (empty(trim($task)) || empty(trim($task_description)) || empty(trim($status)) || empty(trim($person)) || empty(trim($date))) {
        header("Location: update_task.php?id=$id&message=Minden mező kitöltése kötelező!");
        exit;
    }

    try {
        $query = "UPDATE tasks SET name = ?, description = ?, status = ?, person = ?, date = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$task, $task_description, $status, $person, $date, $id]);

        header("Location: index.php?update_msg=Feladat sikeresen módosítva!");
        exit;
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
?>


<body>
    <h2>Feladat módosítása</h2>
    
    <?php if (isset($_GET['message'])) 
    { 
         echo $_GET['message'];
    } ?>

    <form action="update_task.php?id=<?php echo $id; ?>" method="post">
        <div class="form-group">
            <label for="task">Feladat</label>
            <input type="text" name="task" class="form-control" value="<?php echo htmlspecialchars($task['name']); ?>">
        </div>

        <div class="form-group">
            <label for="task_description">Feladat leírása</label>
            <input type="text" name="task_description" class="form-control" value="<?php echo htmlspecialchars($task['description']); ?>">
        </div>

        <div class="form-group">
            <label for="status">Állapot</label>
            <input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars($task['status']); ?>">
        </div>

        <div class="form-group">
            <label for="person">Dolgozó</label>
            <input type="text" name="person" class="form-control" value="<?php echo htmlspecialchars($task['person']); ?>">
        </div>

        <div class="form-group">
            <label for="date">Dátum</label>
            <input type="text" name="date" class="form-control" value="<?php echo htmlspecialchars($task['date']); ?>">
        </div>

        <div class="button-group">
                <input type="submit" class="btn btn-success" name="update_task" value="Feladat módosítása">
                <a href="index.php" class="btn btn-danger">Vissza</a>
            </div>
    </form>

    <?php include('end.php'); ?>


