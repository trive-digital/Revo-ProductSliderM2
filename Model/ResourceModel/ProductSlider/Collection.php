<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Model\ResourceModel\ProductSlider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * Initialize resources
     * @return void
     */
    protected function _construct(){
        $this->_init('Trive\Revo\Model\ProductSlider','Trive\Revo\Model\ResourceModel\ProductSlider');
    }

    public function setStoreFilters($storeId)
    {
        $stores = [\Magento\Store\Model\Store::DEFAULT_STORE_ID, $storeId];
        $this->getSelect()
            ->joinLeft(['trs' => $this->getTable(\Trive\Revo\Model\ResourceModel\ProductSlider::SLIDER_STORES_TABLE)],
                        'main_table.slider_id = trs.slider_id',
                        [])
            ->where('trs.store_id IN (?)', $stores);
    }

}