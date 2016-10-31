<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Model\Slider\Grid;

class Type implements \Magento\Framework\Data\OptionSourceInterface{

    /**
     * To option slider types array
     * @return array
     */
    public function toOptionArray(){
        return \Trive\Revo\Model\ProductSlider::getSliderTypeArray();
    }
}