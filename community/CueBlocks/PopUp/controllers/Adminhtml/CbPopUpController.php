<?php

/**
 * Description of popUpController
 * @package   CueBlocks_popUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Adminhtml_CbPopUpController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/popUp');
    }

    /**
     * Init actions
     *
     * @return Mage_Adminhtml_PopupController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('cms/popUp')
            ->_addBreadcrumb(Mage::helper('popUp')->__('CMS'),
                Mage::helper('widget')->__('CMS'))
            ->_addBreadcrumb(Mage::helper('popUp')->__('Manage PopUp Instances'),
                Mage::helper('popUp')->__('Manage PopUp Instances'));
        return $this;
    }

    protected function _initInstance()
    {
        $this->_title($this->__('CMS'))->_title($this->__('Popup'));

        /** @var $instance CueBlocks_PopUp_Model_PopUp */
        $instance = Mage::getModel('popUp/popUp');

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('popup_id');

        // 2. Initial checking
        if ($id) {
            $instance->load($id);
            if (!$instance->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('popUp')->__('This popup no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        Mage::register('current_popup_instance', $instance);
        return $instance;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }

        $this->_title($this->__('CMS'))->_title($this->__('Pop Up'));
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * Ajax action for billing agreements
     *
     */
    public function gridAction()
    {
        $this->loadLayout(false)
            ->renderLayout();
    }

    /**
     * Create new popup
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit popup
     */
    public function editAction()
    {
        $instance = $this->_initInstance();
        if (!$instance) {
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($instance->getId() ? $instance->getTitle() : $this->__('New Popup'));

        // 5. Build edit form
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $instance = $this->_initInstance();
        if (!$instance) {
            $this->_redirect('*/*/');
            return;
        }

        $data = $this->getRequest()->getPost();

        $instance->setTitle($this->getRequest()->getPost('title'))
            ->setStoreIds($this->getRequest()->getPost('store_ids', array(0)))
            ->setSortOrder($this->getRequest()->getPost('sort_order', 0))
            ->setPageGroups($this->getRequest()->getPost('widget_instance'))
            ->setWidgetParameters($this->getRequest()->getPost('parameters'));

        // init model and set data
        try {
            $instance->save();
            $this->_getSession()->addSuccess(
                Mage::helper('widget')->__('The widget instance has been saved.')
            );
            if ($this->getRequest()->getParam('back', false)) {
                $this->_redirect('*/*/edit', array(
                    'instance_id' => $instance->getId(),
                    '_current' => true
                ));
            } else {
                $this->_redirect('*/*/');
            }
            return;
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($this->__('An error occurred during saving a widget: %s', $e->getMessage()));
        }
        $this->_redirect('*/*/edit', array('_current' => true));
    }

    /**
     * Validate action
     *
     */
    public function validateAction()
    {
        $response = new Varien_Object();
        $response->setError(false);
        $instance = $this->_initInstance();
        $result = true;//$instance->validate();
        if ($result !== true && is_string($result)) {
            $this->_getSession()->addError($result);
            $this->_initLayoutMessages('adminhtml/session');
            $response->setError(true);
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }
        $this->setBody($response->toJson());
    }

    /**
     * Delete Action
     *
     */
    public function deleteAction()
    {
        $instance = $this->_initIstance();
        if ($instance) {
            try {
                $instance->delete();
                $this->_getSession()->addSuccess(
                    Mage::helper('widget')->__('The popup instance has been deleted.')
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
        return;
    }

    /**
     * Set body to response
     *
     * @param string $body
     */
    private function setBody($body)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($body);
        $this->getResponse()->setBody($body);
    }

    /**
     * Categories chooser Action (Ajax request)
     *
     */
    public function categoriesAction()
    {
        $selected = $this->getRequest()->getParam('selected', '');
        $isAnchorOnly = $this->getRequest()->getParam('is_anchor_only', 0);
        $chooser = $this->getLayout()
            ->createBlock('adminhtml/catalog_category_widget_chooser')
            ->setUseMassaction(true)
            ->setId(Mage::helper('core')->uniqHash('categories'))
            ->setIsAnchorOnly($isAnchorOnly)
            ->setSelectedCategories(explode(',', $selected));
        $this->setBody($chooser->toHtml());
    }

    /**
     * Products chooser Action (Ajax request)
     *
     */
    public function productsAction()
    {
        $selected = $this->getRequest()->getParam('selected', '');
        $productTypeId = $this->getRequest()->getParam('product_type_id', '');
        $chooser = $this->getLayout()
            ->createBlock('adminhtml/catalog_product_widget_chooser')
            ->setName(Mage::helper('core')->uniqHash('products_grid_'))
            ->setUseMassaction(true)
            ->setProductTypeId($productTypeId)
            ->setSelectedProducts(explode(',', $selected));
        /* @var $serializer Mage_Adminhtml_Block_Widget_Grid_Serializer */
        $serializer = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
        $serializer->initSerializerBlock($chooser, 'getSelectedProducts', 'selected_products', 'selected_products');
        $this->setBody($chooser->toHtml().$serializer->toHtml());
    }

    /**
     * Blocks Action (Ajax request)
     *
     */
    public function blocksAction()
    {
        /* @var $instance age_Widget_Model_Widget_Instance */
        $instance = $this->_initInstance();
        $layout = $this->getRequest()->getParam('layout');
        $selected = $this->getRequest()->getParam('selected', null);
        $blocksChooser = $this->getLayout()
            ->createBlock('widget/adminhtml_widget_instance_edit_chooser_block')
            ->setArea($instance->getArea())
            ->setPackage($instance->getPackage())
            ->setTheme($instance->getTheme())
            ->setLayoutHandle($layout)
            ->setSelected($selected)
            ->setAllowedBlocks($instance->getWidgetSupportedBlocks());
        $this->setBody($blocksChooser->toHtml());
    }

    /**
     * Templates Chooser Action (Ajax request)
     *
     */
    public function templateAction()
    {
        /* @var $instance age_Widget_Model_Widget_Instance */
        $instance = $this->_initInstance();
        $block = $this->getRequest()->getParam('block');
        $selected = $this->getRequest()->getParam('selected', null);
        $templateChooser = $this->getLayout()
            ->createBlock('widget/adminhtml_widget_instance_edit_chooser_template')
            ->setSelected($selected)
            ->setWidgetTemplates($instance->getWidgetSupportedTemplatesByBlock($block));
        $this->setBody($templateChooser->toHtml());
    }
}
