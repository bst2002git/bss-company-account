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

use Bss\CompanyAccount\Api\Data\SubUserInterface;
use Bss\CompanyAccount\Api\Data\SubUserSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface SubUserRepositoryInterface
 *
 * @package Bss\CompanyAccount\Api
 */
interface SubUserRepositoryInterface
{
    /**
     * Save user information
     *
     * @param SubUserInterface $user
     * @return SubUserInterface
     */
    public function save(SubUserInterface $user);

    /**
     * Get sub user by id
     *
     * @param int $id
     * @return SubUserInterface
     */
    public function getById($id);

    /**
     * Retrieve sub users matching the specified criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SubUserSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Destroy sub user
     *
     * @param SubUserInterface $user
     * @return bool
     */
    public function delete(SubuserInterface $user);

    /**
     * Destroy sub user by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
