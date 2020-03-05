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
namespace Bss\CompanyAccount\Api\Data;

/**
 * Interface SubRoleInterface
 *
 * @package Bss\CompanyAccount\Api\Data
 */
interface SubRoleInterface
{
    /**
     * Constants for keys of data array.
     */
    const ID = 'role_id';
    const NAME = 'role_name';
    const TYPE = 'role_type';

    /**
     * Get role id
     *
     * @return int
     */
    public function getRoleId();

    /**
     * Set role id
     *
     * @param int $id
     * @return void
     */
    public function setRoleId(int $id);

    /**
     * Get role name
     *
     * @return string
     */
    public function getRoleName();

    /**
     * Set role name
     *
     * @param string $name
     * @return void
     */
    public function setRoleName(string $name);

    /**
     * Get permissions string
     *
     * @return string
     */
    public function getRoleType();

    /**
     * Set role permissions
     *
     * @param string $typeStr
     * @return void
     */
    public function setRoleType(string $typeStr);
}
