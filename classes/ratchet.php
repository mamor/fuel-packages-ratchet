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
	 * initialize
	 */
	public static function _init()
	{
		\Config::load('ratchet', true);
	}

	/**
	 * Get config for class
	 *
	 * @param  $class_name config key
	 */
	public static function get_config($class_name)
	{
		return array_merge(
			\Config::get('ratchet.classes.default', array()),
			\Config::get('ratchet.classes.'.$class_name, array())
		);
	}

	/**
	 * Get WebSocket URI
	 *
	 * @param  $class_name config key
	 */
	public static function get_uri($class_name)
	{
		$config = static::get_config($class_name);

		return ! empty($config['ws_uri']) ?
			$config['ws_uri'] : 'ws://'.$config['domain'].':'.$config['port'];
	}

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
		$cookie = $conn->WebSocket->request->getHeader('cookie');
		$data = \Guzzle\Parser\ParserRegistry::getInstance()
			->getParser('cookie')->parseCookie($cookie);

		$_COOKIE = $data['cookies'];

		/**
		 * Set remote address
		 */
		$x_forwarded_for = $conn->WebSocket->request->getHeader('x-forwarded-for');
		$_SERVER['REMOTE_ADDR'] = ! empty($x_forwarded_for) ?
			$x_forwarded_for : $conn->remoteAddress;

		/**
		 * Set user agent
		 * 
		 * TODO: How to get user agent like remote address
		 */
		\Config::load('session', true);
		\COnfig::set('session.match_ua', false);

		try
		{
			$session = \Session::forge();
		}
		catch (\Exception $e)
		{
			$session = null;
		}

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
