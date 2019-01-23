function rm_empties(data){
    temp = []
    for(let i of data)
        i && temp.push(i); // copy each non-empty value to the 'temp' array

    return temp;
}


function local_parser(data){

    an_array =[]
    // "[[1,2],[1,2],[1,2],[1,2],[1,2]]""
    data = data.replace(/\[/g,"");
    data = data.split(']');
    data = rm_empties(data);
    // rm empties
    data.forEach(element => {
        element = element.split(",");
        element = rm_empties(element);
        //rm empties
        an_array.push(element);

    });

    // "1,2" , ",1,2" , ",1,2" , ",1,2" , ",1,2" , ""
    //poista [
    // split ,
    // poista tyhjät alkiot
    return an_array;
}


jQuery( document ).ready(function($) {

  jQuery.ajax({

    url : window.location.origin + '/wp-json/pilotconf/v1/question_sets',
    type : 'GET',
    success : function( response ) {
      var question_sets = response;

      $(".heatmap").each(function(index){
          // tulostettavan kohteen uniikki id
          var id = $(this).attr('id');
          var sets =  question_sets;
          var zValues = local_parser($(this).attr('data-matrix'));
          zValues.reverse();

          /*
          *   tämä vastaamaan muuttuvien kysymysten määriä
          */
          var xValues = [];
          for (i=1; i <= Math.max.apply(null, zValues.map(row => row.length)); i++){
              xValues.push(i);
          }

          var yValues = [];
          var i = 0;
          for (bit in sets){
              i++;
              yValues.push(i +". " +sets[bit].theme);
          }
          yValues.reverse();

          var max = Math.max.apply(null, zValues.map(row => Math.max.apply(Math, row)));
          var min = Math.min.apply(null, zValues.map(row => Math.min.apply(Math, row)));


          var erotus = max - min;
          var ala = "rgb(255, 0, 0)";
          //var keski = "rgb(255, 165, 0)";
          var yla = "rgb(60, 179, 113)";

          if(erotus >= 0.65){

              ala = "rgb(255, 0, 0)";
              //keski = "rgb(255, 165, 0)";
              yla = "rgb(60, 179, 113)";
          }
          else if(erotus >= 0.33){
              if(max >= 0.75){
                  yla = "rgb(60, 179, 113)";
              }
              else if(max >= 0.4){
                  yla = "rgb(255, 165, 0)";
              }
              else{
                  yla = "rgb(255, 90, 0)";
              }
              if(min >= 0.75){
                  ala = "rgb(165, 165, 0)";
              }
              else if(min >= 0.4){
                  ala = "rgb(255, 165, 0)";
              }
              else{
                  ala = "rgb(255, 0, 0)";
              }
          }
          else{
              //arvot ovat niin lähellä toisiaan
              if(min >= 0.7){
                  ala = "rgb(165, 165, 0)";
                  yla = "rgb(60, 179, 113)";
              }
              else if(min >= 0.4){
                  ala = "rgb(255, 196, 0)";
                  yla = "rgb(165, 165, 0)";
              }
              else{
                  ala = "rgb(255, 0, 0)";
                  yla = "rgb(255, 123, 0)";

              }

          }
          //rgb(255, 0, 0) - punainen
          //rgb(255, 165, 0) - keltainen
          //rgb(60, 179, 113) - vihreä
          var colorscaleValue = [
              ['0.0', ala],
              //['0.5', keski],
              ['1.0', yla]
          ];

          var data = [{
              x: xValues,
              y: yValues,
              z: zValues,
              hoverinfo: 'text',
              text: zValues,
              type: 'heatmap',
              colorscale: colorscaleValue,
              showscale: false
          }];

          var layout = {
              title: 'Vastausten yhteneväisyys',
              annotations: [],
              domain:[0.85,1.9],
              width: 700,
              height: 500,
              xaxis: {
                  ticks: '',
                  side: 'top'
              },
              yaxis: {
                  ticks: '',
                  ticksuffix: ' ',
                  width: 300,
                  height: 300,
                  autosize: false
              },
              margin: {
                  l: 200,
                  r: 50,
                  b: 100,
                  t: 100,
                  pad: 4
                },
                paper_bgcolor: '#ffffff',
                plot_bgcolor: '#ffffff'
          };

          for (var i = 0; i < yValues.length; i++) {
              for (var j = 0; j < xValues.length; j++) {
                  var currentValue = zValues[i][j];
                  if (currentValue != 0.0) {
                      var textColor = 'white';
                  } else {
                      var textColor = 'black';
                  }
                  var result = {
                      xref: 'x1',
                      yref: 'y1',
                      x: xValues[j],
                      y: yValues[i],
                      text: zValues[i][j],
                      font: {
                          family: 'Arial',
                          size: 12,
                          color: 'rgb(50, 171, 96)'
                      },
                      showarrow: false,
                      font: {
                          color: textColor
                      }
                  };
                  layout.annotations.push(result);
              }
          }
          Plotly.newPlot(id, data, layout);

      });

    }
  });


});
