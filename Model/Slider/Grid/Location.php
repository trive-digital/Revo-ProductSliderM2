<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Model\Slider\Grid;

/**
 * To option slider locations array
 * @return array
 */
class Location implements \Magento\Framework\Option\ArrayInterface{

    public function toOptionArray(){
        return \Trive\Revo\Model\ProductSlider::getSliderGridLocations();
    }
}