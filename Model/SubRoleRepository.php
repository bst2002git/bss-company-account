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
namespace Bss\CompanyAccount\Model;

use Bss\CompanyAccount\Api\Data\SubRoleInterface;
use Bss\CompanyAccount\Api\SubRoleRepositoryInterface;
use Bss\CompanyAccount\Model\ResourceModel\SubRole as RoleResource;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

/**
 * Class SubRoleRepository
 *
 * @package Bss\CompanyAccount\Model
 */
class SubRoleRepository implements SubRoleRepositoryInterface
{
    /**
     * @var RoleResource
     */
    private $roleResource;

    /**
     * @var SubRoleFactory
     */
    private $roleFactory;

    /**
     * @var RoleResource\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * SubRoleRepository constructor.
     *
     * @param RoleResource $roleResource
     * @param SubRoleFactory $roleFactory
     * @param RoleResource\CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        RoleResource $roleResource,
        SubRoleFactory $roleFactory,
        ResourceModel\SubRole\CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->roleResource = $roleResource;
        $this->roleFactory = $roleFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Get role by id
     *
     * @param int $id
     * @return \Bss\CompanyAccount\Api\Data\SubRoleInterface
     */
    public function getById(int $id)
    {
        $role = $this->roleFactory->create();
        $this->roleResource->load($role, $id);

        return $role;
    }

    /**
     * Save a role
     *
     * @param SubRoleInterface $role
     * @return SubRoleInterface|RoleResource
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(SubRoleInterface $role)
    {
        return $this->roleResource->save($role);
    }

    /**
     * Retrieve roles matching the specified criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return \Bss\CompanyAccount\Api\Data\SubRoleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->collectionFactory->create();
        $collection->load();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $customs=[];
        foreach ($collection->getData() as $custom) {
            $customs[] = $custom;
        }
        $searchResults->setItems($customs);
        return $searchResults;
    }

    /**
     * Delete role
     *
     * @param SubRoleInterface $role
     * @return bool|RoleResource
     * @throws \Exception
     */
    public function delete(SubRoleInterface $role)
    {
        return $this->roleResource->delete($role);
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id)
    {
        $role = $this->roleFactory->create();
        $this->roleResource->load($role, $id);

        return $this->delete($role);
    }
}
