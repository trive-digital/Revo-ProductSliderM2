<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Block;

use Trive\Revo\Model\ProductSlider;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {

    /**
     * Config path to enable extension
     */
    const XML_PATH_PRODUCT_SLIDER_STATUS = "productslider/general/enable_productslider";

    protected $swatchesVld = false;
    protected $ajaxcartVld = false;

    /**
     * Main template container
     */
    protected $_template = 'Trive_Revo::slider.phtml';

    /**
     * Product slider collection factory
     *
     * @var \Trive\Revo\Model\ResourceModel\ProductSlider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
    * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layoutConfig;

    /**
    * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Trive\Revo\Model\ResourceModel\ProductSlider\CollectionFactory $sliderCollectionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Trive\Revo\Model\ResourceModel\ProductSlider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Registry $registry,
        array $data = []
    ){
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_layoutConfig = $context->getLayout();
        $this->_coreRegistry = $registry;
        parent::__construct($context,$data);
    }

    /**
     * Initialize slider if there is a widget slider active
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        if($this->getData('widget_slider_id')){
            $this->setSliderLocation(null);
        }
    }

    /**
     * Render block HTML
     * if extension is enabled then render HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if($this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_STATUS,\Magento\Store\Model\ScopeInterface::SCOPE_STORES)){
            return parent::_toHtml();
        }
        return false;
    }


    public function setSliderLocation($location, $hide = false){
        $todayDateTime = $this->_localeDate->date()->format('Y-m-d H:i:s');
        $widgetSliderId = $this->getData('widget_slider_id');

        $cartHandles = ['0'=>'checkout_cart_index'];
        $checkoutHandles = ['0'=>'checkout_index_index','1'=>'checkout_onepage_failure', "2"=>'checkout_onepage_success'];
        $currentHandles = $this->_layoutConfig->getUpdate()->getHandles();


        // Get data without start/end time
        /**
         *  @var \Trive\Revo\Model\ResourceModel\ProductSlider\Collection $sliderCollection
         */
        $sliderCollection = $this->_sliderCollectionFactory->create();
        $sliderCollection->setStoreFilters($this->_storeManager->getStore()->getId());

        $sliderCollection->addFieldToFilter('status',ProductSlider::STATUS_ENABLED)
            ->addFieldToFilter('start_time',['null' => true])
            ->addFieldToFilter('end_time',['null' => true]);

        // Check to exclude from cart page
        if(array_intersect($cartHandles,$currentHandles)){
            $sliderCollection->addFieldToFilter('exclude_from_cart',0);
        }

        // Check to exclude from checkout
        if(array_intersect($checkoutHandles,$currentHandles)){
            $sliderCollection->addFieldToFilter('exclude_from_checkout',0);
        }

        // If widget_slider_id is not null
        if($widgetSliderId){
            $sliderCollection->addFieldToFilter('trs.slider_id',$widgetSliderId);
        } else {
            $sliderCollection->addFieldToFilter('location',$location);
        }

        // Get data with start/end time
        /**
         *  @var \Trive\Revo\Model\ResourceModel\ProductSlider\Collection $sliderCollectionTimer
         */
        $sliderCollectionTimer = $this->_sliderCollectionFactory->create();
        $sliderCollectionTimer->setStoreFilters($this->_storeManager->getStore()->getId());

        $sliderCollectionTimer->addFieldToFilter('status',ProductSlider::STATUS_ENABLED)
            ->addFieldToFilter('start_time', ['lteq' => $todayDateTime ])
            ->addFieldToFilter('end_time',
                                [
                                    'or' => [
                                        0 => ['date' => true, 'from' => $todayDateTime],
                                        1 => ['is' => new \Zend_Db_Expr('null')],
                                    ]
                                ]);

        // Check to exclude from cart page
        if(array_intersect($cartHandles,$currentHandles)){
            $sliderCollectionTimer->addFieldToFilter('exclude_from_cart',0);
        }

        // Check to exclude from checkout
        if(array_intersect($checkoutHandles,$currentHandles)){
            $sliderCollectionTimer->addFieldToFilter('exclude_from_checkout',0);
        }

        if($widgetSliderId){
            $sliderCollectionTimer->addFieldToFilter('trs.slider_id',$widgetSliderId);
        } else {
            $sliderCollectionTimer->addFieldToFilter('location',$location);
        }

        $this->setSlider($sliderCollection);
        $this->setSlider($sliderCollectionTimer);
    }

    /**
     *  Add child sliders block
     *
     * @param \Trive\Revo\Model\ResourceModel\ProductSlider\Collection $sliderCollection
     *
     * @return $this
     */
    public function setSlider($sliderCollection)
    {
        foreach($sliderCollection as $slider):
            $this->_coreRegistry->unregister('slider_id');
            $this->_coreRegistry->register('slider_id',$slider->getId());

            $this->_coreRegistry->unregister('enable_swatches');
            if($slider->getEnableSwatches()){
                $this->_coreRegistry->register('enable_swatches',1);
                $this->swatchesVld = true;
            }

            if($slider->getEnableAjaxcart()){
                $this->ajaxcartVld = true;
            }

            $this->append($this->getLayout()
                                ->createBlock('\Trive\Revo\Block\Slider\Items')
                                ->setSlider($slider));
        endforeach;

        $this->addSwatchesCss();
        $this->addAjaxCartJs();
        return $this;
    }


    public function addSwatchesCss()
    {
        if(!$this->swatchesVld){
            return false;
        }

        $swatchesHandles = ['0'=>'catalog_category_view',
                            '1'=>'catalogsearch_advanced_result',
                            "2"=>'catalogsearch_result_index'
                            ];

        $currentHandles = $this->_layoutConfig->getUpdate()->getHandles();

        if(!$this->getLayout()->getBlock("swatches-css")){
            if(!array_intersect($swatchesHandles,$currentHandles)){
                $block = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template', 'swatches-css')
                        ->setTemplate('Trive_Revo::swatches/css.phtml');
                $this->getLayout()->setChild('head.additional',$block->getNameInlayout(),'swatches-css');
            }
        }
    }

    public function addAjaxCartJs()
    {
        if(!$this->ajaxcartVld){
            return false;
        }

        $swatchesHandles = ['0'=>'catalog_category_view',
                            '1'=>'catalogsearch_advanced_result',
                            "2"=>'catalogsearch_result_index'
                            ];

        $currentHandles = $this->_layoutConfig->getUpdate()->getHandles();

        if(!$this->getLayout()->getBlock("ajaxcart-js")){
            if(!array_intersect($swatchesHandles,$currentHandles)){
                $block = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template', 'ajaxcart-js')
                        ->setTemplate('Trive_Revo::ajax/js.phtml');
                $this->getLayout()->setChild('content',$block->getNameInlayout(),'ajaxcart-js');
            }
        }
    }

}