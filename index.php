<!DOCTYPE HTML>
<!--
	Fractal by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->

<?php
include_once('session.php');
?>

<html>
	<head>
		<title>Let's go to the gym</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<div class="content">
					<h1><a href="#">Let's go to the gym</a></h1>
					<? if(isset($user_uuid)) { ?>
					<p>Welcome <? echo $user_name; ?>!</p>
					<ul class="actions">
						<li><a href="#four" class="button primary">Log exercise</a></li>
						<li><a href="/exercises.php" class="button default">See exercises</a></li>
						<li><a href="/bids.php" class="button default">See bids</a></li>
					</ul>
					<? } else { ?>
					<ul class="actions">
						<li><a href="/login.php" class="button primary">Login</a></li>
						<li><a href="/create-user.php" class="button default">Create user</a></li>
					</ul>
					<? } ?>
				</div>
			</header>

		<!-- Four -->

			<section id="four" class="wrapper">
				<div class="inner">

					<header class="major">
						<h2>Log exercise</h2>
					</header>

					<section>
						<h4>Form</h4>
						<form method="post" action="/create-exercise.php">
							<div class="row gtr-uniform">
								<div class="col-6 col-12-xsmall">
									<input type="number" name="duration" id="exercise_duration" value="" placeholder="Duration in minutes" />
								</div>
								<div class="col-6 col-12-xsmall">
									Date:<input type="date" name="date" id="exercise_date" value="" placeholder="YYYY-MM-DD" />
									<script>document.getElementById('exercise_date').valueAsDate = new Date();</script>
								</div>
								<div class="col-12">
									<select name="exercise_type" id="exercise_type">
										<option value="">- Exercise type -</option>
										<option value="1">This</option>
										<option value="2">Does</option>
										<option value="3">Not</option>
										<option value="4">Work</option>
									</select>
								</div>
								<div class="col-12">
									<ul class="actions">
										<li><input type="submit" value="Register exercise" class="primary" /></li>
										<li><input type="reset" value="Reset" /></li>
									</ul>
								</div>
							</div>
						</form>
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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>