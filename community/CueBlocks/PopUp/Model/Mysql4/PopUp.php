<?php

/**
 * Description of PopUp
 * @package   CueBlocks_Popup
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Model_Mysql4_PopUp extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('popUp/popUp', 'id');
    }

}
