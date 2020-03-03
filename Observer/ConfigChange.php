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
namespace Bss\CompanyAccount\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ConfigChange
 *
 * @package Bss\CompanyAccount\Observer
 */
class ConfigChange implements ObserverInterface
{
    const XML_PATH_BSS_CA = 'bss_company_account';
    const APPLY_FOR = 'apply_for_customer_group';
    const GENERAL = 'general';
    const EMAIL = 'email';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * ConfigChange constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $params = $this->request->getParam('groups');
        $applyCustomerGroups = $params[self::GENERAL]['fields'][self::APPLY_FOR]['value'];
        return $this;
    }
}
