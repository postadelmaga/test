    <?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Widget
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Widget Instance Settings tab block
 *
 * @category    Mage
 * @package     Mage_Widget
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class CueBlocks_PopUp_Block_Adminhtml_PopUp_Edit_Tab_Settings
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setActive(true);
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('popUp')->__('Settings');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('popUp')->__('Settings');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
//        return !(bool)$this->getInstance()->isCompleteToCreate();
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
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
     * Prepare form before rendering HTML
     *
     * @return Mage_Widget_Block_Adminhtml_Widget_Instance_Edit_Tab_Settings
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('current_popup_instance');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('add_popup_form', array('legend' => Mage::helper('popUp')->__('Popup')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('popUp')->__('Title:'),
            'name' => 'title',
            'required' => true,
//            'after_element_html' => '<div id="row_popUp_general_useindex_comment" class="system-tooltip-box" style="height: 166px; display: none; ">fsfsdfsdfsd</div>',
            'value' => $model->getTitle()
        ));

        $fieldset->addField('content', 'text', array(
            'label' => Mage::helper('popUp')->__('Content:'),
            'name' => 'content',
            'required' => true,
            'value' => $model->getContent()
        ));

        $fieldset->addField('controller', 'text', array(
            'label' => Mage::helper('popUp')->__('Controller:'),
            'name' => 'controller',
            'required' => true,
            'value' => $model->getController()
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'select', array(
                'label' => Mage::helper('popUp')->__('Store View:'),
                'title' => Mage::helper('popUp')->__('Store View'),
                'name' => 'store_id',
                'required' => true,
                'value' => $model->getStoreId(),
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm()
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'store_id',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('legend', 'note', array(
            'name' => 'legend',
            'label' => Mage::helper('popUp')->__('Legend:'),
            'note' => Mage::helper('adminhtml')->__('<span class="required">*</span> required fields.'),

        ));

        $fieldset->addField('generate', 'hidden', array(
            'name' => 'generate',
            'value' => ''
        ));

        $form->setValues($model->getData());
//            ->setUseContainer(true);

        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Return url for continue button
     *
     * @return string
     */
    public function getContinueUrl()
    {
        return $this->getUrl('*/*/*', array(
            '_current'  => true,
            'type'      => '{{type}}',
            'package'   => '{{package}}',
            'theme'     => '{{theme}}'
        ));
    }

    /**
     * Retrieve array (widget_type => widget_name) of available widgets
     *
     * @return array
     */
    public function getTypesOptionsArray()
    {
        $instance = $this->getInstance()->getWidgetsOptionArray();
        array_unshift($widgets, array(
            'value' => '',
            'label' => Mage::helper('widget')->__('-- Please Select --')
        ));
        return $widgets;
    }

    /**
     * User-defined widgets sorting by Name
     *
     * @param array $a
     * @param array $b
     * @return boolean
     */
    protected function _sortWidgets($a, $b)
    {
        return strcmp($a["label"], $b["label"]);
    }

    /**
     * Retrieve package/theme options array
     *
     * @return array
     */
    public function getPackegeThemeOptionsArray()
    {
        return Mage::getModel('core/design_source_design')
            ->setIsFullLabel(true)->getAllOptions(true);
    }
}
