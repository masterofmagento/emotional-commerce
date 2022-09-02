<?php

namespace Ec\Qr\Block\Adminhtml;

/**
 * Block for the images upload form
 */
class Config extends \Magento\Backend\Block\Template
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

    protected $ecOrderFactory;

    protected $_orderCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Ec\Qr\Model\ConfigFactory $configFactory,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Ec\Qr\Model\EcOrderFactory $ecOrderFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
    ) {
        $this->context = $context;
        $this->formKey = $formKey;
        $this->coreSession = $coreSession;
        $this->configFactory = $configFactory;
        $this->apiHelper = $apiHelper;
        $this->pageFactory = $pageFactory;
        $this->ecOrderFactory = $ecOrderFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getActionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/save');
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getInstallActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/install');
    }

    public function getQrMediaUrl()
    {
        $mediaUrl = $this->apiHelper->getMediaUrl();
        return $mediaUrl;
    }

    public function getOrderQrImage()
    {
        $ecOrder = $this->ecOrderFactory->create();
        return $ecOrder;
    }


    /**
     * Returns the register action url
     *
     * @return array
     */
    public function getLogoutActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/logout');
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
            'button-title' => __('ADD A VIDEO MESSAGE'),
            'button-color' => "#FFFFFF",
            'button-background' => "#000000",
            'button-padding' => false,
            'enabled' => 0,
            'qr-title' => __('Scan the QR to see the <br /> Emotional Message'),
            'popup-title-text' => __('Send A Personal Video Message With Your Gift!'),
            'occasion-text' =>  __('Choose your occasion:'),
            'video-record-button-text' => __('Record'),
            'video-stop-button-text' => __('Stop'),
            'video-accept-button-text' => __('Select'),
            'video-recording-text' => __('Recording'),
            'video-recorded-text' => __('Recorded'),
            'upload-button-text' => __('Recorded Clip'),
            'recording-clip-text' => __('Record'),
            'remove-video-text' => __('Remove Personal Video Message'),
            'video-upload-text' => __('Upload'),
            'video-error-text' => __('Something went wrong'),
            'video-submit-text' => __('Your video has been uploaded'),
            'popup-description' => "",
            'record-upload-butoon-primary-color' => "#D2D2D2",
            'submit-button-text-color' => "#FFFFFF",
            'record-upload-butoon-text-color' => "#000000",
            'submit-button-primary-color' =>  "#F77E27",
            'record-upload-butoon-secondary-color' => "#D2D2D2",
            'submit-button-secondary-color' => "#FAD25D",
            'force_popup' => 0,
            'theme_ids' => false,
            'slider-themeid' => false
        ];
        foreach ($collection as $config) {
            $configData[$config->getName()] = $config->getValue();
        }

        return $configData;
    }

    public function getPages()
    {
        $page = $this->pageFactory->create();
        return $page->getCollection();
    }

    /**
     * Returns the Config url
     *
     * @return
     */
    public function geConfigUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/config');
    }

    /**
     * Returns the Orders url
     *
     * @return
     */
    public function geOrdersUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/orders');
    }

    /**
     * Returns the button section url
     *
     * @return
     */
    public function getButtonSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/button');
    }

    /**
     * Returns the popup section url
     *
     * @return
     */
    public function getPopupSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/popup');
    }


    /**
     * Returns the qrcode section url
     *
     * @return
     */
    public function getQrcodeSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/qrcode');
    }

    /**
     * Returns the qrcode section url
     *
     * @return
     */
    public function getThemeSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/theme');
    }
    /**
     * Returns the campaigns section url
     *
     * @return
     */
    public function getCampaignsSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/campaigns');
    }

    /**
     * Returns the account section url
     *
     * @return
     */
    public function getAccountSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/account');
    }

    /**
     * Returns the Faq section url
     *
     * @return
     */
    public function getFaqSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/faq');
    }

    /**
     * Returns the contact section url
     *
     * @return
     */
    public function getContactSectionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/config/contact');
    }
}
