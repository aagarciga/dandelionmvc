<?php

namespace Dandelion\MVC;

define('MVC_VERSION', "1.0.0.64");
/**
 * Dandelion MVC 1.0.0.64
 *
 * PHP Version 8.3.12
 *
 * @author    Alex Alvarez Gárciga <aagarciga@gmail.com>
 * @copyright 2011-2025 Alex Alvarez Gárciga / Wishware LLC
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://www.thedandelionproject.com
 */

/**
 *
 * GLOBAL DEFINITIONS
 */

/**
 * When __DIR__ is not defined, prior 5.3.0
 */
if (!defined('__DIR__')){
	define('__DIR__', dirname(__FILE__));
}

define('MVC_DIR_SERVER', $_SERVER["DOCUMENT_ROOT"]);
define('MVC_DIR_ROOT', __DIR__);

define('URL_SEPARATOR', '/');

define('MVC_DIR_CORE', MVC_DIR_ROOT . DIRECTORY_SEPARATOR . 'Core');
define('MVC_DIR_APP', MVC_DIR_ROOT . DIRECTORY_SEPARATOR . 'Application');
define('MVC_DIR_LIBRARIES', MVC_DIR_ROOT . DIRECTORY_SEPARATOR . 'Libraries');
define('MVC_DIR_PUBLIC', 'Public');

/**
 *
 * CORE DEFINITIONS
 */
define('MVC_DIR_CORE_INTERFACES', MVC_DIR_CORE . DIRECTORY_SEPARATOR . 'Interfaces');
define('MVC_DIR_CORE_NOMENCLATURES', MVC_DIR_CORE . DIRECTORY_SEPARATOR . 'Nomenclatures');

/**
 *
 * APPLICATION DEFINITIONS
 */
define('MVC_DIR_APP_CONTROLLERS', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Controllers');  // Application Controllers
define('MVC_DIR_APP_DATA', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Data');                // Application Configurations
define('MVC_DIR_APP_MODELS', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Models');            // Application Models
define('MVC_DIR_APP_VIEWS', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Views');              // Application Views
define('MVC_DIR_APP_HELPERS', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Helpers');          // Helpers & View Helpers
define('MVC_DIR_APP_LOGIC', MVC_DIR_APP . DIRECTORY_SEPARATOR . 'Logic');              // Business Logic
define('MVC_DIR_APP_VIEWS_SHARED', MVC_DIR_APP_VIEWS . DIRECTORY_SEPARATOR . 'Shared');

/**
 *
 * PUBLIC DEFINITIONS
 */
define('MVC_DIR_PUBLIC_IMAGES', MVC_DIR_PUBLIC . '/' . 'Images');
define('MVC_DIR_PUBLIC_SCRIPTS', MVC_DIR_PUBLIC . '/' . 'Scripts');
define('MVC_DIR_PUBLIC_SHARED', MVC_DIR_PUBLIC . '/' . 'Shared');
define('MVC_DIR_PUBLIC_UPLOADS', MVC_DIR_PUBLIC . '/' . 'Uploads');
define('MVC_DIR_PUBLIC_STYLES', MVC_DIR_PUBLIC . '/' . 'Styles');

define('MVC_DIR_PUBLIC_SHARED_IMAGES', MVC_DIR_PUBLIC_SHARED . '/' . 'Images');
define('MVC_DIR_PUBLIC_SHARED_SCRIPTS', MVC_DIR_PUBLIC_SHARED . '/' . 'Scripts');
define('MVC_DIR_PUBLIC_SHARED_STYLES', MVC_DIR_PUBLIC_SHARED . '/' . 'Styles');

/**
 *
 * SETTINGS DEFINITIONS
 */
define('MVC_SETTINGS_INSTANCE', 'Application');

use Dandelion\MVC\Core;
use Dandelion\MVC\Core\Exceptions;

require_once MVC_DIR_CORE . DIRECTORY_SEPARATOR . 'FrontController.php';
require_once 'Core/Exceptions.Core.php';

/**
 * Front Controller instance for Singleton behavior.
 *
 * @author    Alex Alvarez Gárciga <aagarciga@gmail.com>
 * @copyright 2011-2025 Alex Alvarez Gárciga / Wishware LLC
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      
 */
final class index extends Core\FrontController {

	static private $instance = null;

	/**
	 * Dispatcher Gateway.
	 *
	 * @return \Dandelion\MVC\index
	 */
	public static function Main() {
		header('X-Powered-By: Dandelion MVC');
		header('Author: Alex Alvarez Garciga');

		// For Development Application Mode
		// Reporting E_NOTICE can be good too (to report uninitialized
		// variables or catch variable name misspellings ...)
		//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(E_ALL);

		// For Production Application Mode
		// Report all PHP errors (see changelog)
		//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

		date_default_timezone_set("America/New_York");

		ini_set('odbc.defaultlrl','40960');

		if (self::$instance == null) {
			self::$instance = new index();
			spl_autoload_register(array(self::$instance, 'loader'));
		}

		return self::$instance;
	}

	/**
	 * @internal This function is for Auto Class Loader feature.
	 * @internal Please don't modify.
	 * @internal The Auto Class Loader feature only work for classes in to the
	 *           folder list:
	 *              MVC_DIR_CORE
	 *              MVC_DIR_CORE_INTERFACES
	 *              MVC_DIR_CORE_NOMENCLATURES
	 *              MVC_DIR_APP_CONTROLLERS
	 *              MVC_DIR_APP_LIBRARIES
	 *              MVC_DIR_APP_MODELS
	 * @ignore
	 * @param string $className
	 */
	private function loader(string $className): void
	{
		$parts = explode('\\', $className);
		$className = end($parts);

		$paths = [
			MVC_DIR_CORE,
			MVC_DIR_CORE_INTERFACES,
			MVC_DIR_CORE_NOMENCLATURES,
			MVC_DIR_LIBRARIES,
			MVC_DIR_APP_CONTROLLERS,
			MVC_DIR_APP_MODELS,
			MVC_DIR_APP_HELPERS,
			MVC_DIR_APP_LOGIC,
			MVC_DIR_APP,
		];

		foreach ($paths as $path) {
			$file = $path . DIRECTORY_SEPARATOR . $className . '.php';

			if (is_file($file)) {
				require_once $file;
				break;
			}
		}
		
		if (is_file(MVC_DIR_APP . DIRECTORY_SEPARATOR . $className . '.php'))
		require_once MVC_DIR_APP . DIRECTORY_SEPARATOR . $className . '.php';
	}

	/**
	 * @internal This
	 * @param type $className
	 * @throws Exceptions\ClassNotFoundException
	 */
	public static function throwClassNotFoundException($className){
		throw new Exceptions\ClassNotFoundException($className);
	}
}

/**
 * Calling to exit() will flush all buffers started by ob_start()
 * to default output.
 *
 * If you want to avoid calling exit() in FastCGI, but really,
 * positively want to exit cleanly from nested function call
 * or include, consider doing it the Python way:
 */

try {

	index::Main()->Dispatch();
	spl_autoload_register(__NAMESPACE__ .'\index::throwClassNotFoundException'); // As of PHP 5.3.0
} catch (Exceptions\SystemExit $e) {
	unset($e);
} catch (Exceptions\ClassNotFoundException $e) {
	echo $e->getMessage();
} catch (Exceptions\ConfigurationNotChargedException $e) {
	echo $e->getMessage();
} catch (Exceptions\ControllerNotFoundException $e) {
	echo $e->getMessage();
} catch (Exceptions\ActionNotFoundException $e) {
	echo $e->getMessage();
} catch (Exceptions\ViewNotFoundException $e) {
	echo $e->getMessage();
} catch (\Exception $e) {
	echo $e->getMessage();
}