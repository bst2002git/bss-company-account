<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_CompanyAccount
 * @author     Extension Team
 * @copyright  Copyright (c) 2020 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\CompanyAccount\Controller\Adminhtml\Abstracts;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class AbstractMassAction
 */
abstract class AbstractMassAction extends \Magento\Backend\App\Action
{
    public function execute()
    {
        try {
            $this->massAction();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }

    /**
     * Set status to collection items
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|ResultInterface
     */
    abstract protected function massAction(AbstractCollection $collection);
}
