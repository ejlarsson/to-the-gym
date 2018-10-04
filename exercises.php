<?php
include_once 'session.php';

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	include_once 'sql.php';
	
	/* Expected link parameters: period, exercise, user */
	
	if(isset($_POST['all_users'])) $user_uuid = NULL;
	if(isset($_POST['all_periods'])) $periods = NULL; else $periods = 'CURRENT';
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
	<body class="is-preload">

		<!-- Header -->
		<header id="header">
			<div class="content">
				<ul class="actions">
					<li>
						<a href="/index.php#create_exercise" class="button primary">Log exercise</a>
					</li>
					<li>
						<a href="/index.php" class="button default">Home</a>
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
							<div class="col-6 col-12-small">
								<input type="checkbox" id="all_users" name="all_users" />
								<label for="all_users">Show my exercises</label>
							</div>
							<div class="col-6 col-12-small">
								<input type="checkbox" id="all_periods" name="all_periods" />
								<label for="all_periods">Show all periods</label>
							</div>

							<div class="col-12">
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
								<tr>
									<td>
										<? echo $row['user_uuid']; ?>
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
							<tfoot>
								<tr>
									<td colspan="3"/>
									<td>Sum</td>
									<td/>
								</tr>
							</tfoot>
						</table>
					</div>
				</section>
			</div>
		</section>

		<!-- Footer -->
		<footer id="footer">
			<ul class="icons">
				<!--
					<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
-->
			</ul>
			<!--
				<p class="copyright">&copy; Untitled. Credits: <a href="http://html5up.net">HTML5 UP</a></p>
-->
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