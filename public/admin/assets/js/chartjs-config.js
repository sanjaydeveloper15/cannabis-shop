var randomScalingFactor = function () {
	return Math.round(Math.random() * 100000);
};

// var config = {
// 	type: 'pie',
// 	data: {
// 		datasets: [{
// 			data: [
// 				randomScalingFactor(),
// 				randomScalingFactor(),  
// 			],
// 			backgroundColor: [ 
// 				window.chartColors.green,
// 				window.chartColors.blue,
// 			],
// 			label: 'Dataset 1'
// 		}] 
// 	},
// 	options: {
// 		responsive: true
// 	}
// };



//dhasboard line chart
var MONTHS = ['15 Jan, 2020', '20 Jan, 2020', '25 Jan, 2020', '30 Jan, 2020', '05 Feb, 2020', '10 Feb, 2020', '15 Feb, 2020'];
var config_bookingStats = {
	type: 'line',
	data: {
		labels: ['15 Jan, 2020', '20 Jan, 2020', '25 Jan, 2020', '30 Jan, 2020', '05 Feb, 2020', '10 Feb, 2020', '15 Feb, 2020'],
		datasets: [{
			label: 'Watch Time (in min)',
			backgroundColor: '#E86776',
			borderColor: '#E86776',
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],
			fill: false,
			backgroundColor: 'white',
			//borderColor: window.chartColors[colorName],
			borderWidth: 4,
			pointStyle: 'circle',
			pointRadius: 5,
			pointBorderColor: 'rgb(199,152,16)'
		}
		// , {
		// 	label: 'My Second dataset',
		// 	fill: false,
		// 	backgroundColor: window.chartColors.blue,
		// 	borderColor: window.chartColors.blue,
		// 	data: [
		// 		randomScalingFactor(),
		// 		randomScalingFactor(),
		// 		randomScalingFactor(),
		// 		randomScalingFactor(),
		// 		randomScalingFactor(),
		// 		randomScalingFactor(),
		// 		randomScalingFactor()
		// 	],
		// }
	]
	},
	options: {
		responsive: true,
		legend: {
			labels: {
				usePointStyle: false
			}
		},
		// title: {
		// 	display: true,
		// 	text: 'Chart.js Line Chart'
		// },
		tooltips: {
			mode: 'index',
			intersect: false,
		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				// scaleLabel: {
				// 	display: true,
				// 	labelString: 'Month'
				// }
			}],
			yAxes: [{
				display: true,
				
				// scaleLabel: {
				// 	display: true,
				// 	labelString: 'Value'
				// }
			}]
		}
	}
};

window.onload = function () {
	var ctx = document.getElementById('booking-stats').getContext('2d');
	window.myLine = new Chart(ctx, config_bookingStats);

 
		// var pie_chart = document.getElementById('chart-area').getContext('2d');
		// window.myPie = new Chart(pie_chart, config);

};


