<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Model\ResourceModel;

class ProductSlider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Additional slider products table
     */
    const SLIDER_PRODUCTS_TABLE = 'trive_revo_products';

    /**
     * Slider stores table
     */
    const SLIDER_STORES_TABLE = 'trive_revo_stores';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('trive_revo','slider_id');
    }

    /**
     * Additional (featured) products for current slider
     *
     * @param \Trive\Revo\Model\ProductSlider $slider
     * @return array
     */
    public function getSliderProducts($slider)
    {
        $select = $this->getConnection()->select()->from(
            $this->getTable('trive_revo_products'),
            ['product_id', 'position']
        )->where(
            'slider_id = :slider_id'
        );

        $bind = ['slider_id' => (int)$slider->getSliderId()];

        return $this->getConnection()->fetchPairs($select, $bind);
    }

    /**
     * Additional slider products table getter
     * @return string
     */
    public function getSliderProductsTable()
    {
        return $this->getTable(self::SLIDER_PRODUCTS_TABLE);
    }

    /**
     * Perform actions after object (slider) save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->_updateSliderProducts($object);
        $this->_updateSliderStores($object);
        return parent::_afterSave($object);
    }

    /**
     * Update (save new or delete old) additional slider products
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _updateSliderProducts($slider)
    {
        $id = $slider->getSliderId();

        /**
         * new slider-product relationships
         */
        $products = $slider->getPostedProducts();

        /**
         * Example re-save slider
         */
        if ($products === null) {
            return $this;
        }

        /**
         * old slider-product relationships
         */
        $oldProducts = $slider->getSelectedSliderProducts();

        $insert = array_diff_key($products, $oldProducts);
        $delete = array_diff_key($oldProducts, $products);

        /**
         * Find product ids which are presented in both arrays
         * and saved before (check $oldProducts array)
         */
        $update = array_intersect_key($products, $oldProducts);
        $update = array_diff_assoc($update, $oldProducts);

        $connection = $this->getConnection();

        /**
         * Delete products from slider
         */
        if (!empty($delete)) {
            $condition = ['product_id IN(?)' => array_keys($delete), 'slider_id=?' => $id];
            $connection->delete($this->getSliderProductsTable(), $condition);
        }

        /**
         * Add products to slider
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId => $position) {
                $data[] = [
                    'slider_id' => (int)$id,
                    'product_id' => (int)$productId,
                    'position' => (int)$position,
                ];
            }
            $connection->insertMultiple($this->getSliderProductsTable(), $data);
        }

        /**
         * Update product positions in category
         */
        if (!empty($update)) {
            foreach ($update as $productId => $position) {
                $where = ['slider_id = ?' => (int)$id, 'product_id = ?' => (int)$productId];
                $bind = ['position' => (int)$position];
                $connection->update($this->getSliderProductsTable(), $bind, $where);
            }
        }

        return $this;
    }


    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
//            $object->setData('stores', $stores);
        }

        return parent::_afterLoad($object);
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _updateSliderStores(\Magento\Framework\Model\AbstractModel $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();

        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }

        $table = $this->getTable(self::SLIDER_STORES_TABLE);
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = ['slider_id = ?' => (int)$object->getId(), 'store_id IN (?)' => $delete];

            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = ['slider_id' => (int)$object->getId(), 'store_id' => (int)$storeId];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable(self::SLIDER_STORES_TABLE),
            'store_id'
        )->where(
            'slider_id = :slider_id'
        );

        $binds = [':slider_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }

}