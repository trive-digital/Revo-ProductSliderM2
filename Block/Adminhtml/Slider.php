<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Block\Adminhtml;

class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Modify header & button labels
     *
     * @return void
     */
    protected function _construct(){
        $this->_blockGroup = 'Trive_Revo';
        $this->_controller = 'adminhtml';
        $this->_headerText = 'Slider';
        $this->_addButtonLabel = __('Create New Slider');
        parent::_construct();
    }

}