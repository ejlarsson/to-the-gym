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
						<a href="#show_bids" class="button default">Show bids</a>
					</li>
					<li>
						<a href="#create_bid" class="button default">Create bid</a>
					</li>
				</ul>
			</div>
		</header>

		<!-- Four -->
		<section id="show_bids" class="wrapper">
			<div class="inner">

				<header class="major">
					<h2>Your bids</h2>
				</header>
				
				<section>
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
								<? 	
									$current_period_exist = FALSE;
									$current_bid_exist = FALSE;
									
									while ($row = pg_fetch_assoc($res)) { 
								
										if(isset($row['bid']) AND $row['period_status'] === 'CURRENT') $current_bid_exist = TRUE;
										if($row['period_status'] === 'CURRENT') $current_period_exist = TRUE;
								?>
								
								<tr <? if($row['period_status'] === 'CURRENT') echo 'style="font-weight:bold"'; ?>>
									<td>
										<? echo $row['period_name']; ?>
									</td>
									<td>
										<? if (!isset($row['bid']) AND $row['period_status'] === 'CURRENT') { 
											echo '<a href="#create_bid">Add</a>'; 
										} 
										else { echo $row['bid']; } ?>
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
				
		<section id="create_bid" class="wrapper">
			<div class="inner">

				<header class="major">
					<h2>Create a bid</h2>
				</header>

				<section>
					
				<? if (!$current_period_exist || $current_bid_exist) { ?>		
					<h4>Can't create bid as you already have a bid or there is no current period.</h4>
				<? } ?>
			
					<form method="post" action="/create-bid.php">
						<div class="row gtr-uniform">
							<div class="col-12 col-12-xsmall">
								<input type="number" name="bid" id="bid" value="" placeholder="Bid for current period" min="1" max="99" <? if ($current_bid_exist || !current_period_exist) echo "disabled"; ?> />
							</div>
							<div class="col-12">
								<ul class="actions">
									<li>
										<input type="submit" value="Register bid" class="primary" <? if ($current_bid_exist || !current_period_exist) echo "disabled"; ?> />
									</li>
								</ul>
							</div>
						</div>
					</form>
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