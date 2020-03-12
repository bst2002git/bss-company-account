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
namespace Bss\CompanyAccount\Model\Config\Source;

/**
 * Class Permissions
 *
 * @package Bss\CompanyAccount\Model\Config\Source
 */
class Permissions implements \Magento\Framework\Option\ArrayInterface
{
    const VIEW_ACCOUNT_DASHBOARD = 1;
    const VIEW_DOWNLOADABLE_PRODUCT = 2;
    const ADD_VIEW_ACCOUNT_WISHLISTS = 3;
    const ADD_VIEW_ADDRESS_BOOK = 4;
    const VIEW_STORED_PAYMENT_METHOD = 5;
    const MANAGE_SUB_USER = 6;
    const VIEW_ALL_ORDER = 7;
    const VIEW_REPORT = 8;

    /**
     * Return array of permission options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('View Account Dashboard'),
                'value' => self::VIEW_ACCOUNT_DASHBOARD
            ],
            [
                'label' => __('View Downloadable Product'),
                'value' => self::VIEW_DOWNLOADABLE_PRODUCT
            ],
            [
                'label' => __('View & Add Account Wishlists'),
                'value' => self::ADD_VIEW_ACCOUNT_WISHLISTS
            ],
            [
                'label' => __('View & Add Address Book'),
                'value' => self::ADD_VIEW_ADDRESS_BOOK
            ],
            [
                'label' => __('View Stored Payment Method'),
                'value' => self::VIEW_STORED_PAYMENT_METHOD
            ],
            [
                'label' => __('Manage Sub User'),
                'value' => self::MANAGE_SUB_USER
            ],
            [
                'label' => __('View All Order'),
                'value' => self::VIEW_ALL_ORDER
            ],
            [
                'label' => __('View Report'),
                'value' => self::VIEW_REPORT
            ]
        ];
    }
}
