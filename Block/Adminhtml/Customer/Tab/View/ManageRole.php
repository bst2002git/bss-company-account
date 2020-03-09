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
namespace Bss\CompanyAccount\Block\Adminhtml\Customer\Tab\View;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Extended;

/**
 * Class ManageRole
 *
 * @package Bss\CompanyAccount\Block\Adminhtml\Customer\Tab\View
 */
class ManageRole extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Bss\CompanyAccount\Model\ResourceModel\SubRole\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Bss\CompanyAccount\Model\SubRoleFactory
     */
    private $roleFactory;

    /**
     * ManageRole constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Bss\CompanyAccount\Model\ResourceModel\SubRole\CollectionFactory $collectionFactory
     * @param \Bss\CompanyAccount\Model\SubRoleFactory $roleFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Bss\CompanyAccount\Model\ResourceModel\SubRole\CollectionFactory $collectionFactory,
        \Bss\CompanyAccount\Model\SubRoleFactory $roleFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->roleFactory = $roleFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub
        $this->setId('listRoleGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultLimit(20);
        $this->setUseAjax(true);
    }

    /**
     * Get collection for grid
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create()->addFieldToSelect('*');
        $this->setCollection($collection);
        return parent::_prepareCollection(); // TODO: Change the autogenerated stub
    }

    public function _getSelectedItems()
    {
        $items = $this->getRequest()->getParam('roles');
        if (!is_array($items)) {
            $items = array_keys($this->getSelectedItems());
        }
        return $items;
    }

    public function getSelectedItems()
    {
        return [];
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_roles',
            [
                'type' => 'checkbox',
                'name' => 'in_roles',
                'index' => 'role_id',
                'values' => $this->_getSelectedItems()
            ]
        );
        $this->addColumn(
            'role_id',
            [
                'header' => __('ID'),
                'index' => 'role_id',
            ]
        );
        $this->addColumn(
            'role_name',
            [
                'header' => __('Role Name'),
                'index' => 'role_name',
            ]
        );
        $this->addColumn(
            'role_type',
            [
                'header' => __('Role Type'),
                'index' => 'role_type',
            ]
        );
        $this->addColumn(
            'order_per_day',
            [
                'header' => __('Max Order Per Day'),
                'index' => 'order_per_day',
            ]
        );
        $this->addColumn(
            'max_order_amount',
            [
                'header' => __('Max Order Amount'),
                'index' => 'max_order_amount',
            ]
        );
        return parent::_prepareColumns(); // TODO: Change the autogenerated stub
    }

    /**
     * Add column for filter to collection
     *
     * @param Grid\Column $column
     * @return $this|Extended
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_images') {
            $itemIds = $this->_getSelectedItems();

            if (empty($itemIds)) {
                $itemIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('item_id', ['in' => $itemIds]);
            } else {
                if ($itemIds) {
                    $this->getCollection()->addFieldToFilter('item_id', ['nin' => $itemIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }
}
