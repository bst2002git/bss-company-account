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
namespace Bss\CompanyAccount\Plugin\Customer;

use Magento\Framework\AuthorizationInterface;
use Magento\Ui\Component\MassAction;

/**
 * Class AddMassActionButton
 *
 * @package Bss\CompanyAccount\Plugin\Customer
 */
class AddMassActionButton
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @var \Bss\CompanyAccount\Helper\Data
     */
    private $helper;

    /**
     * AddMassActionButton constructor.
     *
     * @param \Bss\CompanyAccount\Helper\Data $helper
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        \Bss\CompanyAccount\Helper\Data $helper,
        AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
        $this->helper = $helper;
    }

    /**
     * Add massaction button
     *
     * @param MassAction $object
     * @param $result
     * @return mixed
     */
    public function afterGetChildComponents(MassAction $object, $result)
    {
        if (!isset($result['company_account_approval']) && !isset($result['company_account_remove'])) {
            return $result;
        }

        if (!$this->helper->isEnable() || !$this->authorization->isAllowed('Bss_CompanyAccount::config_section')) {
            unset($result['company_account_approval']);
            unset($result['company_account_remove']);
        }

        return $result;
    }
}
