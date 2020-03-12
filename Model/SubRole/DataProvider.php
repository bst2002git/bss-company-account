<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bss\CompanyAccount\Model\SubRole;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Bss\CompanyAccount\Model\ResourceModel\SubRole\CollectionFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Type;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Customer\Model\Address;
use Magento\Customer\Model\FileUploaderDataResolver;
use Magento\Customer\Model\AttributeMetadataResolver;
use Magento\Ui\Component\Form\Element\Multiline;

/**
 * Dataprovider of customer addresses for customer address grid.
 *
 * @property \Magento\Customer\Model\ResourceModel\Address\Collection $collection
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * Allow to manage attributes, even they are hidden on storefront
     *
     * @var bool
     */
    private $allowToShowHiddenAttributes;

    /*
     * @var ContextInterface
     */
    private $context;

    /**
     * @var FileUploaderDataResolver
     */
    private $fileUploaderDataResolver;

    /**
     * @var AttributeMetadataResolver
     */
    private $attributeMetadataResolver;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param Config $eavConfig
     * @param ContextInterface $context
     * @param FileUploaderDataResolver $fileUploaderDataResolver
     * @param AttributeMetadataResolver $attributeMetadataResolver
     * @param array $meta
     * @param array $data
     * @param bool $allowToShowHiddenAttributes
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        Config $eavConfig,
        ContextInterface $context,
        FileUploaderDataResolver $fileUploaderDataResolver,
        AttributeMetadataResolver $attributeMetadataResolver,
        array $meta = [],
        array $data = [],
        $allowToShowHiddenAttributes = true
    ) {
        $this->collection = $collectionFactory->create();
        $this->context = $context;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get roles data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData(): array
    {
        $this->loadedData[''] = $this->getDefaultData();
        return $this->loadedData;
    }

    /**
     * Get default customer data for adding new role
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return array
     */
    private function getDefaultData(): array
    {
        $customerId = $this->context->getRequestParam('customer_id');
        return [
            'customer_id' => $customerId
        ];
    }
}
