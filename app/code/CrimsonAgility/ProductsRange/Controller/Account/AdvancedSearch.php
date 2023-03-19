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
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var UrlInterface
     */
    private UrlInterface $url;

    /**
     * Products By Range Controller constructor
     *
     * @param PageFactory $resultPageFactory
     * @param Session $session
     * @param UrlInterface $url
     */
    public function __construct(
        PageFactory $resultPageFactory,
        Session $session,
        UrlInterface $url
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->session = $session;
        $this->url = $url;
    }

    /**
     * @return ResultInterface
     * @throws \Magento\Framework\Exception\SessionException
     */
    public function execute(): ResultInterface
    {
        return $this->resultPageFactory->create();
    }
}
