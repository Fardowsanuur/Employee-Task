<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/Category.php";

    // Initialize filters
    $roleFilter = isset($_GET['role']) ? $_GET['role'] : 'all';
    $userFilter = isset($_GET['user']) ? $_GET['user'] : 'all';
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';

    // Fetch users for dropdown
    $stmt = $conn->prepare("SELECT id, full_name, role FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch categories for dropdown
    $categories = get_all_categories($conn);

    // Build tasks query with filters
    $query = "SELECT t.id, t.title, t.description, t.status, u.full_name AS assigned_to, c.name AS category_name 
              FROM tasks t 
              LEFT JOIN users u ON t.assigned_to = u.id 
              LEFT JOIN categories c ON t.category_id = c.id 
              WHERE 1=1";
    $params = array();

    if ($userFilter !== 'all') {
        $query .= " AND t.assigned_to = :user_id";
        $params[':user_id'] = $userFilter;
    }
    if ($roleFilter !== 'all') {
        $query .= " AND t.assigned_to IN (SELECT id FROM users WHERE role = :role)";
        $params[':role'] = $roleFilter;
    }
    if ($statusFilter !== 'all') {
        $query .= " AND t.status = :status";
        $params[':status'] = $statusFilter;
    }
    if ($categoryFilter !== 'all') {
        $query .= " AND t.category_id = :category_id";
        $params[':category_id'] = $categoryFilter;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle CSV Download
    if (isset($_GET['download']) && $_GET['download'] == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="task_report_'.date('Y-m-d').'.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($output, array('#', 'Title', 'Description', 'Status', 'Assigned To', 'Category'));
        
        // Add data
        $i = 0;
        foreach ($tasks as $task) {
            fputcsv($output, array(
                ++$i,
                $task['title'],
                $task['description'],
                $task['status'],
                $task['assigned_to'] ?? 'Unassigned',
                $task['category_name'] ?? 'Uncategorized'
            ));
        }
        
        fclose($output);
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Task Reports</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.filter-form {
			background: #f8f9fa;
			padding: 20px;
			border-radius: 8px;
			margin-bottom: 20px;
		}
		.filter-form select {
			margin-bottom: 15px;
		}
		.table-responsive {
			margin-top: 20px;
		}
		.download-btn {
			margin-bottom: 20px;
		}
	</style>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1 container-fluid">
			<div class="row">
				<div class="col-12">
					<h4 class="title mb-4">Task Reports</h4>
					
					<!-- Download Button -->
					<?php if (!empty($tasks)) { ?>
						<div class="download-btn">
							<a href="?download=csv<?php 
								echo ($roleFilter !== 'all' ? '&role='.$roleFilter : '');
								echo ($userFilter !== 'all' ? '&user='.$userFilter : '');
								echo ($statusFilter !== 'all' ? '&status='.$statusFilter : '');
								echo ($categoryFilter !== 'all' ? '&category='.$categoryFilter : '');
							?>" class="btn btn-success">
								<i class="fa fa-download"></i> Download Report
							</a>
						</div>
					<?php } ?>

					<!-- Filter Form -->
					<form method="get" class="filter-form">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="role" class="form-label">Filter by Role:</label>
									<select name="role" id="role" class="form-select">
										<option value="all" <?php echo ($roleFilter === 'all') ? 'selected' : ''; ?>>All Roles</option>
										<option value="admin" <?php echo ($roleFilter === 'admin') ? 'selected' : ''; ?>>Admin</option>
										<option value="employee" <?php echo ($roleFilter === 'employee') ? 'selected' : ''; ?>>Employee</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="user" class="form-label">Filter by User:</label>
									<select name="user" id="user" class="form-select">
										<option value="all" <?php echo ($userFilter === 'all') ? 'selected' : ''; ?>>All Users</option>
										<?php foreach ($users as $user) { ?>
											<option value="<?php echo $user['id']; ?>" 
													<?php echo ($userFilter == $user['id']) ? 'selected' : ''; ?>>
												<?php echo $user['full_name'] . " (" . ucfirst($user['role']) . ")"; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="category" class="form-label">Filter by Category:</label>
									<select name="category" id="category" class="form-select">
										<option value="all" <?php echo ($categoryFilter === 'all') ? 'selected' : ''; ?>>All Categories</option>
										<?php if ($categories != 0) { foreach ($categories as $category) { ?>
											<option value="<?php echo $category['id']; ?>" 
													<?php echo ($categoryFilter == $category['id']) ? 'selected' : ''; ?>>
												<?php echo htmlspecialchars($category['name']); ?>
											</option>
										<?php } } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="status" class="form-label">Filter by Status:</label>
									<select name="status" id="status" class="form-select">
										<option value="all" <?php echo ($statusFilter === 'all') ? 'selected' : ''; ?>>All Status</option>
										<option value="pending" <?php echo ($statusFilter === 'pending') ? 'selected' : ''; ?>>Pending</option>
										<option value="in_progress" <?php echo ($statusFilter === 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
										<option value="completed" <?php echo ($statusFilter === 'completed') ? 'selected' : ''; ?>>Completed</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-12">
								<button type="submit" class="btn btn-primary">Apply Filter</button>
							</div>
						</div>
					</form>

					<!-- Tasks Table -->
					<?php if (!empty($tasks)) { ?>
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead class="table-dark">
									<tr>
										<th>#</th>
										<th>Title</th>
										<th>Description</th>
										<th>Status</th>
										<th>Assigned To</th>
										<th>Category</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=0; foreach ($tasks as $task) { ?>
									<tr>
										<td><?=++$i?></td>
										<td><?=$task['title']?></td>
										<td><?=$task['description']?></td>
										<td>
											<span class="badge bg-<?php 
												echo $task['status'] === 'completed' ? 'success' : 
													($task['status'] === 'in_progress' ? 'warning' : 'secondary');
											?>">
												<?=$task['status']?>
											</span>
										</td>
										<td><?=$task['assigned_to'] ?? 'Unassigned'?></td>
										<td><?=$task['category_name'] ?? 'Uncategorized'?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } else { ?>
						<div class="alert alert-info mt-4">No Tasks Available</div>
					<?php } ?>
				</div>
			</div>
		</section>
	</div>

	<!-- Bootstrap JS and dependencies -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		var active = document.querySelector("#navList li:nth-child(3)");
		active.classList.add("active");
	</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
?>