<?php
/* 
* Plugin Name: GM4SO Google Maps plugin for Shop/Store Owners
* Plugin URI: http://www.shikumilab.jp/
* Description: This plugin provides Services for Shop Owners . Root search from user's resent place or Nearest Station to shop , Show close shops , regist lat / lng from Shop's address and more...
* Author: Shikumilab , Inc
* Version: 0.9
* Author URI: http://www.shikumilab.jp/gm4so/
*/

/**
 * fook
 */
add_action( 'wp_footer', 'gm4so_print_scripts' );

//add_filter( 'the_content', 'displayMapSingle' );
//add_filter( 'the_content', 'displayMapArchive' , '25');
//add_filter( 'the_content', 'displayClosestStation' , '30');
//add_filter( 'the_content', 'displayClosestShops' , '40');

function enqueue_gm4so_stylesheet() {
	if( $post_type != 'ground' )
		return false;

	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	wp_enqueue_style( 'gm4so', $x.'gm4so.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_gm4so_stylesheet' );

/**
 * google Maps API を利用してPostType: shop 保存時に緯度経度情報を取得/保存
 * 2013.10.27
 * @author Kei Tamura
 */
add_action('save_post','setLatLng','20');
// get lat&lng from googleMapsAPI
function geocode($address){
	$xmlUrl ='http://maps.google.com/maps/api/geocode/xml'; 
	$xmlUrl .='?address='.urlencode($address); 
	$xmlUrl .='&sensor=false'; 
	$xml = simplexml_load_file($xmlUrl) or die('XML parsing error');

	if ($xml->status =='OK') { 
		$loc['lat'] = (string)$xml->result->geometry->location->lat; 
		$loc['lng'] = (string)$xml->result->geometry->location->lng; 
	} 
	return $loc;
} 

// update customfield
function setLatLng($postID){
	global $post_type;
	if( $post_type != 'ground' )
		return false;

	if($parent_id = wp_is_post_revision($postID)) {
		$postID = $parent_id; 
	} 
	$address = get_post_meta($postID , 'address',true); 
	if( $address ){ 
	$location = geocode($address); 
		if ( !add_post_meta($postID, 'lat', $location['lat'], true) ) update_post_meta($postID,'lat', $location['lat'] ); 
		if ( !add_post_meta($postID, 'lng', $location['lng'], true) ) update_post_meta($postID,'lng', $location['lng'] ); 
	}else{ 
		delete_post_meta($postID ,'lat'); 
		delete_post_meta($postID ,'lnt'); 
	} 
}


/**
 * http://express.heartrails.com/api/ を利用してPostType: shop 保存時に最寄り駅の情報を取得/保存
 * 2013.10.27
 * @author Kei Tamura
 */
// In Japan Only , get closest station from shop's latitude and longitude .
/*
add_action('save_post','setClosestStation','20');

function getClosestStation($geo){ 
	$xmlUrl  = 'http://express.heartrails.com/api/xml?method=getStations';
	$xmlUrl .= '&x='.$geo['lng'];
	$xmlUrl .= '&y='.$geo['lat'];
	$xml = simplexml_load_file($xmlUrl) or die('XML parsing error');

	$closestStation['line'] = $xml -> station -> line;
	$closestStation['name'] = $xml -> station -> name;
	$closestStation['x'] = $xml -> station ->  x;
	$closestStation['y'] = $xml -> station -> y;	
	$closestStation['distance'] = $xml -> station -> distance;
	return $closestStation;
}

// update customfield closest station lat,lng,name,line
function setClosestStation(){
	global $post, $post_type;
	if( $post_type != 'ground' )
		return false;

	if($parent_id = wp_is_post_revision($post->ID)) {
		$postID = $parent_id; 
	} 
	$geo['lat'] = get_post_meta($post->ID , 'lat',true); 
	$geo['lng'] = get_post_meta($post->ID , 'lng',true); 
	if( $geo ){ 
	$closestStation = getClosestStation($geo); 
		if ( !add_post_meta($post->ID, 'closestStationLine', (string)$closestStation['line'], true) ) update_post_meta($post->ID,'closestStationLine', (string)$closestStation['line'] ); 
		if ( !add_post_meta($post->ID, 'closestStationName', (string)$closestStation['name'], true) ) update_post_meta($post->ID,'closestStationName', (string)$closestStation['name'] ); 
		if ( !add_post_meta($post->ID, 'closestStationDistance', (string)$closestStation['distance'] , true) ) update_post_meta($post->ID,'closestStationDistance', (string)$closestStation['distance']  ); 
		if ( !add_post_meta($post->ID, 'closestStationLat', (string)$closestStation['y'], true) ) update_post_meta($post->ID,'closestStationLat', (string)$closestStation['y'] ); 
		if ( !add_post_meta($post->ID, 'closestStationLng', (string)$closestStation['x'], true) ) update_post_meta($post->ID,'closestStationLng', (string)$closestStation['x'] ); 
	} 
}
*/

/**
 * 最寄り駅の情報を表示
 * 最寄り駅情報が存在しない場合は function:setClosestStation により最寄り駅情報を取得しカスタムフィールドに登録
 * 2013.10.27
 * @author Kei Tamura
 */
/*

function displayClosestStation($content) {
 	global $post;
	if( is_single($post) && get_post_type($post) === 'shops' )
	{
		if( !get_post_meta($post->ID,'closestStationName',true) )
		{
			setClosestStation($post);
		}
		$closestStationLine = get_post_meta($post->ID,'closestStationLine',true);
		$closestStationName = get_post_meta($post->ID,'closestStationName',true);
		$closestStationDistance = get_post_meta($post->ID,'closestStationDistance',true);
		$closestStationLat = get_post_meta($post->ID,'closestStationLat',true);
		$closestStationLng = get_post_meta($post->ID,'closestStationLng',true);

		$output ="<h2>最寄り駅</h2>";
		$output .= "<div>" . $closestStationLine . "</div>\n";
		$output .= "<div>" . $closestStationName . "</div>\n";
		$output .= "<div>" . $closestStationDistance . "</div>\n";
		$content .= $output;
		return $content;
	}
}
*/

/**
 * 近隣店舗の情報を取得/表示
 * 2013.10.27
 * @author Kei Tamura
 */

function displayClosestshopss($content)
{
	if( is_single($post) && get_post_type($post) === 'shops' )
	{
		global $post,$wpdb;
		$lat = get_post_meta($post->ID , 'lat' , true);
		$lng = get_post_meta($post->ID , 'lng' , true);
		$distance = 20;
		$num = 11;
		$neighborhood = $wpdb->get_results("
			SELECT lat.lat_id, lat.lat, lat.post_title, lng.lng_id, lng.lng, (6371 * acos(cos(radians($lat)) * cos(radians(lat.lat)) * cos(radians(lng.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat.lat)))) AS distance 
			FROM (SELECT DISTINCT id as lat_id, meta_value as lat, post_title FROM $wpdb->posts 
			JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
			WHERE post_type = 'shops' AND post_status='publish' AND meta_key = 'lat') as lat, 
			(SELECT DISTINCT id as lng_id, meta_value as lng FROM $wpdb->posts 
			JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
			WHERE post_type = 'shops' AND post_status='publish' AND meta_key = 'lng') as lng 
			HAVING lat.lat_id = lng.lng_id AND distance < $distance ORDER BY distance LIMIT 0 , $num;
		");
		$output .="<section id=\"neighborhood\" class=\"section\">\n";
		$output .= "	<div class=\"title\">\n";
		$output .= "		<h2>近隣店舗</h2>\n";
		$output .= "	<!--/.title--></div>\n";
		$output .= "	<div class=\"content\">\n";
		$output .= "		<ul>\n";
		$i = 1;
		while ($i<$num) {
			if (!$neighborhood[$i]->post_title) {
				break;
			}
			$output .= "		<li><a href=\"". get_option('home')."/shops/".$neighborhood[$i]->lat_id . "\">" . $neighborhood[$i]->post_title. "</a><span class=\"distance\">距離：" . round($neighborhood[$i]->distance,1) . "km</span></li>\n";
			$i++;
		}
		$output .= "		</ul>\n";
		$output .= "	<!--/.content--></div>\n";
		$output .= "<!--/#neighborhood--></section>\n";

		$content .= $output;
		return $content;
	}
}

/**
 * GoogleMapAPI用のJavascriptを出力:archive 用
 * 2013.10.27
 * @author Kei Tamura
 */
add_action( 'wp_footer', 'gmapArchive' );

function gmapArchive() {
	global $query_string;
	if( is_post_type_archive( 'shops' ) ) {
		$args = $query_string . '&posts_per_page=-1' ;
		$the_query = new WP_Query( $args );
		$latArray = array();
		$lngArray =array();

		while ( $the_query->have_posts() ) : $the_query->the_post();
			$id = $post->ID;
			$permalink = get_permalink();
			$id = get_the_ID();
			$title = get_the_title();
			$lat = get_post_meta( $id, 'lat', true );
			$lng = get_post_meta( $id, 'lng', true );
			$address = get_post_meta( $id,'address',true );
			//$tel = get_post_meta( $id, 'tel', true );
			$fax = get_post_meta( $id, 'fax', true );

			$latLng .= "data.push({position: new google.maps.LatLng(" . $lat . "," . $lng . "),content:'<a href=".$permalink.">" . $title . "</a>'});\n";

			$latArray[] = $lat;
			$lngArray[] = $lng;
		endwhile;

		$north = max($latArray);
		$south = min($latArray);
		$east = max($lngArray);
		$west = min($lngArray);

		$latAverage = ($north + $south+0.0000)/2;
		$lngAverage = ($east + $west+0.0000)/2;

		$diff_lat = $north - $south;
		$diff_lng = $east - $west ;
	}

	$script = <<<EOL
<!--ここからGoogle Maps API v3-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBeWWz9oBRexFwLJO0JDUFDQTibV_FrIR4"></script>

<script type="text/javascript">
  function attachMessage(marker, msg) {
    google.maps.event.addListener(marker, 'click', function(event) {
      new google.maps.InfoWindow({
        content: msg
      }).open(marker.getMap(), marker);
    });
  }
// 位置情報と表示データの組み合わせ
  var data = new Array();
  {$latLng}
  var myMap = new google.maps.Map(document.getElementById('map_archive'), {
    zoom: 12,
    center: new google.maps.LatLng({$latAverage},{$lngAverage}),
    scrollwheel: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  for (i = 0; i < data.length; i++) {
    var myMarker = new google.maps.Marker({
      position: data[i].position,
      map: myMap
    });
    attachMessage(myMarker, data[i].content);
  }
  if ( {$diff_lat}>0 && {$diff_lng} >0 ) {
	var sw = new google.maps.LatLng({$south}, {$west});
	var ne = new google.maps.LatLng({$north}, {$east});
	var bounds = new google.maps.LatLngBounds(sw, ne);
	myMap.fitBounds(bounds);
  }
</script>
EOL;

	if( is_post_type_archive( 'ground' )  ){
		echo $script;
	}
	wp_reset_postdata();
	wp_reset_query();
}


/**
 * GoogleMap <div id=map_canvas>を表示
 * 2013.10.27
 * @author Kei Tamura
 */

function displayMapArchive($content)
{
	if( is_tax() && get_post_type() === 'shops' )
	{
		$mapWidth = "100%";
		$mapHeight = "600px";
		$content .= "<div id=\"map_archive\" style=\"width : " .$mapWidth . ";height : " . $mapHeight . ";\"></div>";
		return $content;
	}
}



/**
 * GoogleMap <div id=map_canvas>を表示
 * 2013.10.27
 * @author Kei Tamura
 */

function displayMapSingle( $content )
{
	if( get_post_type() === 'shops' )
	{
		$mapWidth = "100%";
		$mapHeight = "500px";
		$append_html = '<div id="map_canvas" style="width : ' .$mapWidth . ';height : ' . $mapHeight . ';"></div>' . PHP_EOL
					. '<button id="gm4so_stationRoot">最寄り駅からの道順を検索</button>' . PHP_EOL
					. '<button id="gm4so_locationRoot">現在地からの道順を検索</button>' . PHP_EOL;

		$content = $append_html . $content;

		return $content;
	} else {
		return $content;
	}
}

/**
 * GoogleMapAPI用のJavascriptを出力
 * 2013.10.18
 * @author Keisuke
 */

function gmap_api_script()
{
	if( is_admin() )
		return false;

	global $post;

	//緯度
	$lat = get_post_meta( $post->ID, 'lat', true );

	//経度
	$lng = get_post_meta( $post->ID, 'lng', true );

	//店舗タイトル
	$title = get_the_title( $post->ID );

	//住所
	$address = get_post_meta( $post->ID,'address',true );

	//電話番号
	//$tel = get_post_meta( $post->ID, 'tel', true );

	//FAX番号
	//$fax = get_post_meta( $post->ID, 'fax', true );

	//最寄り駅緯度経度
	//$closest_station_lat = get_post_meta( $post->ID, 'closestStationLat', true );
	//$closest_station_lng = get_post_meta( $post->ID, 'closestStationLng', true );

	$script = <<<EOL
<!--Map表示・位置情報取得 Google API、位置情報を取得しない場合は最後はfalseでOK-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBeWWz9oBRexFwLJO0JDUFDQTibV_FrIR4"></script>
<script type="text/javascript">

//マップの表示をスタート
google.maps.event.addDomListener(window, 'load', initialize);

//地図の中心
var center = new google.maps.LatLng({$lat}, {$lng});

//最寄り駅のLatLng
//if({$closest_station_lat} && {$closest_station_lng}) {
//	var closestStationLatLng = new google.maps.LatLng({$closest_station_lat}, {$closest_station_lng});
//} else {
//	var closestStationLatLng = new google.maps.LatLng(135, 35);
//}

//地図の倍率
var zoom = 17;

//地図のタイプ
var mapTypeId = google.maps.MapTypeId.ROADMAP;

//マーカー画像
var icon = 'http://waox.main.jp/maps/icon/car2.png';

//情報ウインドウ内のコンテンツHTML
var contentString =
	'<div id="content">'+
	'<div id="siteNotice">'+
	'</div>'+
	'<h4 id="firstHeading" class="firstHeading">{$title}</h4>'+
	'<div id="bodyContent">'+
	'住所：{$address}'+
	'</div>'+
	'</div>';

//ルート検索オブジェクト
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();

	//オプションの定義
	var myOptions = {
		zoom: zoom,
		center: center,
		mapTypeId: mapTypeId,
	}

	//地図の表示
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);

    //◆現在地マーカー
    var marker = new google.maps.Marker({
		map: map,
		position: center,  //マーカ位置
		//icon: icon,
		//animation: google.maps.Animation.DROP,
		title: '{$title}'
    });

    //◆情報ウインドウ
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	infowindow.open(map,marker);

}
//◆ルート検索
//最寄り駅からのルート検索
function calc_route_from_closest_station(){
	var start = closestStationLatLng;
	var end = center;
	var request = {
		origin:start,
		destination:end,
		travelMode: google.maps.TravelMode.WALKING
	};
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
}


//現在地からのルート検索
function calc_route_from_geolocation(position){
	var start = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	var end = center;
	var request = {
		origin:start,
		destination:end,
		travelMode: google.maps.TravelMode.DRIVING
	};
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
}

</script>
EOL;

	if( is_single() && get_post_type() === 'ground' ){
		echo $script;
	}
}
add_action( 'wp_footer', 'gmap_api_script' );


/**
 * JavaScriptの読み込み
 * 2013.11.1
 * @author Keisuke
 */
function gm4so_print_scripts(){
	if( !is_admin() ){
		wp_enqueue_script( 'gm4so', plugin_dir_url(__FILE__) . 'gm4so.js' );
	}
}


/**
 * JavaScriptの読み込み
 * 2017.2.2
 * @author Kei Tamura
 */
function gm4so_print_scripts_admin(){
	$script = <<<EOL
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBeWWz9oBRexFwLJO0JDUFDQTibV_FrIR4"></script>
<script type="text/javascript">
// ページ読み込み完了時に実行する関数
function init() {

	// 初期位置
	var okayamaTheLegend = new google.maps.LatLng(34.666358, 133.918576);

	// マップ表示
	var okayamap = new google.maps.Map(document.getElementById("map"), {
		center: okayamaTheLegend,
		zoom:13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	// ドラッグできるマーカーを表示
	var marker = new google.maps.Marker({
		position: okayamaTheLegend,
		title: "Okayama the Legend!",
		draggable: true	// ドラッグ可能にする
	});
	marker.setMap(okayamap)	;

	// マーカーのドロップ（ドラッグ終了）時のイベント
	google.maps.event.addListener( marker, 'dragend', function(ev){
		// イベントの引数evの、プロパティ.latLngが緯度経度。
		document.getElementById('latitude').value = ev.latLng.lat();
		document.getElementById('longitude').value = ev.latLng.lng();
	});
}

// ONLOADイベントにセット
window.onload = init();
</script>
EOL;
	if( is_admin() ){
		echo $script;
	}
}
//add_action( 'wp_footer', 'gm4so_print_scripts_admin' );


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_meta_box() {

	$screens = array( 'ground' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'myplugin_sectionid',
			__( 'My Post Section Title', 'myplugin_textdomain' ),
			'myplugin_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_save_meta_box_data', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_my_meta_value_key', true );

	echo '<label for="myplugin_new_field">';
	_e( 'Description for this field', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'ground' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['myplugin_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );




