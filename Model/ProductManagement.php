<?php
namespace Ec\Qr\Model;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Filesystem\Io\File;

class ProductManagement 
{

    const PRODUCT_NAME = "Emotional Commerce Video";
    const PRODUCT_SKU = "ec-qr-product";
    const PRODUCT_URL = "ec-qr-product";

    /**
     * Catalog Product
     *
     * @var \Magento\Catalog\Model\Product
     */
    private $product;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    
    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    protected $moduleReader;

    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $file;

    /**
     * @param Product $product
     * @param State $state
     * @param File $file
     * @param DirectoryList $directoryList
     * @param Reader $moduleReader
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Product $product,
        State $state,
        File $file,
        DirectoryList $directoryList,
        Reader $moduleReader,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->directoryList = $directoryList;
        $this->moduleReader = $moduleReader;
        $this->product = $product;
        $this->state = $state;
        $this->file = $file;
    }

    public function createProduct($price = 0.1)
    {
        if ($this->state->getAreaCode() != 'adminhtml') 
        {
            $this->state->setAreaCode('adminhtml');
        }

        $id = $this->product->getIdBySku(self::PRODUCT_SKU);
        if ($id) {
            $ecProduct = $this->productRepository->get(self::PRODUCT_SKU);
            $ecProduct->setPrice($price);

            if ($ecProduct->getData('image') === 'no_selection' || !$ecProduct->getData('image')) 
            {
                $ecProduct->addImageToMediaGallery(
                    $this->getImagePath(),
                    ['image', 'small_image', 'thumbnail'],
                    true,
                    true
                );
            }

            $this->productRepository->save($ecProduct);
        }
        else
        {
            $attributeSetId = $this->product->getDefaultAttributeSetId();
            $this->product->setSku(self::PRODUCT_SKU);
            $this->product->setName(self::PRODUCT_NAME);
            $this->product->setUrlKey(self::PRODUCT_URL);
            $this->product->setAttributeSetId($attributeSetId);
            $this->product->setStatus(1);
            $this->product->setVisibility(1);
            $this->product->setTaxClassId(0);
            $this->product->setTypeId('virtual');
            $this->product->setPrice($price);
            $this->product->setWebsiteIds([1]);
            $this->product->setStockData(
                [
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 0,
                ]
            );       
            
            $this->product->addImageToMediaGallery(
                $this->getImagePath(),
                ['image', 'small_image', 'thumbnail'],
                true,
                true
            );
            $this->product->save();
        }
    }

    protected function getImagePath()
    {
        $tmpDir = $this->getMediaDirTmpDir();
        $this->file->checkAndCreateFolder($tmpDir);
        $newFileName = $tmpDir . 'product-image.jpg';
        $img = $this->moduleReader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
            'Ec_Qr'
        ) . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'product-image.jpg';
        $this->file->read($img, $newFileName);
        return $newFileName;
    }

    protected function getMediaDirTmpDir()
    {
        return $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
    }
}