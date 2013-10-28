<?php

/**
 * Description of PopUp
 * @package   CueBlocks_PopUp
 * @company   CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */
class CueBlocks_PopUp_Model_PopUp extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('popUp/popUp');
    }
    /**
     * Processing object before save data
     *
     * @return Mage_Widget_Model_Widget_Instance
     */
    protected function _beforeSave()
    {
        $pageGroupIds = array();
        $tmpPageGroups = array();
        $pageGroups = $this->getData('page_groups');

        if (is_array($this->getData('store_ids'))) {
            $this->setData('store_ids', implode(',', $this->getData('store_ids')));
        }
//        if (is_array($this->getData('widget_parameters'))) {
//            $this->setData('widget_parameters', serialize($this->getData('widget_parameters')));
//        }
//        $this->setData('page_groups', $tmpPageGroups);
//        $this->setData('page_group_ids', $pageGroupIds);

        return parent::_beforeSave();
    }

    /**
     * Getter
     * Explode to array if string setted
     *
     * @return array
     */
    public function getStoreIds()
    {
        if (is_string($this->getData('store_ids'))) {
            return explode(',', $this->getData('store_ids'));
        }
        return $this->getData('store_ids');
    }
}
