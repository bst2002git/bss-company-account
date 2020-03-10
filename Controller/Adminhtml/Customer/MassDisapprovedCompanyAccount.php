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
use Bss\CompanyAccount\Helper\SendMailTrait;

/**
 * Class MassApprovedCompanyAccount
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\System\Config
 */
class MassDisapprovedCompanyAccount extends \Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction
{
    use SendMailTrait {
        SendMailTrait::__construct as private __sendMailConstruct;
    }
    const CA_ATTRIBUTE = 'bss_is_company_account';
    const IS_NORMAL_CUSTOMER = 0;
    const IS_COMPANY_ACCOUNT = 1;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var \Bss\CompanyAccount\Helper\GetType
     */
    private $getType;

    /**
     * MassApprovedCompanyAccount constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Bss\CompanyAccount\Helper\Data $helper
     * @param \Bss\CompanyAccount\Helper\GetType $getType
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Bss\CompanyAccount\Helper\Data $helper,
        \Bss\CompanyAccount\Helper\GetType $getType,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->__sendMailConstruct($inlineTranslation, $transportBuilder, $helper);
        $this->getType = $getType;
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
            $isCompanyAcc = (int)$customer
                ->getCustomAttribute(self::CA_ATTRIBUTE)->getValue() === self::IS_COMPANY_ACCOUNT;
            if ($isCompanyAcc) {
                $customer->setCustomAttribute('bss_is_company_account', self::IS_NORMAL_CUSTOMER);
                try {
                    $this->sendMail(
                        $customer->getEmail(),
                        $this->helper->getCaRemoveCopyToEmails(),
                        $this->helper->getCompanyAccountRemoveEmailTemplate(),
                        [
                            'area' => $this->getType->getAreaFrontend(),
                            'store' => $this->getType->getStoreManager()->getStore()->getId(),
                        ],
                        [
                            'name' => $customer->getPrefix() . ' ' . $customer->getLastname()
                        ]
                    );
                    $updatedCustomerCount++;
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('Customer ID - %1: ' . $e->getMessage(), $cid));
                }
            }
        }
        $updatedCustomerCount ? $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were updated.', $updatedCustomerCount)) :
            $this->messageManager->addSuccessMessage(__('No record were updated'));

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
