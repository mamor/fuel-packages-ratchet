<?php

/**
 * Class of Session
 *
 * @author    Mamoru Otsuka http://madroom-project.blogspot.jp/
 * @copyright 2013 Mamoru Otsuka
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 */
class Session extends Fuel\Core\Session
{
	public static function clear_instances()
	{
		static::$_instance = null;
		static::$_instances = array();
	}
}

/* end of file session.php */
