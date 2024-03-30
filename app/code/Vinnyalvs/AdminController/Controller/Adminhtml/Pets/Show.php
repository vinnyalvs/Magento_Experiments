<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2023 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */
declare(strict_types=1);

namespace Vinnyalvs\AdminController\Controller\Adminhtml\Pets;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

class Show implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'VinnyAlvs_AdminController::menu';

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
    }
}
