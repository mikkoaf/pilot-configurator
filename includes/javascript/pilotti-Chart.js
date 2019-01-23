function rm_empties(data){
    temp = []
    for(let i of data)
        i && temp.push(i); // copy each non-empty value to the 'temp' array

    return temp;
}


function pc_local_parser(data){

      data = data.replace(/\[/g,"");
  data = data.split(",");

    an_array =[]
    data.forEach(element => {
          element = element.replace('\"',"");
        an_array.push(parseInt(element));
    });
    return an_array;
}

function fillArray(value, len) {
  if (len == 0) return [];
  var a = [value];
  while (a.length * 2 <= len) a = a.concat(a);
  if (a.length < len) a = a.concat(a.slice(0, len - a.length));
  return a;
}

jQuery( document ).ready(function($) {

  jQuery.ajax({

    url : window.location.origin + '/wp-json/pilotconf/v1/questions',
    type : 'GET',
    success : function( response ) {
      var questions = response;




        $(".pilotchart").each(function(index){
          var me = $(this).attr('id');
          var baseValues = pc_local_parser($(this).attr('data-carr-min'));
          var sAnswers = pc_local_parser($(this).attr('data-sAnswers'));
          var xValues = pc_local_parser($(this).attr('data-xValues'));
          var qTitles = [];
          var sarr = $(this).attr('data-sarr');
          var i = 0;
          for (bit in questions){
              i++;
              qTitles.push(i +". " +questions[bit].question);
          }

          var pc_data = [];
          var markervals = fillArray("rgba(255, 99, 132, 0.2)", 23);
            pc_data.push(
              {
                    displayModeBar: false,
                    type: "bar",
                    name: "haluttu",
                    x: xValues,
                    base: baseValues,
                    y: qTitles,
                    marker: {color: markervals},
                    orientation: "h",
                    offset: 0
                  }
                );
                var basevals = fillArray(0.05, 23);
                  markervals = fillArray("orange", 23);
              pc_data.push(
              {
                displayModeBar: false,
                type: "bar",
                name: "vastattu",
                x: basevals,
                base: sAnswers,
                y: qTitles,
                marker: { color: markervals },
                orientation: "h",
                offset: 0
              }
            );

console.log(pc_data);
          Plotly.plot(me, pc_data,
          {	displayModeBar: false,
            yaxis: { autorange: "reversed"}
          });
        });



    }
  });



});
