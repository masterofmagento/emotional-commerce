<?php

namespace Ec\Qr\Controller\Adminhtml;

abstract class Action extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Product Model
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Config Factory
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
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    protected $directoryList;
    protected $file;
    protected $moduleReader;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $productManagement;
    protected $_mathRandom;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Ec\Qr\Model\ConfigFactory $configFactory
     * @param \Ec\Qr\Helper\Api $apiHelper
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\Framework\Filesystem\Io\File $file
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Framework\Image\AdapterFactory $adapterFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Catalog\Model\Product $product
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Ec\Qr\Model\ConfigFactory $configFactory,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Math\Random $mathRandom,
        \Ec\Qr\Model\ProductManagement $productManagement
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->messageManager = $messageManager;
        $this->configFactory = $configFactory;
        $this->apiHelper = $apiHelper;
        $this->productRepository = $productRepository;
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->moduleReader = $moduleReader;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->productManagement = $productManagement;
        $this->_mathRandom = $mathRandom;
    }

    public function generateRandomString($length)
    {
        return $this->_mathRandom->getRandomString(
            $length,
            \Magento\Framework\Math\Random::CHARS_DIGITS . \Magento\Framework\Math\Random::CHARS_LOWERS
        );
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ec_Qr::config_child_admin');
    }
}
