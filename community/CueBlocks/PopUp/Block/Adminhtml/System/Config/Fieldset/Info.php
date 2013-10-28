<?php

/**
 * Description of Logo
 * @package   CueBlocks_PopUp
 * @company    CueBlocks - http://www.cueblocks.com/
 * @author    Francesco Magazzu' <francesco.magazzu at cueblocks.com>
 */

/**
 * Renderer for CueBlocks banner in System Configuration
 * 
 */
class CueBlocks_PopUp_Block_Adminhtml_System_Config_Fieldset_Info
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_template = 'popupenhanced/system/config/fieldset/info.phtml';

    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->toHtml();
    }
}

?>
