<?php

namespace Ec\Qr\Block;

class Cart extends \Magento\Framework\View\Element\Template
{
    /**
     * apiHelper
     *
     * @var \EmotionalCommerceApp\Qr\Helper\Api
     */
    protected $apiHelper;
    protected $checkoutSession;
    protected $cartHelper;
    protected $assetRepository;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Helper\Cart $cartHelper,
        \Magento\Framework\View\Asset\Repository $assetRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->apiHelper = $apiHelper;
        $this->checkoutSession = $checkoutSession;
        $this->cartHelper = $cartHelper;
        $this->assetRepository = $assetRepository;
        $this->_storeManager = $storeManager;

        parent::__construct($context, $data);
    }

    public function canShow()
    {
        if ($this->checkoutSession->getData('ec_qr') || $this->cartHelper->getItemsCount() === 0) {
            return false;
        }

        return true;
    }

    //This function will be used to get the css/js file.
    public function getAssetUrl($asset)
    {
        
        return $this->assetRepository->createAsset($asset)->getUrl();
    }

    public function getConfig()
    {
        return $this->apiHelper->getConfig();
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

    public function getThemes($key, $secret, $domain)
    {
        $themes = $this->apiHelper->getThemes($key, $secret, $domain);

        if (!$themes['success']) {
            return false;
        }

        return $themes;
    }
}
