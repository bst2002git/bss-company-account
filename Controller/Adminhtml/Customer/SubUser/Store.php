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
namespace Bss\CompanyAccount\Controller\Adminhtml\Customer\SubUser;

use Bss\CompanyAccount\Api\SubUserRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Bss\CompanyAccount\Api\Data\SubUserInterface as SubUser;

/**
 * Class Store
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\Customer\SubUser
 */
class Store extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Bss_CompanyAccount::config_section';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Bss\CompanyAccount\Api\Data\SubUserInterfaceFactory
     */
    private $subUserFactory;

    /**
     * @var SubUserRepositoryInterface
     */
    private $subUserRepository;

    /**
     * Store constructor.
     *
     * @param LoggerInterface $logger
     * @param JsonFactory $resultJsonFactory
     * @param SubUserRepositoryInterface $subUserRepository
     * @param \Bss\CompanyAccount\Api\Data\SubUserInterfaceFactory $subUserFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        LoggerInterface $logger,
        JsonFactory $resultJsonFactory,
        \Bss\CompanyAccount\Api\SubUserRepositoryInterface $subUserRepository,
        \Bss\CompanyAccount\Api\Data\SubUserInterfaceFactory $subUserFactory
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->subUserRepository = $subUserRepository;
        $this->subUserFactory = $subUserFactory;
    }

    /**
     * Save sub-user
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $customerId = $this->getRequest()->getParam('customer_id', false);
        $subId = $this->getRequest()->getParam('sub_id', '');
        $error = false;
        try {
            /** @var \Bss\CompanyAccount\Api\Data\SubUserInterface $user */
            $user = $this->subUserFactory->create();
            $user->setSubUserName($this->getRequest()->getParam(SubUser::NAME));
            $user->setRoleId((int)$this->getRequest()->getParam(SubUser::ROLE_ID));
            $user->setSubUserEmail($this->getRequest()->getParam(SubUser::EMAIL));
            $user->setSubUserStatus((int)$this->getRequest()->getParam(SubUser::STATUS));
            $user->setCompanyCustomerId($customerId);

            if (!empty($subId)) {
                $user->setSubUserId($subId);
                $message = __('Sub-user has been updated.');
            } else {
                $user->setSubUserId(null);
                $message = __('New sub-user has been added.');
            }
            $this->subUserRepository->save($user);
        } catch (\Exception $exception) {
            $error = true;
            $message = __('We can\'t save sub-user right now.');
            $this->logger->critical($exception);
        }

        $subId = empty($subId) ? null : $subId;
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
            [
                'message' => $message,
                'error' => $error,
                'data' => [
                    'sub_id' => $subId
                ]
            ]
        );

        return $resultJson;
    }
}
