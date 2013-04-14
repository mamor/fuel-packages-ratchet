<?php

namespace Ratchet;

/**
 * Class of Ratchet WebSocketServer
 *
 * @author    Mamoru Otsuka http://madroom-project.blogspot.jp/
 * @copyright 2013 Mamoru Otsuka
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 */
class Ratchet_Ws implements \Ratchet\MessageComponentInterface
{

	public function onClose(\Ratchet\ConnectionInterface $conn) {

	}

	public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e) {

	}

	public function onMessage(\Ratchet\ConnectionInterface $from, $msg) {

	}

	public function onOpen(\Ratchet\ConnectionInterface $conn) {
		$conn->session = Ratchet::get_session($conn);
	}

}

/* end of file ws.php */
