<?php

/**
 * Description of 
 * @package   CueBlocks_PopUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Block_Adminhtml_PopUp_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Init container
     */
    public function _construct()
    {
        parent::_construct();
        $this->_objectId = 'popup_id';
        $this->_blockGroup = 'popUp';
        $this->_controller = 'adminhtml_popUp';
    }

    /**
     * Getter
     *
     * @return Mage_Widget_Model_Widget_Instance
     */
    public function getInstance()
    {
        return Mage::registry('current_popup_instance');
    }

    /**
     * Prepare layout.
     * Adding save_and_continue button
     *
     * @return Mage_Widget_Block_Adminhtml_Widget_Instance_Edit
     */
    protected function _preparelayout()
    {
        if ($this->getInstance()->getId()) {
            $this->_addButton(
                'save_and_edit_button',
                array(
                    'label'     => Mage::helper('widget')->__('Save and Continue Edit'),
                    'class'     => 'save',
                    'onclick'   => 'saveAndContinueEdit()'
                ),
                100
            );
        }
        return parent::_prepareLayout();
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->getInstance()->getId()) {
            return Mage::helper('popUp')->__('Edit Popup');
        } else {
            return Mage::helper('popUp')->__('New Popup');
        }
    }

    /**
     * Return save url for edit form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true, 'back'     => null));
    }

    /**
     * Return validation url for edit form
     *
     * @return string
     */
    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

}
