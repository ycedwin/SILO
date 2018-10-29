function removeSpace(entry) {
    return entry != "";
}

//split the information got from api
function siloParse(data, dmy) {
    var siloJson = data;
    var count = 1;

    var siloDate = [];
    var siloMinTemps = [];
    var siloMaxTemps = [];
    var siloMinHumid = [];
    var siloMaxHumid = [];
    var siloRain = [];
    var siloEvap = [];
    var siloVp = [];
    var siloRadn = [];

    var siloDateG = [];
    var siloMinTempsG = [];
    var siloMaxTempsG = [];
    var siloMinHumidG = [];
    var siloMaxHumidG = [];
    var siloRainG = [];
    var siloEvapG = [];
    var siloVpG = [];
    var siloRadnG = [];
    //daily
    for (var i = 0; i < siloJson["data"].length; i++) {
        siloDate.push(siloJson.data[i].date);
        siloMaxTemps.push(siloJson.data[i].variables[2].value);
        siloMinTemps.push(siloJson.data[i].variables[3].value);
        siloMaxHumid.push(siloJson.data[i].variables[5].value);
        siloMinHumid.push(siloJson.data[i].variables[6].value);
        siloRain.push(siloJson.data[i].variables[0].value);
        siloEvap.push(siloJson.data[i].variables[1].value);
        siloVp.push(siloJson.data[i].variables[7].value);
        siloRadn.push(siloJson.data[i].variables[4].value);
    }

    if(dmy == "monthly"){
      for (var i = 0; i < siloJson["data"].length; i++) {
          siloDateG.push(siloJson.data[i].date.slice(0,7));
      }
    }else if(dmy == "yearly"){
      for (var i = 0; i < siloJson["data"].length; i++) {
          siloDateG.push(siloJson.data[i].date.slice(0,4));
      }
    }

    //average
    var siloMaxTempsAvg = siloMaxTemps[0];
    var siloMinTempsAvg = siloMinTemps[0];
    var siloMaxHumidAvg = siloMaxHumid[0];
    var siloMinHumidAvg = siloMinHumid[0];
    var siloRainAvg = siloRain[0];
    var siloEvapAvg = siloEvap[0];
    var siloVpAvg = siloVp[0];
    var siloRadnAvg = siloRadn[0];

    if(dmy !== "daily"){
      var res = [siloDateG[0]];
      for (var i = 1; i < siloJson["data"].length; i++) {
        if(siloDateG[i] !== res[res.length-1]){
          res.push(siloDateG[i]);
          //calculate average
          siloMaxTempsAvg = siloMaxTempsAvg/count;
          siloMinTempsAvg = siloMinTempsAvg/count;
          siloMaxHumidAvg = siloMaxHumidAvg/count;
          siloMinHumidAvg = siloMinHumidAvg/count;
          siloRainAvg = siloRainAvg/count;
          siloEvapAvg = siloEvapAvg/count;
          siloVpAvg = siloVpAvg/count;
          siloRadnAvg = siloRadnAvg/count;
          count = 0;
          siloMaxTempsG.push(siloMaxTempsAvg);
          siloMinTempsG.push(siloMinTempsAvg);
          siloMaxHumidG.push(siloMaxHumidAvg);
          siloMinHumidG.push(siloMinHumidAvg);
          siloRainG.push(siloRainAvg);
          siloEvapG.push(siloEvapAvg);
          siloVpG.push(siloVpAvg);
          siloRadnG.push(siloRadnAvg);
          siloMaxTempsAvg = 0;
          siloMinTempsAvg = 0;
          siloMaxHumidAvg = 0;
          siloMinHumidAvg = 0;
          siloRainAvg = 0;
          siloEvapAvg = 0;
          siloVpAvg = 0;
          siloRadnAvg = 0;
        }else{
          count++;
          siloMaxTempsAvg += siloMaxTemps[i];
          siloMinTempsAvg += siloMinTemps[i];
          siloMaxHumidAvg += siloMaxHumid[i];
          siloMinHumidAvg += siloMinHumid[i];
          siloRainAvg += siloRain[i];
          siloEvapAvg += siloEvap[i];
          siloVpAvg += siloVp[i];
          siloRadnAvg += siloRadn[i];
        }
      }
    }

    //last year or month
    siloMaxTempsAvg = siloMaxTempsAvg/count;
    siloMinTempsAvg = siloMinTempsAvg/count;
    siloMaxHumidAvg = siloMaxHumidAvg/count;
    siloMinHumidAvg = siloMinHumidAvg/count;
    siloRainAvg = siloRainAvg/count;
    siloEvapAvg = siloEvapAvg/count;
    siloVpAvg = siloVpAvg/count;
    siloRadnAvg = siloRadnAvg/count;
    siloMaxTempsG.push(siloMaxTempsAvg);
    siloMinTempsG.push(siloMinTempsAvg);
    siloMaxHumidG.push(siloMaxHumidAvg);
    siloMinHumidG.push(siloMinHumidAvg);
    siloRainG.push(siloRainAvg);
    siloEvapG.push(siloEvapAvg);
    siloVpG.push(siloVpAvg);
    siloRadnG.push(siloRadnAvg);

    //dalily
    if(dmy == "daily"){
      var dataArray = [siloDate, siloMinTemps, siloMaxTemps, siloMinHumid, siloMaxHumid, siloRain, siloEvap, siloVp, siloRadn];
    }else{
      //monthly,yearly
      var dataArray = [res, siloMinTempsG, siloMaxTempsG, siloMinHumidG, siloMaxHumidG, siloRainG, siloEvapG, siloVpG, siloRadnG];
      console.log(res);
      console.log(siloMaxTempsG)
    }
    return dataArray;


// can choose by setted time range
}


function drawChart(data, item_json, dmy) {
    var siloArray = siloParse(data, dmy);

//use boolean value in array to represent whether a variable is selected
    var enableArray = new Array(0, 0, 0, 0, 0, 0, 0, 0);
    for(var x in item_json){
        if(item_json[x] == "T.Min"){
        enableArray[0] = 1;
        }
        if(item_json[x] == "T.Max"){
        enableArray[1] = 1;
        }
        if(item_json[x] == "RHminT"){
        enableArray[2] = 1;
        }
        if(item_json[x] == "RHmaxT"){
        enableArray[3] = 1;
        }
        if(item_json[x] == "Rain"){
        enableArray[4] = 1;
        }
        if(item_json[x] == "Evap"){
        enableArray[5] = 1;
        }
        if(item_json[x] == "VP"){
        enableArray[6] = 1;
        }
        if(item_json[x] == "Radn"){
        enableArray[7] = 1;
        }
    }

    for(var j=0;j<8;j++){
        if(enableArray[j] == 0){
            siloArray[j+1].splice(0,siloArray[j+1].length);
        }
    }
    if(!Array.isArray(siloArray)) {
        if(siloArray.search("Error") >= 0) {
            document.getElementById("error_pane").textContent = siloArray;
        }
    } else {
        // creating the curve
        var ctx = document.getElementById("dataChart");
        var dataChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: siloArray[0],
                datasets: [{
                    label: 'T.Min',
                    data: siloArray[1],
                    backgroundColor: 'rgba(228, 26, 28, 0)',
                    borderColor: 'rgba(228, 26, 28, 1)',
                    pointBackgroundColor: 'rgba(228, 26, 28, 0.5)',
                    pointBorderColor: 'rgba(228, 26, 28, 1)',
                    pointHoverBackgroundColor: 'rgba(228, 26, 28, 1)',
                    pointHoverBorderColor: 'rgba(228, 26, 28, 1)',
                    borderWidth: 1
                },
                {
                    label: 'T.Max',
                    data: siloArray[2],
                    backgroundColor: 'rgba(55, 126, 184, 0)',
                    borderColor: 'rgba(55, 126, 184, 1)',
                    pointBackgroundColor: 'rgba(55, 126, 184, 0.5)',
                    pointBorderColor: 'rgba(55, 126, 184, 1)',
                    pointHoverBackgroundColor: 'rgba(55, 126, 184, 1)',
                    pointHoverBorderColor: 'rgba(55, 126, 184, 1)',
                    borderWidth: 1
                },
                {
                label: 'RHmaxT',
                data: siloArray[4],
                backgroundColor: 'rgba(77, 175, 74, 0)',
                borderColor: 'rgba(77, 175, 74, 1)',
                pointBackgroundColor: 'rgba(77, 175, 74, 0.5)',
                pointBorderColor: 'rgba(77, 175, 74, 1)',
                pointHoverBackgroundColor: 'rgba(77, 175, 74, 1)',
                pointHoverBorderColor: 'rgba(77, 175, 74, 1)',
                borderWidth: 1
                        },
                {
                label: 'RHminT',
                data: siloArray[3],
                backgroundColor: 'rgba(152, 78, 163, 0)',
                borderColor: 'rgba(152, 78, 163, 0.5)',
                pointBackgroundColor: 'rgba(152, 78, 163, 0.5)',
                pointBorderColor: 'rgba(152, 78, 163, 1)',
                pointHoverBackgroundColor: 'rgba(152, 78, 163, 1)',
                pointHoverBorderColor: 'rgba(152, 78, 163, 1)',
                borderWidth: 1
                        },
                {
                label: 'Rainfall',
                data: siloArray[5],
                backgroundColor: 'rgba(255, 127, 0, 0)',
                borderColor: 'rgba(255, 127, 0, 0.5)',
                pointBackgroundColor: 'rgba(255, 127, 0, 0.5)',
                pointBorderColor: 'rgba(255, 127, 0, 1)',
                pointHoverBackgroundColor: 'rgba(255, 127, 0, 1)',
                pointHoverBorderColor: 'rgba(255, 127, 0, 1)',
                borderWidth: 1
                        },
            	{
                label: 'Evap',
                data: siloArray[6],
                backgroundColor: 'rgba(166, 86, 40, 0)',
                borderColor: 'rgba(166, 86, 40, 0.5)',
                pointBackgroundColor: 'rgba(166, 86, 40, 0.5)',
                pointBorderColor: 'rgba(166, 86, 40, 1)',
                pointHoverBackgroundColor: 'rgba(166, 86, 40, 1)',
                pointHoverBorderColor: 'rgba(166, 86, 40, 1)',
                borderWidth: 1
                        },
          	{
                label: 'VP',
                data: siloArray[7],
                backgroundColor: 'rgba(247, 129, 191, 0)',
                borderColor: 'rgba(247, 129, 191, 0.5)',
                pointBackgroundColor: 'rgba(247, 129, 191, 0.5)',
                pointBorderColor: 'rgba(247, 129, 191, 1)',
                pointHoverBackgroundColor: 'rgba(247, 129, 191, 1)',
                pointHoverBorderColor: 'rgba(247, 129, 191, 1)',
                borderWidth: 1
                        },
          	{
                label: 'Radn',
                data: siloArray[8],
                backgroundColor: 'rgba(136, 34, 85, 0)',
                borderColor: 'rgba(136, 34, 85, 0.5)',
                pointBackgroundColor: 'rgba(136, 34, 85, 0.5)',
                pointBorderColor: 'rgba(136, 34, 85, 1)',
                pointHoverBackgroundColor: 'rgba(136, 34, 85, 1)',
                pointHoverBorderColor: 'rgba(136, 34, 85, 1)',
                borderWidth: 1
                        }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 10,
                            suggestedMax: 40,
                            stepSize: 5
                        }
                    }]
                },
                //add title
                title:{
					display: true,
					text:stationName.current + '(' + dmy + ')',
					},
                //add tooltips for the variables and add unit to them
				tooltips:{
					mode: 'index',
					intersect: false,
					callbacks: {
						label: function (t, d) {
							if (t.datasetIndex === 0) {
								return "T.min: "+t.yLabel.toFixed(2)+' °C';
							} else if (t.datasetIndex === 1) {
								return "T.max: "+t.yLabel.toFixed(2)+' °C';
							} else if (t.datasetIndex === 2) {
								return "RHmaxT: "+t.yLabel.toFixed(2)+' %';
							} else if (t.datasetIndex === 3) {
								return "RHminT: "+t.yLabel.toFixed(2)+' %';
							} else if (t.datasetIndex === 4) {
								return "Rainfall: "+t.yLabel.toFixed(2)+' mm';
							} else if (t.datasetIndex === 5) {
								return "Evap: "+t.yLabel.toFixed(2)+' mm';
							} else if (t.datasetIndex === 6) {
								return "VP: "+t.yLabel.toFixed(2)+' h Pa';
							} else if (t.datasetIndex === 7) {
								return "Radn: "+t.yLabel.toFixed(2)+' MJ/m2';
							}
						}
					}
				},
                bezierCurve : false,
                animation: false
            }
        });
    }
}
// for download the data in the form of png
function downloadCanvas(link, canvasId, filename) {
    link.href = document.getElementById(canvasId).toDataURL();
    link.download = filename;
}
