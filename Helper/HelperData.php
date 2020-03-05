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

/**
 * Class HelperData
 *
 * @package Bss\CompanyAccount\Helper
 */
class HelperData
{
    /**
     * @var \Magento\Framework\Mail\Template\SenderResolverInterface
     */
    private $senderResolver;

    /**
     * HelperData constructor.
     *
     * @param \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver
     */
    public function __construct(
        \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver
    ) {
        $this->senderResolver = $senderResolver;
    }

    /**
     * Get sender Resolver
     * @return \Magento\Framework\Mail\Template\SenderResolverInterface
     */
    public function getSenderResolver()
    {
        return $this->senderResolver;
    }
}
