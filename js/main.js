$(document).ready(function() {
	$.getJSON('php/bus_times.php', function(data) {
		var bus_times_list = $('#bus_times ol');
		bus_times_list.empty();
		for(i=0; i<data.length; i++){
			mins = data[i].m;
			if(mins.length == 1){mins = '0' + mins;}
			time = data[i].t;
			el = $('<li></li>').html('<span class="time"><span class="at">@</span>'+time+'</span><span class="min">'+mins+'</span><span class="txt">minutes</span><div class="clear"></div>');
			el.appendTo(bus_times_list);
		}
	});
});