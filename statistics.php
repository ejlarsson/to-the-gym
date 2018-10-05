<?php
include_once 'session.php';

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	include_once 'sql.php';
	
	//$res = queryExercises(getConnection(), NULL, $status, NULL);
	
	/*if (!$res) {
		echo "An error occurred.\n";
		exit;
	}*/
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
		<!-- Scripts -->
		<script src="assets/js/jquery.min.js" />
		<script src="assets/js/jquery.scrolly.min.js"/>
		<script src="assets/js/browser.min.js"/>
		<script src="assets/js/breakpoints.min.js"/>
		<script src="assets/js/util.js"/>
		<script src="assets/js/main.js"/>

		<script src="assets/js/Chart.bundle.js"/>
		<script src="assets/js/Chart.bundle.min.js"/>
		
		<script>

		var data = {
			labels: ['Arne', 'Bert', 'Carl', 'David'],
			datasets: [{
				label: 'Bid',
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				borderColor: 'rgba(255,99,132,1)',
				borderWidth: 1,
				data: [5, 10, 12, 5]
			}, {
				label: 'Exercised',
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1,
				data: [2, 3, 4, 6]
			}]

		};

		var ctx = document.getElementById('canvas').getContext('2d');

		window.onload = function() {
			window.myHorizontalBar = new Chart(ctx, {
				type: 'horizontalBar',
				data: data,
				options: {
					// Elements options apply to all of the options unless overridden in a dataset
					// In this case, we are setting the border of each horizontal bar to be 2px wide
					elements: {
						rectangle: {
							borderWidth: 2,
						}
					},
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Exercised vs. bid'
					},
					scales: {
						xAxes: [{
							ticks: {
								min: 0,
								stepSize: 1
							}
						}]
					}
				}
			});
		};

		</script>
	</head>
	<body>

		<!-- Header -->
		<header id="header">
			<div class="content">
				<h1>
					<a href="#">Let's go to the gym</a>
				</h1>
				<ul class="actions">
					<li>
						<a href="/" class="button primary">Home</a>
					</li>
				</ul>
			</div>
		</header>

		<section id="show_statistics" class="wrapper">
			<div class="inner">

				<header class="major">
					<h2>Elements</h2>
				</header>

				<section>
					<h4>Image</h4>
					<h5>Fit</h5>
					<div class="box alt">
						<div class="row gtr-uniform">
							<div class="col-12">
								<span class="image fit">
									<canvas id="canvas" width="2160" height="1080" class="chartjs-render-monitor" style="display: block; width: 1080px; height: 540px;"/>
								</span>
							</div>
						</div>
					</div>
				</section>

			</div>
		</section>

		<!-- Footer -->
		<footer id="footer">
		</footer>		

	</body>
</html>