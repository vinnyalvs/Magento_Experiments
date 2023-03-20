<?php

declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class AdvancedSearch implements HttpGetActionInterface
{
    /**
     * Products By Range Controller constructor
     *
     * @param PageFactory $resultPageFactory
     * @param Session $session
     * @param UrlInterface $url
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly Session $session,
        private readonly UrlInterface $url
    ) {
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->resultPageFactory->create();
    }
}
