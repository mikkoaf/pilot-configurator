function rm_empties(data){
    temp = []
    for(let i of data)
        i && temp.push(i); // copy each non-empty value to the 'temp' array

    return temp;
}


/* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */

//////////////////////////////////////////////////////////////
//////////////////////// Set-Up //////////////////////////////
//////////////////////////////////////////////////////////////

var margin = {
        top: 70,
        right: 70,
        bottom: 70,
        left: 70
    },
    width = Math.min(330, window.innerWidth - 10) - margin.left - margin.right,
    height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);


var color = d3.scale.ordinal()
    .range(["#EDC951"]);


//////////////////////////////////////////////////////////////
////////////////////////// Data //////////////////////////////
//////////////////////////////////////////////////////////////

//Tässä toteutuksessa teemat ovat akseleita
//local_parser käytössä, koska matriisidata on string

function arrayMax(array) {
  return array.reduce(function(a, b) {
    return Math.max(a, b);
  });
}


jQuery( document ).ready(function($) {


    jQuery.ajax({

      url : window.location.origin + '/wp-json/pilotconf/v1/question_sets',
      type : 'GET',
      success : function( response ) {
        var sets = response;

        $(".radarChart").each(function(index){
            var target = "#"+ $(this).attr('id');
            var values = JSON.parse($(this).attr('data-matrix')); // local_parser($(this).attr('data-matrix'));
            var form = JSON && JSON.parse($(this).attr('data-form')) || $.parseJSON($(this).attr('data-form'));
            for (arr in values){
                values[arr] = values[arr].reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
            }
            //tuki useammalle/vähemmälle määrälle settejä vaihtelevalla kysymysmäärällä

            var input =[];
            //iteroidaan nyt useamman taulukon yli. map-funktio tai vastaava olis kiva...
            for (i=0; i< sets.length;i++){
                input.push({
                    axis: i+1 + ". " + sets[i].theme,
                    value: values[i] // form[i+1]
                });
            }
            var data = [input];

            var radarChartOptions = {
                w: width,
                h: height,
                margin: margin,
                // maximum value is relative to the questionare.
                maxValue: arrayMax(values),
                levels: 5,
                roundStrokes: true,
                color: color
            };

            //////////////////////////////////////////////////////////////
            //////////////////// Draw the Chart //////////////////////////
            //////////////////////////////////////////////////////////////


            //Call function to draw the Radar chart
            RadarChart(target, data, radarChartOptions);
        });

      }
    });

});
