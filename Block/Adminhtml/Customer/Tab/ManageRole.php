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
namespace Bss\CompanyAccount\Block\Adminhtml\Customer\Tab;

/**
 * Class ManageRole
 *
 * @package Bss\CompanyAccount\Block\Adminhtml\Customer\Tab
 */
class ManageRole extends \Magento\Backend\Block\Template implements \Magento\Ui\Component\Layout\Tabs\TabInterface
{

    /**
     * @inheritDoc
     */
    public function getTabLabel()
    {
        return __('Manage Role');
    }

    /**
     * @inheritDoc
     */
    public function getTabTitle()
    {
        return __('Manage Role');
    }

    /**
     * @inheritDoc
     */
    public function getTabClass()
    {
        // TODO: Implement getTabClass() method.
    }

    /**
     * @inheritDoc
     */
    public function getTabUrl()
    {
        return $this->getUrl('bss_companyaccount/customer/listroles', ['_current' => true]);
    }

    /**
     * @inheritDoc
     */
    public function isAjaxLoaded()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isHidden()
    {
        return false;
    }
}
