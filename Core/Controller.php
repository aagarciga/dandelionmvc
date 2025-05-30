<?php

namespace Dandelion\MVC\Core;

use Dandelion\MVC\Core\Nomenclatures\ApplicationState;

require_once MVC_DIR_CORE . DIRECTORY_SEPARATOR . 'Request.php';
require_once MVC_DIR_CORE_INTERFACES . DIRECTORY_SEPARATOR . 'INameable.php';
require_once MVC_DIR_CORE_NOMENCLATURES . DIRECTORY_SEPARATOR . 'ApplicationState.php';


/**
 * Dandelion MVC main controller concept.
 *
 * @author    Alex Alvarez Gárciga <aagarciga@gmail.com>
 * @copyright 2011-2025 Alex Alvarez Gárciga / Wishware LLC
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      
 * @ignore
 */
abstract class Controller implements Interfaces\INameable {

    /**
     *
     * @var string
     */
    private $name;

    /**
     * 
     * @param string $name
     */
    function __construct($name) {
        $this->name = ucfirst($name);
    }

    /**
     * 
     * @return string
     * @ignore
     */
    public function __toString() {
        return $this->name;
    }

    /**
     * 
     * @param \Dandelion\MVC\Core\Request $request
     */
    public abstract function Dispatch(Request $request);

    /**
     * Redirect to the controller action especified in the request object parameter.
     * 
     * @param \Dandelion\MVC\Core\Request $request
     * @throws Exceptions\ControllerNotFoundException
     */
    public final function Redirect(Request $request) {
           //e.g. Default
        $controllerName = ucfirst($request->Controller);
      
        //e.g. Application/Controller/Default/Default.Controller.php
        $classFile = MVC_DIR_APP_CONTROLLERS . DIRECTORY_SEPARATOR . $controllerName . DIRECTORY_SEPARATOR . $controllerName . '.php';

        if (!is_file($classFile)) {

            if ($request->Application->getState() == ApplicationState::Development()) {
                throw new Exceptions\ControllerNotFoundException($controllerName);
                //TODO: Debug error information 
            } else {
                header("Status: 404 Not Found");
            }
        }

        require_once $classFile;

        $class = "Dandelion\\MVC\\Application\\Controllers\\$controllerName";

        if (!class_exists($class)) {
            if ($request->Application->getState() == ApplicationState::Development()) {
                throw new Exceptions\ControllerNotFoundException($controllerName);
                //TODO: Debug error information.
            } else {
                header("Status: 404 Not Found");
            }
        }

//        $controller = new $class($request->Controller);
        $controller = new $class($request);

        $controller->PreController($request);
        $controller->PreControllerInvocation($request);
        $controller->PostController($request);
        $controller->PostControllerInvocation($request);
    }

    /**
     * 
     * @param \Dandelion\MVC\Core\Request $request
     */
    protected function PreController(Request $request) {
        ;
    }

    /**
     * 
     * @param \Dandelion\MVC\Core\Request $request
     */
    protected function PostController(Request $request) {
        ;
    }
    
    /**
     * 
     * @param \Dandelion\MVC\Core\Request $request
     */
    private function PreControllerInvocation(Request $request){
        $this->Dispatch($request);
    }
    
    /**
     * 
     * @param \Dandelion\MVC\Core\Request $request
     * @throws Exceptions\SystemExit
     */
    private function PostControllerInvocation(Request $request){
        unset($request);
        throw new Exceptions\SystemExit(); //Finish script execution cleanly
    }

}
