<?php

class CueBlocks_PopUp_Block_Adminhtml_PopUp_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareLayout() {
        // include custom gallery js, cannot be done
        // in tab block because it will be rendered after 'head' block.
        // better approach would be in the layout file
//        $this->getLayout()->getBlock('head')->addJs('cbslider/gallery.js');
        parent::_prepareLayout();
    }

    protected function _prepareForm() {

        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}