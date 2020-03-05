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
namespace Bss\CompanyAccount\Api;

use Bss\CompanyAccount\Api\Data\SubRoleInterface;
use Bss\CompanyAccount\Api\Data\SubRoleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface SubRoleRepositoryInterface
 *
 * @package Bss\CompanyAccount\Api
 */
interface SubRoleRepositoryInterface
{
    /**
     * Save a role
     *
     * @param SubRoleInterface $role
     * @return SubRoleInterface
     */
    public function save(SubRoleInterface $role);

    /**
     * Get role by id
     *
     * @param int $id
     * @return SubRoleInterface
     */
    public function getById(int $id);

    /**
     * Retrieve roles matching the specified criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SubRoleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Destroy a role
     *
     * @param SubRoleInterface $role
     * @return bool
     */
    public function delete(SubRoleInterface $role);

    /**
     * Destroy role by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
