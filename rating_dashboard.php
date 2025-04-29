<?php
session_start();
$adminPassword = "admin123";

if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['password']) && $_POST['password'] === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: ratings_dashboard.php");
        exit();
    }
    echo '<!DOCTYPE html>
    <html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body class="d-flex justify-content-center align-items-center vh-100 bg-light">
      <form method="POST" class="p-4 bg-white rounded shadow-sm">
        <h4 class="mb-3">Admin Login</h4>
        <input type="password" class="form-control mb-2" name="password" placeholder="Enter admin password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </body></html>';
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "remote_work_survey";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM survey_ratings WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ratings_dashboard.php?sort=" . ($_GET['sort'] ?? 'desc'));
    exit();
}

// Handle sorting
$sort = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'asc' : 'desc';
$nextSort = $sort === 'asc' ? 'desc' : 'asc';
$sql = "SELECT * FROM survey_ratings ORDER BY id $sort";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ratings Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            max-width: 400px;
            margin-bottom: 20px;
        }

        .star-display {
            color: #ffc107;
            font-size: 1.25rem;
        }
    </style>
</head>

<body class="p-4">

    <div class="container">
        <h2 class="mb-4 text-center">⭐ Survey Ratings Dashboard</h2>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <input type="text" id="searchInput" class="form-control search-box me-2" placeholder="Search ratings...">
            <a href="?sort=<?= $nextSort ?>" class="btn btn-outline-primary">
                Sort by ID <?= $sort === 'asc' ? '🔼' : '🔽' ?>
            </a>
        </div>

        <div class="table-container table-responsive">
            <table class="table table-bordered table-hover align-middle text-center" id="ratingsTable">
                <thead class="table-warning">
                    <tr>
                        <th>ID</th>
                        <th>Rating</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td>
                                    <span class="star-display">
                                        <?= str_repeat('<i class="fas fa-star"></i>', $row['rating']) ?>
                                        <?= str_repeat('<i class="far fa-star"></i>', 5 - $row['rating']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Delete this rating?');">
                                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No ratings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#ratingsTable tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>

</html>

<?php $conn->close(); ?>