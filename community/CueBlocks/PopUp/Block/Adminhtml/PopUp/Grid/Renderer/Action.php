<?php

/**
 * Description of 
 * @package   CueBlocks_PopUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Block_Adminhtml_PopUp_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

    public function render(Varien_Object $row)
    {
        /* @var $row CueBlocks_PopUp_Model_PopUp */
        
        $this->getColumn()->setActions(
                array(
                  array(
                        'url' => $this->getUrl('*/popUp/generate', array('id' => $row->getId())),
                        'caption'    => Mage::helper('popUp')->__('Generate'),
                        'confirm'    => Mage::helper('adminhtml')->__('Are you sure you want to update/generate this XML Popup?'),
                    )
                    , array(
                        'url' => $this->getUrl('*/cbPopUp/delete', array('id' => $row->getId())),
                        'caption'    => Mage::helper('popUp')->__('Delete'),
                        'confirm'    => Mage::helper('adminhtml')->__('Are you sure you want to delete this Popup?'),
                    )
                )
        );
        return parent::render($row);
    }

}
