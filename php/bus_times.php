<?php
$bus_number = '70';
$bus_direction = '70_700004v0_1'; // inbound
$bus_stop = '86939'; //inbound
//$bus_direction = '70_700011v0_0'; // outbound
//$bus_stop = '01072'; //outbound
$bus_times = 'http://webservices.nextbus.com/service/publicXMLFeed?command=predictions&a=mbta&r='.$bus_number.'&d='.$bus_direction.'&s='.$bus_stop;
$xml = simplexml_load_file($bus_times);
$predictions = $xml->xpath('///prediction');
$bus_count = count($predictions);
$bus_times = array();
$i = 0;
while($i < $bus_count){
	$bus_info = get_object_vars($predictions[$i]);
	$minutes = $bus_info['@attributes']['minutes'];
	$time = strtotime('+ 3 hours '.$minutes.' minutes');
	$time = date('h:i', $time);
	array_push($bus_times, array('m' => $minutes, 't' => $time));
	$i++;
}
echo json_encode($bus_times);


/*
	$bus_route = $_GET['route_number'];
	$stops_list = 'http://webservices.nextbus.com/service/publicXMLFeed?command=routeConfig&a=mbta&r=70';
	$stops_list_xml = file_get_contents($stops_list);
	$stops_list_xml = simplexml_load_file($stops_list);
	$stop_array = $stops_list_xml->xpath('//direction');
	$stop_count = count($stop_array);
	$stops = array();
	$inbound = array();
	$outbound = array();
	$i = 0;
	while($i < $stop_count){
		$stop_info = get_object_vars($stop_array[$i]);
		$direction = $stop_info['@attributes']['name'];
		$direction_tag = $stop_info['@attributes']['tag'];
		$all_stops_array = $stop_info['stop'];
		$all_stops_count = count($all_stops_array);
		$j = 0;
		while($j < $all_stops_count){
			$tag_info = get_object_vars($all_stops_array[$j]);
			$tag = $tag_info['@attributes']['tag'];
			//
			$stop_array_2 = $stops_list_xml->xpath('//stop');
			$stop_count_2 = count($stop_array_2);
			$k = 0;
			
			while($k < $stop_count_2){
				$stop_info_2 = get_object_vars($stop_array_2[$k]);
				$tag_2 = $stop_info_2['@attributes']['tag'];
				$title = $stop_info_2['@attributes']['title'];
				$stop_id = $stop_info_2['@attributes']['stopId'];
				if($tag_2 == $tag && $direction == 'Inbound' && $direction_tag != '' && $title != '' && $stop_id != ''){
					array_push($inbound, array('stp_tag' => $tag, 'stp_title' => $title, 'stp_id' => $stop_idl, 'dir_tag' => $direction_tag));
				}
				if($tag_2 == $tag && $direction == 'Outbound' && $direction_tag != '' && $title != '' && $stop_id != ''){
					array_push($outbound, array('stp_tag' => $tag, 'stp_title' => $title, 'stp_id' => $stop_id, 'dir_tag' => $direction_tag));
				}
				$k++;
			}
			
			$j++;
		}
		$i++;
	}
	array_push($stops, array('inbound' => $inbound, 'outbound' => $outbound));
	echo json_encode($stops);
*/
?>