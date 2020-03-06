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
namespace Bss\CompanyAccount\Controller\Adminhtml\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassApprovedCompanyAccount
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\System\Config
 */
class MassDisapprovedCompanyAccount extends \Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction
{
    const IS_COMPANY_ACCOUNT = 1;
    const IS_NORMAL_CUSTOMER = 0;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * MassApprovedCompanyAccount constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $filter, $collectionFactory);
    }

    /**
     * @inheritDoc
     */
    protected function massAction(AbstractCollection $collection)
    {
        $updatedCustomerCount = 0;
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection->getAllIds() as $cid) {
            $customer = $this->customerRepository->getById($cid);
            $customer->setCustomAttribute('bss_is_company_account', self::IS_NORMAL_CUSTOMER);
            try {
                $this->customerRepository->save($customer);
                $updatedCustomerCount++;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Customer ID - %1: ' . $e->getMessage(), $cid));
            }
        }
        if ($updatedCustomerCount) {
            // @codingStandardsIgnoreStart
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were updated.', $updatedCustomerCount));
            // @codingStandardsIgnoreEnd
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('customer/index/index');

        return $resultRedirect;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bss_CompanyAccount::config_section');
    }
}
