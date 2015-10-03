  $(function() {
// Выборка даты
    $( "#date-from,#date-to" ).datepicker({
        dateFormat: 'yy-mm-dd',
        onClose: function( selectedDate ) {
         $( "#date-to" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    
// Фильтр
$('#jsonbutt').click(function(){

  var dateStart = $('#date-from').val();
  var dateEnd = $('#date-to').val();
  var company = $('#company').val();

  var seanseBlock = $('#seance'); 
  var peopleBlock = $('#people');  
  var incomeBlock = $('#income'); 

  $.post( "/jsonGrafic", { 'dateStart': dateStart, 'dateEnd': dateEnd, 'company':company }, function( data ) {
    console.log(data);
    seanseBlock.html(data.seance);
    peopleBlock.html(data.people);
    incomeBlock.html(data.income);



var column_line = Object.keys(data.grafic).length; // количество графов


var interval = data.interval;
var data = data.grafic;

var arrLine = Array(0,0);
for(var series=1;series<=column_line;series++){ // перебираем массив с координатами
var line = [];
  for(var i=0;i<=interval.length;i++){    // массив из дат 

    
    if(typeof data[series][interval[i]] == 'undefined')
      line[line.length] = 0;
    else
     line[line.length] = data[series][interval[i]];
  }
line 
arrLine[series-1] = line;
console.log(arrLine);
}


new Chartist.Bar('.ct-chart', {
labels: interval,
series: arrLine,
}, {
fullWidth: true,
chartPadding: {
right: 40
}
});

})
return false;

  })

  })
 
