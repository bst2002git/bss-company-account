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

use Bss\CompanyAccount\Api\Data\SubRoleInterface as Role;
use Bss\CompanyAccount\Model\ResourceModel\SubRole\Grid\CollectionFactory;
use Bss\CompanyAccount\Api\SubRoleRepositoryInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class EnableDisable
 *
 * @package Bss\CompanyAccount\Model\Config\Source
 */
class RoleOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var AbstractCollection
     */
    private $collection;

    /**
     * Role constructor.
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        CollectionFactory $collectionFactory
    ) {
        $this->request = $request;
        $this->collection = $collectionFactory->create();
    }

    public function getListRole()
    {
        $collection = $this->getCollection();
        if ($this->request->getParam('customer_id')) {
            $collection->addFieldToFilter(
                [
                    Role::CUSTOMER_ID,
                    Role::CUSTOMER_ID
                ],
                [
                    ["eq" => (int)$this->request->getParam('customer_id')],
                    ["null" => true]
                ]
            );
        }

        return $collection->getdata();
    }

    /**
     * Get role collection
     *
     * @return \Bss\CompanyAccount\Model\ResourceModel\SubRole\Grid\Collection|AbstractCollection
     */
    private function getCollection()
    {
        return $this->collection;
    }

    /**
     * Get enable/disable option
     *
     * @return array
     */
    public function toOptionArray()
    {
        $roles = $this->getListRole();
        $data = [];
        foreach ($roles as $role) {
            $data[] = [
                'label' => $role[Role::NAME],
                'value' => $role[Role::ID]
            ];
        }
        return $data;
    }
}
