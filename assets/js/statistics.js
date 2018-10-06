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

function test() {
	alert('asdf');
}