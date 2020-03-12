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

use Bss\CompanyAccount\Api\SubRoleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;

/**
 * Class to delete selected role through massaction
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see MassDelete::_isAllowed()
     */
    const ADMIN_RESOURCE = 'Bss_CompanyAccount::config_section';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var SubRoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param Context $context
     * @param LoggerInterface $logger
     * @param SubRoleRepositoryInterface $roleRepository
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        SubRoleRepositoryInterface $roleRepository,
        JsonFactory $resultJsonFactory
    ) {
        $this->logger = $logger;
        $this->roleRepository = $roleRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Delete specified roles using grid massaction
     *
     * @return Json
     * @throws \Exception
     */
    public function execute(): Json
    {
        $error = false;
        $updatedRoleCount = 0;

        try {
            $roles = $this->getRequest()->getParam('selected');
            foreach ($roles as $roleId) {
                if ((int)$roleId !== 0) {
                    $this->roleRepository->deleteById((int)$roleId);
                    $updatedRoleCount++;
                }
            }
            $message = __('A total of %1 record(s) have been deleted.', $updatedRoleCount);
        } catch (\Exception $e) {
            $message = __('We can\'t mass delete the roles right now.');
            $error = true;
            $this->logger->critical($e);
        }

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
            [
                'message' => $message,
                'error' => $error,
            ]
        );

        return $resultJson;
    }
}
