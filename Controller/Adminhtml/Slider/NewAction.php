<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Controller\Adminhtml\Slider;

class NewAction extends \Trive\Revo\Controller\Adminhtml\Slider
{
    /**
     * Create new slider action
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute(){
        //Forward to the edit action
        $resultForward = $this->_resultForwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }
}