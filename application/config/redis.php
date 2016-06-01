<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Redis settings
| -------------------------------------------------------------------------
| Your Redis servers can be specified below.
|
|	See:  http://redis.io
|
*/
$config = array(
	'default' => array(
		'socket_type' => 'tcp',//`tcp` or `unix`
		'socket'     => '/var/run/redis.sock',// in case of `unix` socket type
		'host'   => '127.0.0.1',
                'password'   => 'NULL',
                'port'   => 6379,
                'timeout'   => 0,
	),
);
