<?php
include_once 'session.php';

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	
	include_once 'sql.php';
	
	$user_uuid = $_SESSION['user_uuid'];
	
	$res = queryBids(getConnection(), $user_uuid, NULL);

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
						<a href="/index.php#show_bids" class="button default">Show bids</a>
					</li>
					<li>
						<a href="/index.php#create_bid" class="button default">Create bid</a>
					</li>
				</ul>
			</div>
		</header>

		<!-- Four -->
		<section id="show_bids" class="wrapper">
			<div class="inner">

				<section>
					<h4>Bids</h4>

					<h5>Alternate</h5>
					<div class="table-wrapper">
						<table class="alt">
							<thead>
								<tr>
									<th>Period</th>
									<th>Bid</th>
									<th>Total</th>
									<th>Duration</th>
								</tr>
							</thead>
							<tbody>
								<? while ($row = pg_fetch_assoc($res)) { ?>
								<tr>
									<td>
										<? echo $row['period']; ?>
									</td>
									<td>
										<? if (!isset($row['bid'])) { echo '<a href="/create-bid.php?period='.$row['period'].'">Add</a>'; } else { echo $row['bid']; } ?>
									</td>
									<td>
										<? 	if ($row['total'] === 0) { echo '<a href="/index.php#create_exercise">0</a>'; } 
											else { echo '<a href="/exercises.php">'.$row['total'].'</a>'; } ?>
									</td>
									<td>
										<? echo $row['duration']; ?>
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