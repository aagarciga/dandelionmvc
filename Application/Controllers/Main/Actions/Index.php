<?php
/**
 * Project:  VFP Business Series
 * Copyright: 2014. VFP Business Solutions, LLC
 */

namespace Dandelion\MVC\Application\Controllers\Main\Actions;

use Dandelion\MVC\Core\Action;
use Helpers;

/**
 * VFP Business Series Default Controller Action
 * @name Index
 */
class Index extends Action {

    /**
     * Default system page. Show Main menu.
     */
    public function Execute() {
        $this->Title = 'Dandelion MVC';
        $this->HelperResult = Helpers::HelperMethod1() . " in Action";
        //$this->UserName = (!isset($_SESSION['username']))? 'Anonimous' : $_SESSION['username'];
    }

    /**
     * Return the HTML LI collection of Main entries from
     * configuration settings.xml ready for put inside an HTML UL element.
     * @return string
     */
    private function getMainPanelEntries(){
        $result = "";
        $application = $this->Request->Application;

        return $result;
    }
}

?>
