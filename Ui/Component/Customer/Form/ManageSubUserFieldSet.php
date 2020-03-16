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

use Bss\CompanyAccount\Helper\CheckCompanyAccountTrait;
use Magento\Framework\View\Element\ComponentVisibilityInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class ManageSubUserFieldSet
 *
 * @package Bss\CompanyAccount\Ui\Component\Customer\Form
 */
class ManageSubUserFieldSet extends \Magento\Ui\Component\Form\Fieldset implements ComponentVisibilityInterface
{
    use CheckCompanyAccountTrait {
        CheckCompanyAccountTrait::__construct as private __checkCaConstruct;
    }

    /**
     * ManageSubUserFieldSet constructor.
     *
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
        $this->__checkCaConstruct($customerRepository);
        $this->context = $context;
        parent::__construct($context, $components, $data);
    }

    /**
     * Can show manage role tab in tabs or not
     *
     * Return true if customer is company account
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isComponentVisible(): bool
    {
        $customerId = $this->context->getRequestParam('id');
        if ($customerId) {
            return $this->isCompanyAccount((int)$customerId);
        }
        return false;
    }
}
