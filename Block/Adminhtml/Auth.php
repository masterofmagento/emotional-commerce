<?php

namespace Ec\Qr\Block\Adminhtml;

class Auth extends \Magento\Backend\Block\Template
{
    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $context;
    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $formKey;
    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    public $coreSessions;
    /**
     * ConfigFactory
     *
     * @var \Ec\Qr\Model\ConfigFactory
     */
    protected $configFactory;
    /**
     * apiHelper
     *
     * @var \Ec\Qr\Helper\Api
     */
    protected $apiHelper;
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Ec\Qr\Model\ConfigFactory $configFactory,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        $this->context = $context;
        $this->formKey = $formKey;
        $this->coreSession = $coreSession;
        $this->configFactory = $configFactory;
        $this->apiHelper = $apiHelper;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Returns the index url
     *
     * @return array
     */
    public function getIndexUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/index');
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getLoginActionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/setprice');
    }

    public function getDomainUrl()
    {
        return $this->apiHelper->getApiEndPointUrl();
    }

    public function getConfig()
    {
        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();

        $configData = [
            'key' => false,
            'secret' => false,
            'domain' => false,
            'campaign' => false,
            'template' => false,
            'price' => false,
            'width' => 720,
            'height' => 720,
            'title' => __('Add Video'),
            'subtitle' => false,
            'button-title' => __('Add Video'),
            'button-color' => false,
            'button-background' => false,
            'enabled' => 0,
            'qr-title' => __('Scan the QR to see the <br /> Emotional Message'),
        ];
        foreach ($collection as $config) {
            $configData[$config->getName()] = $config->getValue();
        }

        return $configData;
    }

    /**
     * Generates and returns a form key
     *
     * @return array
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
    
    /**
     * Returns the register action url
     *
     * @return array
     */
    public function getRegisterActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/setprice/');
    }

    /**
     * Returns the register action url
     *
     * @return array
     */
    public function getRegisterSuccessActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/success/');
    }
}
