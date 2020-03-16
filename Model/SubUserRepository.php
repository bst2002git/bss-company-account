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

use Bss\CompanyAccount\Api\Data\SubUserInterface;
use Bss\CompanyAccount\Api\Data\SubUserSearchResultsInterface;
use Bss\CompanyAccount\Api\SubUserRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Bss\CompanyAccount\Model\ResourceModel\SubUser as UserResource;

/**
 * Class SubUserRepository
 *
 * @package Bss\CompanyAccount\Model
 */
class SubUserRepository implements SubUserRepositoryInterface
{
    /**
     * @var UserResource
     */
    private $userResource;

    /**
     * @var SubUserFactory
     */
    private $userFactory;

    /**
     * SubUserRepository constructor.
     *
     * @param UserResource $userResource
     * @param SubUserFactory $userFactory
     */
    public function __construct(
        UserResource $userResource,
        SubUserFactory $userFactory
    ) {
        $this->userResource = $userResource;
        $this->userFactory = $userFactory;
    }

    /**
     * Save sub-user
     *
     * @param SubUserInterface $user
     * @return SubUserInterface|mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(SubUserInterface $user)
    {
        return $this->userResource->save($user);
    }

    /**
     * Get sub-user by id
     *
     * @param int $id
     * @return SubUserInterface
     */
    public function getById($id)
    {
        $user = $this->userFactory->create();
        $this->userResource->load($user, $id);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        // TODO: Implement getList() method.
    }

    /**
     * Delete sub-user
     *
     * @param SubUserInterface $user
     * @return bool|UserResource
     * @throws \Exception
     */
    public function delete(SubUserInterface $user)
    {
        return $this->userResource->delete($user);
    }

    /**
     * Delete sub-user by id
     *
     * @param int $id
     * @return bool|UserResource
     * @throws \Exception
     */
    public function deleteById(int $id)
    {
        $user = $this->userFactory->create();
        $this->userResource->load($user, $id);

        return $this->delete($user);
    }
}
