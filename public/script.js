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

  var dateStart = $('#date-from').val() + ' 00:00:00';
  var dateEnd = $('#date-to').val() + ' 23:59:59';
  var company = $('#company').val();
  var type_graf = $('#type_graf').val();
  var group_date = $('#group_date').val();

  var seanseBlock = $('#seance'); 
  var peopleBlock = $('#people');  
  var incomeBlock = $('#income'); 

  $.post( "/jsonGrafic", 
    { 
     'dateStart': dateStart ,
     'dateEnd': dateEnd,
     'company':company,
     'type_graf':type_graf, 
     'group_date':group_date, 
    },
    function( data ) {
    seanseBlock.html(data.seance);
    peopleBlock.html(data.people);
    incomeBlock.html(data.income);



console.log(data);
console.log(gd('2000-00-00 00:00:00'));
var grafic = data.grafic;   // Обьект с координатами

var point =[]; 

$.each(grafic, function( key, value ) {
          point.push(grafic[key]);
      });

for(var i=0;i<point.length;i++)
  $.each(point[i], function( key, value ) {
      $.each(value, function( key2, value2 ){ 
            value2[0] = gd(value2[0]);
            
            // при сортировке выручка
            if(type_graf=='income')
              value2[1] *= data.print_price;

            // при сортировке по длительности сеансов
            if(type_graf=='seance_time'){
                      
console.log(value2);
                        }
          }
      )
})

function gd(year) {
  return new Date(year).getTime();
}


var interval = 1;
  switch(data.group_date)
  {
    case 'hour': interval = 1;
    break;
    case 'day': interval = 1*24;
    break;
    case 'week': interval = 24*7;
    break;
    case 'month': interval = 24*30;

  }
$.plot("#placeholder", point,{
        series: {
        lines: {
          show: true
        },
        points: {
          show: true
        }
      },
xaxis: { mode: "time",minTickSize: [interval, "hour"],
min: (new Date(data.date[0])).getTime(),
max: (new Date(data.date[1])).getTime()
},


})

})
return false;

  })

  })
 
