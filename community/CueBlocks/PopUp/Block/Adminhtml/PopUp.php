<?php

/**
 * Description of 
 * @package   CueBlocks_PopUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 * 
 */
class CueBlocks_PopUp_Block_Adminhtml_PopUp extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        // Used to Generate Grid file/class name
        // $this->_blockGroup/$this->_controller_ . 'grid'
        $this->_blockGroup = 'popUp';
        $this->_controller = 'adminhtml_popUp';

        $this->_headerText = Mage::helper('popUp')->__('Manage PopUp');
        $this->_addButtonLabel = Mage::helper('popUp')->__('Add PopUp');

        parent::__construct();
    }

}
