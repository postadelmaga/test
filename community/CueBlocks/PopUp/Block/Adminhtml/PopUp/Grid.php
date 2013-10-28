<?php

/**
 * Description of 
 * @package   CueBlocks_PopUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Block_Adminhtml_PopUp_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setUseAjax(true);
        $this->setId('popUpGrid');
        $this->setDefaultSort('popup_id');

        $urlNew    = $this->getUrl('*/popUp/new');
        $urlConfig = $this->getUrl('*/system_config/edit/section/popUp');

        $this->_emptyText = Mage::helper('adminhtml')->__('No XML Popups to show here. <br /> You can add a popup by clicking on <a href="' . $urlNew . '">\'Add Popup\'</a>, which will create XML Popups based on the default configuration setting of this extenion. <br /> If you want to change the default settings, please go to <a href="' . $urlConfig . '">\'Configuration\'</a> and make the desired changes');
    }

    /**
     * Prepare collection for grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('popUp/popUp')->getCollection();
        /* @var $collection Mage_PopUp_Model_Mysql4_PopUp_Collection */

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('popUp')->__('ID'),
            'index'  => 'id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('popUp')->__('Title'),
            'index'  => 'title',
        ));

        $this->addColumn('date_from', array(
            'header' => Mage::helper('popUp')->__('Valid From'),
            'index'  => 'date_from',
            'type'   => 'datetime',
        ));

        $this->addColumn('date_to', array(
            'header' => Mage::helper('popUp')->__('Valid To'),
            'index'  => 'date_to',
            'type'   => 'datetime',
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('popUp')->__('Active'),
            'index'  => 'is_active',
//            'type'   => 'datetime',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_ids', array(
                'header' => Mage::helper('popUp')->__('Store View'),
                'index'  => 'store_ids',
                'type'   => 'store',
            ));
        }

        $this->addColumn('action', array(
            'header'   => Mage::helper('popUp')->__('Action'),
            'filter'   => false,
            'sortable' => false,
            'renderer' => 'popUp/adminhtml_popUp_grid_renderer_action'
        ));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('popup_id' => $row->getId()));
    }

}
