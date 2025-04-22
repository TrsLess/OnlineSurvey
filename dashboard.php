<?php
session_start();
// Simple admin access control
$adminPassword = "admin123";

if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['password']) && $_POST['password'] === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
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

// Handle Delete Request
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM survey_responses WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php"); // Refresh page after delete
    exit();
}

$sql = "SELECT * FROM survey_responses ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Survey Responses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    </style>
</head>

<body class="p-4">

    <div class="container">
        <h2 class="mb-4 text-center">📊 Survey Responses Dashboard</h2>

        <input type="text" id="searchInput" class="form-control search-box" placeholder="Search answers...">

        <div class="table-container table-responsive">
            <table class="table table-bordered table-hover align-middle text-center" id="surveyTable">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Q5</th>
                        <th>Q6</th>
                        <th>Q7</th>
                        <th>Q8</th>
                        <th>Q9</th>
                        <th>Q10</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['q1']) ?></td>
                                <td><?= htmlspecialchars($row['q2']) ?></td>
                                <td><?= htmlspecialchars($row['q3']) ?></td>
                                <td><?= htmlspecialchars($row['q4']) ?></td>
                                <td><?= htmlspecialchars($row['q5']) ?></td>
                                <td><?= htmlspecialchars($row['q6']) ?></td>
                                <td><?= htmlspecialchars($row['q7']) ?></td>
                                <td><?= htmlspecialchars($row['q8']) ?></td>
                                <td><?= htmlspecialchars($row['q9']) ?></td>
                                <td><?= htmlspecialchars($row['q10']) ?></td>
                                <td><?= htmlspecialchars($row['created_at'] ?? 'N/A') ?></td>
                                <td>
                                    <form method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this response?');">
                                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="13">No survey responses found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#surveyTable tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>

</html>

<?php
$conn->close();
?>