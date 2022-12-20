<html>
<head>
	<title>Statistiques</title>
</head>
<body>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
				<li class="active" id="ong-home"><a data-toggle="tab" href="#home">Accueil</a></li>
				<li id="ong-sinistre">Statistiques mensuelles</li>
			</ul>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<div class="row" >
						<div class="col-md-12 panel hide"  style="height:550px " id="stats_mensuelles_suivi_recettes_assites">
						
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 panel hide"  style="height:550px " id="stats_mensuelles_suivi_recettes_assites_cumulatives">
						
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

<script type="text/javascript">
//////////////

document.addEventListener('DOMContentLoaded', function () {
	
var seriesOptions = [],
    seriesCounter = 0,
    names = ['DECLARATIONS','PAIEMENTS'];

/**
 * Create the chart when all data is loaded
 * @return {undefined}
 */
function createChart() {

    Highcharts.stockChart('stats_mensuelles_suivi_recettes_assites', {
		title: {
			text: 'Suivi des recettes (paiements) et des assiettes (déclarations), au jour le jour et en temps réel',
			style: {
				fontSize:12,
				fontFamily: 'arial'
			}
		},
		
        rangeSelector: {
            selected: 4
        },

        yAxis: {
            labels: {
                formatter: function () {
                    return (this.value > 0 ? ' + ' : '') + this.value + '%';
                }
            },
            plotLines: [{
                value: 0,
                width: 2,
                color: 'silver'
            }]
        },

        plotOptions: {
            series: {
                compare: 'percent',
                showInNavigator: true
            }
        },

        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
            valueDecimals: 2,
            split: true
        },

        series: seriesOptions
    });
}

function success(data) {
    var name = this.url.match(/(declarations|paiements)/)[0].toUpperCase();
    var i = names.indexOf(name);
    seriesOptions[i] = {
        name: name,
        data: data
    };

    // As we're loading the data asynchronously, we don't know what order it
    // will arrive. So we keep a counter and create the chart when all the data is loaded.
    seriesCounter += 1;

    if (seriesCounter === names.length) {
        createChart();
    }
}

Highcharts.getJSON(
    'http://127.0.0.1/digigraph/public/declarations',
    success
);

Highcharts.getJSON(
    'http://127.0.0.1/digigraph/public/paiements',
    success
);  


/////////////////CUMULATIVES
var seriesOptionsCumul = [],
    seriesCounterCumul = 0,
    namesCumul = ['DECLARATIONS','PAIEMENTS'];

/**
 * Create the chart when all data is loaded
 * @return {undefined}
 */
function createChartCumul() {

    // Create the chart
	Highcharts.stockChart('stats_mensuelles_suivi_recettes_assites_cumulatives', {

		title: {
			text: 'Suivi des recettes (paiements) et des assiettes (déclarations), au jour le jour et en temps réel et de façon cumulative'
		},

		subtitle: {
			text: 'Affiche la somme de toutes les valeurs précédentes et la valeur actuelle (uniquement dans la plage visible)'
		},

		plotOptions: {
			series: {
				cumulative: true,
				// pointStart: Date.UTC(2021, 0, 1),
				pointIntervalUnit: 'day'
			}
		},

		rangeSelector: {
			enabled: false
		},

		tooltip: {
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.cumulativeSum})<br/>',
			changeDecimals: 2,
			valueDecimals: 2
		},

		xAxis: {
			minRange: 3 * 24 * 36e5,
			// max: Date.UTC(2021, 0, 6)
		},

		series: [{
			data: seriesOptionsCumul[0].data
		}, {
			data: seriesOptionsCumul[1].data
		}]
	});
				
}

function successCumul(data) {
    var name = this.url.match(/(declarations|paiements)/)[0].toUpperCase();
    var i = namesCumul.indexOf(name);
    seriesOptionsCumul[i] = {
        name: name,
        data: data
    };

    // As we're loading the data asynchronously, we don't know what order it
    // will arrive. So we keep a counter and create the chart when all the data is loaded.
    seriesCounterCumul += 1;

    if (seriesCounterCumul === namesCumul.length) {
        createChartCumul();
    }
}

Highcharts.getJSON(
    'http://127.0.0.1/digigraph/public/declarations',
    successCumul
);

Highcharts.getJSON(
    'http://127.0.0.1/digigraph/public/paiements',
    successCumul
);  


/*
//Create the chart
function createChartJournalieres(data) {
	
	Highcharts.chart('stats_mensuelles', {
                title: {
                    text: 'Comparaison déclaration/règlements',
                    style: {
                        fontSize:12,
                        fontFamily: 'arial'
                    }
                },
				
				rangeSelector: {
					selected: 4
				},
				
                xAxis: {
                    categories: data.dates
                },

                yAxis: {
                    title: {
                        text: 'Montant'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                // plotOptions: {
                    // series: {
                        // label: {
                            // connectorAllowed: false
                        // },
                        // style: {
                            // fontSize:10,
                            // fontFamily: 'arial'
                        // }
                    // }
                // },

                series: [
					{
						name:'Déclarations',
						data: data.declarations
					},
					{
						name:'Règlements',
						data: data.paiements
					},
				]
            });
    
}

let date_debut = '';
Highcharts.getJSON(
    'http://127.0.0.1/digigraph/public/stats_mensuelles_data?d='+date_debut,
    createChartJournalieres
);
*/


});
</script>
</body>
</html>