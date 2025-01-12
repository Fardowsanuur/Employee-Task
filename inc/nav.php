<nav class="side-bar">
			<div class="user-p">
				<img src="img/user.png">
				<h4>@<?=$_SESSION['username']?></h4>
			</div>
			
			<?php 

               if($_SESSION['role'] == "employee"){
			 ?>
			 <!-- Employee Navigation Bar -->
			<ul id="navList">
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'my_task.php' ? 'class="active"' : ''; ?>>
					<a href="my_task.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>My Task</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'class="active"' : ''; ?>>
					<a href="profile.php">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span>Profile</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'notifications.php' ? 'class="active"' : ''; ?>>
					<a href="notifications.php">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<span>Notifications</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'class="active"' : ''; ?>>
					<a href="logout.php">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		<?php }else { ?>
			<!-- Admin Navigation Bar -->
            <ul id="navList">
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'user.php' ? 'class="active"' : ''; ?>>
					<a href="user.php">
						<i class="fa fa-users" aria-hidden="true"></i>
						<span>Manage Users</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'create_task.php' ? 'class="active"' : ''; ?>>
					<a href="create_task.php">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<span>Create Task</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'category.php' ? 'class="active"' : ''; ?>>
					<a href="category.php">
						<i class="fa fa-list" aria-hidden="true"></i>
						<span>Categories</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'tasks.php' ? 'class="active"' : ''; ?>>
					<a href="tasks.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>All Tasks</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'report.php' ? 'class="active"' : ''; ?>>
					<a href="report.php">
						<i class="fa fa-bar-chart" aria-hidden="true"></i>
						<span>Report</span>
					</a>
				</li>
				<li <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'class="active"' : ''; ?>>
					<a href="logout.php">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		<?php } ?>
		</nav>