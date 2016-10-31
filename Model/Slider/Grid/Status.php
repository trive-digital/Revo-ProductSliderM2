<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Model\Slider\Grid;

class Status implements \Magento\Framework\Option\ArrayInterface {

    /**
     * To option slider statuses array
     * @return array
     */
    public function toOptionArray(){
        return \Trive\Revo\Model\ProductSlider::getStatusArray();
    }
}