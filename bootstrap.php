<?php
Autoloader::add_core_namespace('Ratchet');

Autoloader::add_classes(array(
	'Ratchet\\Ratchet' => __DIR__.'/classes/ratchet.php',
	'Ratchet\\Ratchet_Ws' => __DIR__.'/classes/ratchet/ws.php',
	'Ratchet\\Ratchet_Wamp' => __DIR__.'/classes/ratchet/wamp.php',
));
