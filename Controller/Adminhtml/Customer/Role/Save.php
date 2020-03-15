<?php
declare(strict_types=1);
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
namespace Bss\CompanyAccount\Controller\Adminhtml\Customer\Role;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Bss\CompanyAccount\Api\Data\SubRoleInterface as Role;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Bss_CompanyAccount::config_section';

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \Bss\CompanyAccount\Api\SubRoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @var \Bss\CompanyAccount\Api\Data\SubRoleInterfaceFactory
     */
    private $roleFactory;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param \Bss\CompanyAccount\Api\SubRoleRepositoryInterface $roleRepository
     * @param \Bss\CompanyAccount\Api\Data\SubRoleInterfaceFactory $roleFactory
     * @param LoggerInterface $logger
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Action\Context $context,
        \Bss\CompanyAccount\Api\SubRoleRepositoryInterface $roleRepository,
        \Bss\CompanyAccount\Api\Data\SubRoleInterfaceFactory $roleFactory,
        LoggerInterface $logger,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->roleRepository = $roleRepository;
        $this->roleFactory = $roleFactory;
    }

    /**
     * Save role action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $customerId = $this->getRequest()->getParam('customer_id', false);
        $roleId = $this->getRequest()->getParam('role_id', "");

        $error = false;
        try {
            /** @var \Bss\CompanyAccount\Api\Data\SubRoleInterface $role */
            $role = $this->roleFactory->create();
            $role->setRoleName($this->getRequest()->getParam(Role::NAME));
            $role->setRoleType(implode(',', $this->getRequest()->getParam(Role::TYPE)));
            $role->setMaxOrderPerDay((int)$this->getRequest()->getParam(Role::MAX_ORDER_PER_DAY));
            $role->setMaxOrderAmount((int)$this->getRequest()->getParam(Role::MAX_ORDER_AMOUNT));
            $role->setCompanyAccount((int)$customerId);

            if (!empty($roleId)) {
                $role->setRoleId((int)$roleId);
                $message = __('Role has been updated.');
            } else {
                $role->setRoleId(null);
                $message = __('New role has been added.');
            }

            $this->roleRepository->save($role);
        } catch (\Exception $e) {
            $error = true;
            $message = __('We can\'t save role right now.');
            $this->logger->critical($e);
        }

        $roleId = empty($roleId) ? null : $roleId;
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
            [
                'message' => $message,
                'error' => $error,
                'data' => [
                    'role_id' => $roleId
                ]
            ]
        );

        return $resultJson;
    }
}
