<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Controller\Adminhtml\Slider;

class Grid extends \Trive\Revo\Controller\Adminhtml\Slider
{
    /**
     * Prevent entire page loading
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}