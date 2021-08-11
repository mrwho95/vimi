<?php

// Problem statement

// Within a rapidly growing microservice-based system, changes will often happen and are
// inevitable; be it for when a new service is created, reconfiguration of existing systems, or
// even the removal of certain systems.

// As services tend to depend on one another, a small change on one service may require all
// the other dependent services to be reconfigured.

// Scenario
// In a music platform, there are multiple services:
// Service A → User Profile Service
// Service B → Playlist Recommendation Service
// Service C → Subscription Service

// Service B depends on Service A to obtain customer’s favourite genres, interests, and history for music playlist recommendations that would be more likely to convert.

// Service C depends on Service A to obtain customer information for billing purposes. For example email address, physical address, name, and phone number.

// The current implementation of this system requires the developer to go through every single
// service that consumes information from Service A. This is to reconfigure and test every
// consuming service whenever there is a change that would affect them. For example, an API endpoint from Service A has changed in consequence of API
// standardization. 
// In your view, how would you design the system to reduce the maintenance turnaround time when similar scenarios occur and prevent mistakes during the transition?

	// $params['module'] = 'user';
	// $params['name'] = 'Dennis';
	// $params['email'] = 'abc@gmail.com';
	// $params['phone'] = '60112223333';

	// $param['']

	$url = '127.0.0.1/vimi/';
	switch($params['module']) {
		case 'subscribe':
			$url .= 'subscribe.php';
		break;

		case 'playlist':
			$url .= 'playlist.php';
		break;

		default:
			$url .= 'user.php';
		break;
	}
	array_shift($params);
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$res = curl_exec($ch);
	$res = json_decode($res,true);
	curl_close($ch);
	// if ($res) exit(json_encode(array('status' => "ERROR", 'message' => $res, 'timestamp' => date('c'))));
	exit(json_encode(array('status' => $res['status'], 'data' => $res['res'], 'timestamp' => date('c'))));

?>