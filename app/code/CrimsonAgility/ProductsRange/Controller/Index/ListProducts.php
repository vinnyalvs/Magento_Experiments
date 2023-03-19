<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Controller\Customer\Account;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class ListProducts implements HttpGetActionInterface
{


    public function __construct(
        private readonly PageFactory $resultPageFactory
    ) {

    }//end __construct()


    /**
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->resultPageFactory->create();

    }//end execute()


}//end class
