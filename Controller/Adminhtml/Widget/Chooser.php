<?php
/**
 * Copyright © 2016 Trive (http://www.trive.digital/) All rights reserved.
 */

namespace Trive\Revo\Controller\Adminhtml\Widget;

class Chooser extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $_layoutFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultRawFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    )
    {
        $this->_layoutFactory = $layoutFactory;
        $this->_resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $layout = $this->_layoutFactory->create();

        $uniqId = $this->getRequest()->getParam('uniq_id');
        $pagesGrid = $layout->createBlock(
            'Trive\Revo\Block\Adminhtml\Block\Widget\Chooser',
            '',
            ['data' => ['id' => $uniqId]]
        );

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->_resultRawFactory->create();

        $resultRaw->setContents($pagesGrid->toHtml());
        return $resultRaw;
    }
}