<?php

namespace Ratchet;

/**
 * Class of Ratchet
 *
 * @author    Mamoru Otsuka http://madroom-project.blogspot.jp/
 * @copyright 2013 Mamoru Otsuka
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 */
class Ratchet
{
	/**
	 * Share session with http server
	 *
	 * @param  $conn \Ratchet\ConnectionInterface
	 */
	public static function get_session(\Ratchet\ConnectionInterface $conn)
	{
		\Session::clear_instances();

		/**
		 * Set cookie
		 */
		$cookie = $conn->WebSocket->request->getHeader('Cookie');
		$data = \Guzzle\Parser\ParserRegistry::getInstance()
			->getParser('cookie')->parseCookie($cookie);

		$_COOKIE = $data['cookies'];

		/**
		 * Set remote address
		 */
		$_SERVER['REMOTE_ADDR'] = $conn->remoteAddress;

		/**
		 * Set user agent
		 * 
		 * TODO: How to get user agent like remote address
		 */
		\Config::load('session', true);
		\COnfig::set('session.match_ua', false);

		$session = \Session::forge();

		/**
		 * Remove data
		 */
		$_SERVER['REMOTE_ADDR'] = null;
		$_COOKIE = null;

		\Session::clear_instances();

		return $session;
	}

}

/* end of file ratchet.php */
