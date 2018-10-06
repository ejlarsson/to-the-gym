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

function horizontalBar(){
	var ctx = document.getElementById('canvas').getContext('2d');
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
}
