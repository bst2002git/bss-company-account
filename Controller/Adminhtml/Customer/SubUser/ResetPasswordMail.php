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
use Bss\CompanyAccount\Helper\SendMailTrait;
use Magento\Backend\App\Action;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManager;

/**
 * Class ResetPasswordMail
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\Customer\SubUser
 */
class ResetPasswordMail extends Action implements HttpPostActionInterface
{
    use SendMailTrait {
        SendMailTrait::__construct as private __sendMailConstruct;
    }

    /**
     * The admin user can execute this action
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = "Bss_CompanyAccount::config_section";

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \Magento\Framework\Math\Random
     */
    private $mathRandom;

    /**
     * @var SubUserRepositoryInterface
     */
    private $subUserRepository;

    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * ResetPasswordMail constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Bss\CompanyAccount\Helper\Data $helper
     * @param SubUserRepositoryInterface $subUserRepository
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param CustomerRepository $customerRepository
     * @param StoreManager $storeManager
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Bss\CompanyAccount\Helper\Data $helper,
        SubUserRepositoryInterface $subUserRepository,
        \Magento\Framework\Math\Random $mathRandom,
        CustomerRepository $customerRepository,
        StoreManager $storeManager,
        JsonFactory $jsonFactory
    ) {
        $this->__sendMailConstruct($inlineTranslation, $transportBuilder, $helper);
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->mathRandom = $mathRandom;
        $this->subUserRepository = $subUserRepository;
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * Send reset password mail to specific sub-user action
     *
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $subId = $this->getRequest()->getParam('id');
        $customerId = $this->getRequest()->getParam('customer_id');
        $error = false;
        if (!$customerId || !$subId) {
            $error = true;
        }
        $subUser = $this->subUserRepository->getById($subId);

        if ($subUser->getCompanyCustomerId() === (int)$customerId && !$error) {
            $customer = $this->customerRepository->getById($customerId);
            $token = $this->mathRandom->getRandomString(10);
            $subUser->setSubUserToken($token);
            try {
                $this->subUserRepository->save($subUser);
                $storeId = $customer->getStoreId();
                $store = $this->storeManager->getStore($storeId);
                $this->sendMail(
                    $customer->getEmail(),
                    null,
                    $this->helper->getResetSubUserPasswordEmailTemplate(),
                    [
                        'area' => 'frontend',
                        'store' => $storeId
                    ],
                    [
                        'subUser' => $subUser,
                        'store' => $store,
                        'companyAccountEmail' => $customer->getEmail()
                    ]
                );
            } catch (\Exception $e) {
                $error = true;
            }
        }

        if ($error) {
            $resultJson->setData([
                'error' => true,
                'message' => __('Some thing wrong! Please try again.')
            ]);
        } else {
            $data = [
                'request_success' => true,
                'message' => __('The sub-user will receive an email with a link to reset password.')
            ];
            $resultJson->setData($data);
        }
        return $resultJson;
    }
}
