<?php
include('auth.php');
include('header.php');
include('database.php');
 

$username = $_SESSION['user'];
$role = $_SESSION['role'];
?>

<div class="d-flex justify-content-between align-items-center my-3">
    <div><h4>Üdvözöljük,<br> <?php echo htmlspecialchars($username); ?>!</h4></div>
    <?php if ($role === 'admin'): ?>
        <div class="button1">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Feladat hozzáadása</button>
        </div>
    <?php endif; ?>
    <div>
        <a href="logout.php" class="btn btn-danger">Kijelentkezés</a>
    </div>
</div>

<?php
if (isset($_GET['message'])) {
    echo '<div class="alert alert-info">' . htmlspecialchars($_GET['message']) . '</div>';
}

if (isset($_GET['insert_msg'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['insert_msg']) . '</div>';
}

if (isset($_GET['update_msg'])) {
    echo '<div class="alert alert-warning">' . htmlspecialchars($_GET['update_msg']) . '</div>';
}

if (isset($_GET['delete_msg'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['delete_msg']) . '</div>';
}
?>

<?php include('search.php'); ?>

<?php if ($role === 'admin'): ?>
    <form action="add_task.php" method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Feladat hozzáadása</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="task">Feladat</label>
                            <input type="text" name="task" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="task_description">Feladat leírása</label>
                            <input type="text" name="task_description" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="status">Állapot</label>
                            <input type="text" name="status" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="person">Dolgozó</label>
                            <input type="text" name="person" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="date">Dátum</label>
                            <input type="date" name="date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                        <input type="submit" class="btn btn-success" name="add_task" value="Feladat hozzáadása">
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php include('end.php'); ?>
