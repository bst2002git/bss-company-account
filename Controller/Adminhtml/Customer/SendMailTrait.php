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
namespace Bss\CompanyAccount\Controller\Adminhtml\Customer;

/**
 * Trait SendMailTrait
 *
 * @package Bss\CompanyAccount\Controller\Adminhtml\Customer
 */
trait SendMailTrait
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;

    /**
     * @var \Bss\CompanyAccount\Helper\Data
     */
    private $helper;

    /**
     * SendMailTrait constructor.
     *
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Bss\CompanyAccount\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Bss\CompanyAccount\Helper\Data $helper
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->helper = $helper;
    }

    /**
     * Send email
     *
     * @param $receiver
     * @param string $ccMails
     * @param string $mailTemplate
     * @param array $options
     * @param array $vars
     * @return bool
     * @throws \Exception
     */
    public function sendMail($receiver = null, $ccMails = '', $mailTemplate = '', $options = [], $vars = [])
    {
        try {
            $senderEmail = $this->helper->getEmailSender();
            $senderName = $this->helper->getEmailSenderName();
            $sender = [
                'name' => $senderName,
                'email' => $senderEmail,
            ];
            $this->inlineTranslation->suspend();
            $this->transportBuilder
                ->setTemplateIdentifier($mailTemplate)
                ->setTemplateOptions($options)
                ->setTemplateVars($vars)
                ->setFrom($sender)
                ->addTo($receiver);
            if (strpos($ccMails, ',') !== false) {
                $ccMails = explode(',', $ccMails);
                foreach ($ccMails as $mail) {
                    trim($mail) !== "" ? $this->transportBuilder->addCc(trim($mail)) : false;
                }
            } else {
                $this->transportBuilder->addCc(trim($ccMails));
            }
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
