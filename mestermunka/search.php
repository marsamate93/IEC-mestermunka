<?php
include('database.php');

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
$personFilter = isset($_GET['person']) ? $_GET['person'] : '';

$statusOptions = $pdo->query("SELECT DISTINCT status FROM tasks ORDER BY status")->fetchAll(PDO::FETCH_ASSOC);
$dateOptions = $pdo->query("SELECT DISTINCT date FROM tasks ORDER BY date")->fetchAll(PDO::FETCH_ASSOC);
$personOptions = $pdo->query("SELECT DISTINCT person FROM tasks ORDER BY person")->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM tasks WHERE 1";
$params = [];

if (!empty($statusFilter)) {
    $query .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

if (!empty($dateFilter)) {
    $query .= " AND date = :date";
    $params[':date'] = $dateFilter;
}

if (!empty($personFilter)) {
    $query .= " AND person = :person";
    $params[':person'] = $personFilter;
}

$query .= " ORDER BY id DESC";
?>

<script>
    function resetFilters() {
        document.getElementById('status').value = '';
        document.getElementById('date').value = '';
        document.getElementById('person').value = '';
        document.querySelector('form').submit();
    }
</script>

<form method="get" class="row g-3 mb-3">
  
<div class="col-md-4">
    <label for="status" class="form-label">Állapot</label>
    <select name="status" id="status" class="form-control">
        <option value=""></option>
        <?php 
        foreach ($statusOptions as $option) {
            $selected = ($statusFilter == $option['status']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($option['status']) . '" ' . $selected . '>';
            echo htmlspecialchars($option['status']);
            echo '</option>';
        }
        ?>
    </select>
</div>

<div class="col-md-4">
    <label for="date" class="form-label">Határidő</label>
    <select name="date" id="date" class="form-control">
        <option value=""></option>
        <?php 
        foreach ($dateOptions as $option) {
            $selected = ($dateFilter == $option['date']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($option['date']) . '" ' . $selected . '>';
            echo htmlspecialchars($option['date']);
            echo '</option>';
        }
        ?>
    </select>
</div>

<div class="col-md-4">
    <label for="person" class="form-label">Dolgozó</label>
    <select name="person" id="person" class="form-control">
        <option value=""></option>
        <?php 
        foreach ($personOptions as $option) {
            $selected = ($personFilter == $option['person']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($option['person']) . '" ' . $selected . '>';
            echo htmlspecialchars($option['person']);
            echo '</option>';
        }
        ?>
    </select>
</div>

<div class="col-md-12">
    <button type="submit" class="btn btn-success">Szűrés</button>
    <button type="button" class="btn btn-danger" onclick="resetFilters()">Vissza</button>
</div>
</form>

<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>Feladat</th>
            <th>Feladat leírása</th>
            <th>Állapot</th>
            <th>Dolgozó</th>
            <th>Határidő</th>
            <?php 
            if ($_SESSION['role'] === 'admin') {
                echo '<th>Módosítás</th>';
                echo '<th>Törlés</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>' . htmlspecialchars($row['person']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                if ($_SESSION['role'] === 'admin') {
                    echo '<td><a href="update_task.php?id=' . $row['id'] . '" class="btn btn-success">Módosítás</a></td>';
                    echo '<td><a href="delete_task.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Biztosan törölni szeretné ezt a feladatot?\');">Törlés</a></td>';
                }
                echo '</tr>';
            }
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
        ?>
    </tbody>
</table>
