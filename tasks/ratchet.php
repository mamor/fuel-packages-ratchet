<?php

namespace Fuel\Tasks;

require __DIR__.'/../vendor/autoload.php';

/**
 * Task of Ratchet Server
 *
 * @author    Mamoru Otsuka http://madroom-project.blogspot.jp/
 * @copyright 2013 Mamoru Otsuka
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 */
class Ratchet
{

	/**
	 * Class initialization
	 */
	public function __construct()
	{
		\Config::load('ratchet', true);
	}

	/**
	 * Show help
	 *
	 * Usage (from command line):
	 * 
	 * php oil r ratchet
	 */
	public static function run()
	{
		static::help();
	}

	/**
	 * Show help
	 *
	 * Usage (from command line):
	 * 
	 * php oil r ratchet:help
	 */
	public static function help()
	{
		$output = <<<HELP

Description:
  Task of Ratchet Server

Commands:
  php oil refine ratchet:ws <class_name>
  php oil refine ratchet:wamp <class_name>
  php oil refine ratchet:help

HELP;
		\Cli::write($output);
	}

	/**
	 * Run WebSocket Server
	 *
	 * Usage (from command line):
	 * 
	 * php oil r ratchet:ws <class_name>
	 * 
	 * Note:
	 * http://socketo.me/docs/hello-world
	 * http://socketo.me/docs/websocket
	 */
	public static function ws($class_name = null)
	{
		/**
		 * Check class name
		 */
		if ( ! class_exists($class_name))
		{
			static::help();
			exit();
		}

		$config = \Ratchet::get_config($class_name);

		/**
		 * Check port
		 */
		if ( ! is_numeric($config['port']))
		{
			static::help();
			exit();
		}

		$class = new $class_name;

		$server = \Ratchet\Server\IoServer::factory(
			new \Ratchet\WebSocket\WsServer($class), $config['port']);

		$server->run();
	}

	/**
	 * Run WebSocket Server
	 *
	 * Usage (from command line):
	 * 
	 * php oil r ratchet:wamp <class_name>
	 * 
	 * Note:
	 * http://socketo.me/docs/push
	 * http://socketo.me/docs/wamp
	 */
	public static function wamp($class_name = null)
	{
		/**
		 * Check class name
		 */
		if ( ! class_exists($class_name))
		{
			static::help();
			exit();
		}

		$config = \Ratchet::get_config($class_name);

		/**
		 * Check port
		 */
		if ( ! is_numeric($config['port']))
		{
			static::help();
			exit();
		}

		/**
		 * Check zmq port
		 */
		if ( ! is_numeric($config['zmq_port']))
		{
			static::help();
			exit();
		}

		$loop   = \React\EventLoop\Factory::create();
		$class = new $class_name;

		/**
		 * Listen for the web server to make a ZeroMQ push after an ajax request
		 */
		$context = new \React\ZMQ\Context($loop);

		$pull = $context->getSocket(\ZMQ::SOCKET_PULL);

		// Binding to 127.0.0.1 means the only client that can connect is itself
		$pull->bind('tcp://127.0.0.1:'.$config['zmq_port']);
		$pull->on('message', array($class, 'callback'));

		/**
		 * Set up our WebSocket server for clients wanting real-time updates
		 */
		$socket = new \React\Socket\Server($loop);

		// Binding to 0.0.0.0 means remotes can connect
		$socket->listen($config['port'], '0.0.0.0');
		$server = new \Ratchet\Server\IoServer(
			new \Ratchet\WebSocket\WsServer(
				new \Ratchet\Wamp\WampServer($class)), $socket);

		$loop->run();
	}

}
