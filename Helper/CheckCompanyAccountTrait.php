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
namespace Bss\CompanyAccount\Helper;

use Bss\CompanyAccount\Model\Config\Source\CompanyAccountValue;

/**
 * Trait CheckCompanyAccountTrait
 *
 * @package Bss\CompanyAccount\Helper
 */
trait CheckCompanyAccountTrait
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CheckCompanyAccountTrait constructor.
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * True if customer is company account
     *
     * @param int $customerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isCompanyAccount($customerId)
    {
        $customer = $this->customerRepository->getById($customerId);
        $companyAccountAttr = $customer->getCustomAttribute('bss_is_company_account');
        if ($companyAccountAttr) {
            return (int)$companyAccountAttr->getValue() === CompanyAccountValue::IS_COMPANY_ACCOUNT;
        }
        return false;
    }
}
