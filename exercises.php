<?php
include_once 'session.php';

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	include_once 'sql.php';
	
	/* Expected link parameters: period, exercise, user */
	
	if(isset($_POST['all_users'])) $user_uuid = NULL;
	if(isset($_POST['all_periods'])) $period = NULL; else $period = 'CURRENT';
//	if(isset($_GET['exercise'])) $exercise_uuid = $_GET['exercise']; else $exercise_uuid = NULL;
	$exercise_uuid = NULL;
	
	$res = queryExercises(getConnection(), $user_uuid, $period, $exercise_uuid);
	
	if (!$res) {
		echo "An error occurred.\n";
		exit;
	}
}
?>
<html>
	<head>
		<title>Let's go to the gym</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript>
			<link rel="stylesheet" href="assets/css/noscript.css" />
		</noscript>
	</head>
	<body>

		<!-- Header -->
		<header id="header">
			<div class="content">
				<h1><a href="#">Let's go to the gym</a></h1>
				<ul class="actions">
					<li>
						<a href="/index.php" class="button primary">Home</a>
					</li>
					<li>
						<a href="/index.php#create_exercise" class="button default">Log exercise</a>
					</li>
				</ul>
			</div>
		</header>

		<!-- Four -->
		<section id="show_exercises" class="wrapper">
			<div class="inner">

				<header class="major">
					<h2>Filter exercises</h2>
				</header>

				<section>
					<form method="post">
						<div class="row gtr-uniform">
							<div class="col-4 col-12-small">
								<input type="checkbox" id="all_users" name="all_users" <? if (!isset($user_uuid)) echo 'checked'; ?>>
								<label for="all_users">Show all exercises</label>
							</div>
							<div class="col-4 col-12-small">
								<input type="checkbox" id="all_periods" name="all_periods" <? if (!isset($period)) echo 'checked'; ?>>
								<label for="all_periods">Show all periods</label>
							</div>

							<div class="col-4 col-12-small">
								<ul class="actions">
									<li>
										<input type="submit" value="Filter" class="primary" />
									</li>
								</ul>
							</div>
						</div>
					</form>
				</section>

				<section>
					<h4>Exercises</h4>

					<h5>Alternate</h5>
					<div class="table-wrapper">
						<table class="alt">
							<thead>
								<tr>
									<th>User</th>
									<th>Period</th>
									<th>Type</th>
									<th>Duration</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<? while ($row = pg_fetch_assoc($res)) { ?>
								
								<? 	if($row['user_uuid'] === $user_uuid) echo '<tr class="is_current_user">'; 
									else echo '<tr>';
								?>
									<td>
										<? echo $row['user_name']; ?>
									</td>
									<td>
										<? echo $row['period']; ?>
									</td>
									<td>
										<? echo $row['exercise_type']; ?>
									</td>
									<td>
										<? echo $row['exercise_duration']; ?>
									</td>
									<td>
										<? echo $row['exercise_date']; ?>
									</td>
								</tr>
								<? } ?>

							</tbody>
							
						</table>
					</div>
				</section>
			</div>
		</section>

		<!-- Footer -->
		<footer id="footer">
		</footer>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"/>
		<script src="assets/js/jquery.scrolly.min.js"/>
		<script src="assets/js/browser.min.js"/>
		<script src="assets/js/breakpoints.min.js"/>
		<script src="assets/js/util.js"/>
		<script src="assets/js/main.js"/>

	</body>
</html>