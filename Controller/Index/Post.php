<?php
namespace Ec\Qr\Controller\Index;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * Show Contact Us page
     *
     * @return void
     */
    protected $_objectManager;
    protected $_storeManager;
    protected $_filesystem;
    protected $_fileUploaderFactory;
    protected $apiHelper;
    protected $configFactory;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    protected $checkoutSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,\Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Ec\Qr\Model\ConfigFactory $configFactory
    ) {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->apiHelper = $apiHelper;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->checkoutSession = $checkoutSession;
        $this->configFactory = $configFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $configModel = $this->configFactory->create();
        $collection = $configModel->getCollection();

        foreach ($collection as $config) {
            if (isset($post[$config->getName()])) {
                $config->setValue($post[$config->getName()]);
                $config->save();
                unset($post[$config->getName()]);
            }
            if (isset($post['sliderThemeId'])) {
                if (isset($File_upoad)) {
                    $config->delete();
                }
            }
        }    

        if (isset($post['sliderThemeId']) && $post['sliderThemeId'] != '') {
            $configModel->setData(
                [
                    'name' => 'slider-themeid',
                    'value' => $post['sliderThemeId']
                ]
            );
            $configModel->save();           
        }

        if (isset($post['dynamicThemeId']) && $post['sliderThemeId'] == '') {
            $configModel->setData(
                [
                    'name' => 'slider-themeid',
                    'value' => $post['dynamicThemeId']
                ]
            );
            $configModel->save();
        }
        
        //$video = $_FILES('video');        
        $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
        $path = $mediapath . '/ecqr/';

        if (empty($post['blob'])) {
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'video']);
            $uploader->setAllowedExtensions(['mp4', 'mov', 'webm', 'ogg', 'avi', 'mkv']);
            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($path);
            $qr = $this->apiHelper->validateVideo($result['path'] . $result['file']);
        } else {
            $result = ['path' => dirname($post['blob']) . '/', 'file' => basename($post['blob'])];
            $qr = $this->apiHelper->validateVideo($result['path'] . $result['file']);
        }

        if (!$qr['success']) {
            $this->messageManager->addError(__('An Error has occurred please try again later.'));
            return $this->getResponse()->setRedirect('/checkout/cart/index');
        }

        try {
            $_product = $this->productRepository->get('ec-qr-product');

            $this->cart->addProduct($_product, ['qty' => 1]);

            $this->cart->save();

            $this->checkoutSession->setData('ec_qr', $result['path'] . $result['file']);

            $this->messageManager->addSuccess(__('Video Uploaded Successfully'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addException(
                $e,
                __('%1', $e->getMessage())
            );
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('An Error has occurred please try again later.'));
        }

        $this->getResponse()->setRedirect('/checkout/cart/index');
    }
}
