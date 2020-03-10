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
namespace Bss\CompanyAccount\Ui\Component\Customer\Form;

use Magento\Framework\View\Element\ComponentVisibilityInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class ManageRoleFieldSet
 *
 * @package Bss\CompanyAccount\Ui\Component\Customer\Form
 */
class ManageRoleFieldSet extends \Magento\Ui\Component\Form\Fieldset implements ComponentVisibilityInterface
{
    const IS_COMPANY_ACCOUNT = 1;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param ContextInterface $context
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->context = $context;

        parent::__construct($context, $components, $data);
    }

    /**
     * Can show customer addresses tab in tabs or not
     *
     * Will return false for not registered customer in a case when admin user created new customer account.
     * Needed to hide addresses tab from create new customer page
     *
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isComponentVisible(): bool
    {
        $customerId = $this->context->getRequestParam('id');
        $customer = $this->customerRepository->getById($customerId);
        $companyAccountAttr = $customer->getCustomAttribute('bss_is_company_account');
        if ($companyAccountAttr) {
            return (int)$companyAccountAttr->getValue() === self::IS_COMPANY_ACCOUNT;
        }
        return false;
    }
}
