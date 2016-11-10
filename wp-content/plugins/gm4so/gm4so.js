(function($){
	$(document).ready(function(){
		var $map_canvas = $('#map_canvas');

		//最寄り駅からのルート検索
		$('#gma4so_stationRoot').on('click', function(){
			calc_route_from_closest_station();
			return false;
		});

		//現在地からのルート検索
		if (navigator.geolocation) {
			//Geolocation APIを利用できる環境向けの処理
			$('#gma4so_locationRoot').on('click', function(){
				navigator.geolocation.getCurrentPosition(calc_route_from_geolocation);
				return false;
			});
		} else {
			//Geolocation APIを利用できない環境向けの処理
			$('#gma4so_locationRoot').css('display', 'none');
		}
	});
})(jQuery);