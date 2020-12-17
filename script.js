$(document).ready(function() {

  $.ajax({
          type: 'GET',
          url: 'readDates.php',
          success: function (data) {
          var obj = jQuery.parseJSON(data);
          var ranged = new Datepicker('#ranged', {
            openOn: obj.min,
            min: obj.min,
            max: obj.max,
            separator: '-',
            ranged: true
          });
          $('#ranged').val(obj.minmax);
         }
        });

  $( "form" ).submit(function( event ){
	    event.preventDefault();
      var org = $("#radio_form")[0].selectedIndex;
      if (org==0) {
        $("#result_form").fadeIn(300);
      	$("#result_form").text('Выберите организацию').delay(2500).fadeOut(300);
        return false;
      }
      date = $("#ranged").val().split("-");
      var date1 = date[0];
      var date2 = date[1];
      load_table(org, date1, date2);
	  });
   });

  function load_table(org, date1, date2) {
    $.ajax({
  		url: "loadTable.php",
      type: "POST",
  		data: {
  			org: org,
        date1: date1,
        date2: date2
  		},
  		success: function(data) {
  			$('#data_table').html(data);
        $("#result_form").fadeIn(300);
      	$("#result_form").text('Таблица сформирована').delay(2500).fadeOut(300);

  		}
  	});
   }
