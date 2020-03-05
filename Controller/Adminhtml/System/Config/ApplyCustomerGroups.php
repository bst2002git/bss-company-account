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
namespace Bss\CompanyAccount\Controller\Adminhtml\System\Config;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ApplyCustomerGroups
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\System\Config
 */
class ApplyCustomerGroups extends Action
{
    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterfaceFactory
     */
    private $customerRepositoryFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ApplyCustomerGroups constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CustomerFactory $customerFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param JsonFactory $jsonFactory
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        JsonFactory $jsonFactory,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->customerRepositoryFactory = $customerRepositoryFactory->create();
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->jsonFactory = $jsonFactory;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $groups = $this->getRequest()->getParam('groupIds');

        $this->searchCriteriaBuilder->addFilters(
            array_map(
                function (string $id): Filter {
                    return $this->filterBuilder->setField('group_id')->setValue($id)->create();
                },
                $groups
            )
        );

        $searchFilter = $this->searchCriteriaBuilder;
        $customers = $this->customerRepositoryFactory
            ->getList($searchFilter->create())
            ->getItems();
        if (empty($customers)) {
            $jsonResult = $this->jsonFactory->create();
            $data['status'] = 'warning';
            $data['message'] = __('There are no record affected.');
            $jsonResult->setData($data);
            return $jsonResult;
        }

        try {
            $countFlag = 0;
            foreach ($customers as $customer) {
                $customer->setCustomAttribute('bss_is_company_account', 1);
                if ($this->customerRepositoryFactory->save($customer)) {
                    $email = $customer->getEmail();
                    $this->inlineTranslation->suspend();
                    $storeId = $this->storeManager->getStore()->getId();
//                    $vars = [
//                        'name' => $customer->get
//                    ]
                    $countFlag++;
                }
            }
            $jsonResult = $this->jsonFactory->create();
            $data['status'] = 'success';
            $data['message'] = __('There are %1 record(s) affected.', $countFlag);
            $jsonResult->setData($data);
            return $jsonResult;
        } catch (\Exception $e) {
            $jsonResult = $this->jsonFactory->create();
            $data['status'] = 'error';
            $data['message'] = __('Opps... Some thing wrong! Please try again.');
            $jsonResult->setData($data);
            return $jsonResult;
        }
    }
}
