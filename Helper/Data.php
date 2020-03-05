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

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 *
 * @package Bss\CompanyAccount\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_ADMIN_EMAIL_SENDER = 'bss_company_account/subuser_email/email_sender';
    const XML_PATH_COMPANY_ACCOUNT_APPROVAL_EMAIL_TEMPLATE = 'bss_company_account/ca_admin_email/approval';

    /**
     * @var HelperData
     */
    private $helperData;

    /**
     * Data constructor.
     *
     * @param HelperData $helperData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Context $context
     */
    public function __construct(
        HelperData $helperData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Context $context
    ) {
        $this->helperData = $helperData;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Get email sender
     *
     * @return string
     * @throws \Magento\Framework\Exception\MailException
     */
    public function getEmailSender()
    {
        $from = $this->scopeConfig->getValue(
            self::XML_ADMIN_EMAIL_SENDER,
            ScopeInterface::SCOPE_STORE
        );
        $result = $this->helperData->getSenderResolver()->resolve($from);
        return $result['email'];
    }

    /**
     * Get new company account approval mail template
     *
     * @return string
     */
    public function getCompanyAccountApprovalEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COMPANY_ACCOUNT_APPROVAL_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
}
