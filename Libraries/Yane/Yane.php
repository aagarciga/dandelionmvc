<?php

/**
 * Yane Data Access 1.0.0.0
 * 
 * @author Alex Alvarez Gárciga <aagarciga@gmail.com>
 * @copyright 2011-2025 Alex Alvarez Gárciga / Wishware LLC
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/wishware/Yane
 */

namespace Dandelion\Yane;

if (!defined('__DIR__')) {
	define('__DIR__', dirname(__FILE__));
}

define('YANE_DIR_ROOT', __DIR__);
define('YANE_DIR_DRIVERS', YANE_DIR_ROOT . DIRECTORY_SEPARATOR . 'Drivers');
define('YANE_DIR_INTERFACES', YANE_DIR_ROOT . DIRECTORY_SEPARATOR . 'Interfaces');


/**
 * DRIVERS DEFINITIONS
 */

define('YANE_DIR_DRIVER_POSTGRESQL', YANE_DIR_DRIVERS . DIRECTORY_SEPARATOR . 'PostgreSQL');
define('YANE_DIR_DRIVER_MariaDB', YANE_DIR_DRIVERS . DIRECTORY_SEPARATOR . 'MariaDB');
define('YANE_DIR_DRIVER_MSSQL', YANE_DIR_DRIVERS . DIRECTORY_SEPARATOR . 'MSSQL');

/**
 * Yane Instance.
 * Data Access Library Loader & Entry Point.
 * This class implements Singleton behavior.
 */
final class Yane
{

	static private $instance = null;
	public static function Init()
	{
		if (self::$instance == null) {
			self::$instance = new Yane();
		}
		spl_autoload_register(array(self::$instance, 'classLoader'));
		return self::$instance;
	}

	final function __construct() {}

	final function __clone() {}

	/**
	 * Class Loader.
	 * @param string $className
	 */
	private function classLoader($className): void
	{
		$parts = explode("\\", $className);
		$className = end($parts);

		$paths = [
			YANE_DIR_INTERFACES,
			YANE_DIR_DRIVER_POSTGRESQL,
			YANE_DIR_DRIVER_MariaDB,
			YANE_DIR_DRIVER_MSSQL
		];

		foreach ($paths as $path) {
			$file = $path . DIRECTORY_SEPARATOR . $className . '.php';
			if (is_file($file)) {
				require_once $file;
				break;
			}
		}
	}
}
