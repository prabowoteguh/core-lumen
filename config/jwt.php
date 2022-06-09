<?php 
	return [
		'secret'  => env('JWT_SECRET'),
		'JWT_TTL' => env('JWT_TTL', 43800),
		'ttl'     => env('JWT_TTL', 43800),
	];