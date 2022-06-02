<?php

namespace Ec\Qr\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Api extends AbstractHelper
{
   
    //const API_URL = 'ec-hd-tst-svr.tk';
    const API_URL = 'dev.emotionalcommerce.com';

    const CAMPAIGN_TYPE = 'e-commerce';

    /**
     * ConfigFactory
     *
     * @var \EmotionalCommerceApp\Qr\Model\ConfigFactory
     */
    protected $configFactory;
    protected $_assetRepo;
    protected $_storeManager;


    public function __construct(
        \Ec\Qr\Model\ConfigFactory $configFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->configFactory = $configFactory;
        $this->_assetRepo = $assetRepo;
        $this->_storeManager = $storeManager;

    }

    public function getApiEndPointUrl(){
        return self::API_URL;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

    public function getCampaigns($key, $secret, $domain)
    {
        $headers =  [
            'Accept: application/json',
            'Content-Type: application/json',
            'key: ' . $key,
            'secret: ' . $secret,
        ];

        $regUrl = $domain . '.' . self::API_URL . "/api/v2/campaign?campaign_type=" . self::CAMPAIGN_TYPE;

        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 0);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $regCurl,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $regResult = json_decode(curl_exec($regCurl));
        $statusCode = curl_getinfo($regCurl, CURLINFO_HTTP_CODE);
        curl_close($regCurl);

        if ($statusCode != 200) {
            return [
                'success' => false,
                // 'message' => $regResult->message,
            ];
        }

        $campaigns = [];

        foreach ($regResult->data as $campaign) {
            $campaigns[] = [
                'name' => $campaign->name,
                'id' => $campaign->id,
            ];
        }

        while ($regResult->next_page_url) {
            $regCurl = curl_init($regResult->next_page_url);
            curl_setopt($regCurl, CURLOPT_POST, 0);
            curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $regCurl,
                CURLOPT_HTTPHEADER,
                $headers
            );
            $regResult = json_decode(curl_exec($regCurl));

            foreach ($regResult->data as $campaign) {
                $campaigns[] = [
                    'name' => $campaign->name,
                    'id' => $campaign->id,
                ];
            }
            curl_close($regCurl);
        }

        return [
            'success' => true,
            'data' => $campaigns,
        ];
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

    public function uploadVideo($filePath)
    {
        $config = $this->getConfig();

        $headers =  [
            'Accept: application/json',
            'content-type: multipart/form-data',
            'key: ' . $config['key'],
            'secret: ' . $config['secret'],
        ];

        $regUrl = $config['domain'] . '.' . self::API_URL . "/api/v2/campaign/" . $config['campaign'] . "/video/upload";

        $data = [
            'theme' => $config['slider-themeid'],
            'file' => curl_file_create($filePath),
            'cta_url' => $this->_storeManager->getStore()->getBaseUrl(),
        ];

        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 1);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($regCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $regCurl,
            CURLOPT_HTTPHEADER,
            $headers
        );      
        $regResult = curl_exec($regCurl);

        curl_close($regCurl);
        $data = json_decode($regResult, true);
        
        return [
            'success' => true,
            'data' => [
                'url' => $data['data']['landing_page']['url'],
                'qr' => $data['data']['qr_code']['png_image_url'],
            ],
        ];
    }

     public function createTenantToken($domain){           
         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => self::API_URL. "/api/v2/tenant/" . $domain . "/token",      
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET',
           CURLOPT_HTTPHEADER => array(
             'Accept: application/json',
             'Content-Type: application/json',
             'key: YQEKP4ty8wJDDgWh3d/vLzayY7DBYCMedGiT3PU7wYM=',
             'secret: mGhnwSQj5r2Pk+oGDE7FAxdI+YlGWJnp8Jf88/2NgNA='
             ),
           ));      

         $response = curl_exec($curl);
         curl_close($curl);
         $tenantData = json_decode($response, true);
         return $tenantData;
    }  

    public function createCampaigns()
      {
          $config = $this->getConfig();
          $headers =  [
              'Accept: application/json',
              'content-type: multipart/form-data',
              'key: ' . $config['key'],
              'secret: ' . $config['secret'],
          ];

          $regUrl = $config['domain'] . '.' . self::API_URL . "/api/v2/campaign"; 
           $data = [        
               'campaign_type' => self::CAMPAIGN_TYPE,
               'campaign_name' => 'Magento'.rand()
           ];

          $regCurl = curl_init($regUrl);
          curl_setopt($regCurl, CURLOPT_POST, 1);
          curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($regCurl, CURLOPT_POSTFIELDS, $data);
          curl_setopt(
              $regCurl,
              CURLOPT_HTTPHEADER,
              $headers
          );
          $regResult = curl_exec($regCurl);         
          curl_close($regCurl);        
          $campaignData = json_decode($regResult, true);

          return $campaignData;         
      }

      public function setDefaultQrPackage($campaignId){
          $config = $this->getConfig();
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => $config['domain'] . '.' . self::API_URL . "/api/v2/campaign/" . $campaignId . "/qr-package?saved=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
              'key: ' .  $config['key'],
              'secret: ' . $config['secret'],
            ),
          ));

          $response = curl_exec($curl);
          curl_close($curl);
          $qrCodeData = json_decode($response, true);
          return $qrCodeData;
      }


  public function validateVideo($filePath)
    {
        $config = $this->getConfig();

        $headers =  [
            'Accept: application/json',
            'content-type: multipart/form-data',
            'key: ' . $config['key'],
            'secret: ' . $config['secret'],
        ];

        $regUrl = $config['domain'] . '.' . self::API_URL . "/api/v2/campaign/" . $config['campaign'] . "/video/verify"; 
         $data = [        
             'file' => curl_file_create($filePath)
         ];

        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 1);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($regCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $regCurl,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $regResult = json_decode(curl_exec($regCurl));
        $statusCode = curl_getinfo($regCurl, CURLINFO_HTTP_CODE);
        curl_close($regCurl);

        if ($statusCode != 200) {
            return [
                'success' => false
                //'message' => $regResult->message,
            ];
        }

        return [
            'success' => true,
        ];
    }


    public function createEvent($ecOrder)
    {
        $config = $this->getConfig();

        $headers =  [
            'Accept: application/json',
            'content-type: multipart/form-data',
            'key: ' . $config['key'],
            'secret: ' . $config['secret'],
        ];

        $slug = $ecOrder->getUrl();
        $slug = explode('/', $slug);
        $slug = end($slug);
        $orderId = $ecOrder->getOrderId();

        $regUrl = $config['domain'] . '.' . self::API_URL . "/api/v2/qr-package/" . $slug . "/checkout-event";
        $data = [        
            'slug' => $slug,
            'qr_package_name' => $orderId
        ];
        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 0);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($regCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $regCurl,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $regResult = json_decode(curl_exec($regCurl));
        $statusCode = curl_getinfo($regCurl, CURLINFO_HTTP_CODE);
        curl_close($regCurl);

        $ecOrder->setPrinted(1);
        $ecOrder->save();

        return [
            'success' => true,
        ];
    }

    public function getLogin($email, $password)
    {
        $encodedEmail = urlencode($email); 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::API_URL. '/api/v2/login?email=' . $encodedEmail . '&password=' . $password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'key: YQEKP4ty8wJDDgWh3d/vLzayY7DBYCMedGiT3PU7wYM=',
                'secret: mGhnwSQj5r2Pk+oGDE7FAxdI+YlGWJnp8Jf88/2NgNA='
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $userdata = json_decode($response, true);
        return $userdata;
    }


    public function getRegister($email, $domain)
    {
        $encodedEmail = urlencode($email);   
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::API_URL. '/api/v2/register?email=' . $encodedEmail . '&domain=' . $domain . '&creation_source=magento',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'key: YQEKP4ty8wJDDgWh3d/vLzayY7DBYCMedGiT3PU7wYM=',
                'secret: mGhnwSQj5r2Pk+oGDE7FAxdI+YlGWJnp8Jf88/2NgNA='
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $userdata = json_decode($response, true);
        return $userdata;
    }

    public function getContact($name, $email, $subject, $message)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::API_URL. '/api/v2/mail-support?name' . $name . '&email=' . $email . '&subject=' . $subject . '&message=' . $message,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'key: YQEKP4ty8wJDDgWh3d/vLzayY7DBYCMedGiT3PU7wYM=',
                'secret: mGhnwSQj5r2Pk+oGDE7FAxdI+YlGWJnp8Jf88/2NgNA='
            ),
        ));

        $response = curl_exec($curl);
        $regResult = json_decode(curl_exec($curl));
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode != 200) {
            if ($statusCode == 409) {
                return [
                    'success' => true,
                ];
            }
            return [
                'success' => false,
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function getImpersonateUrl(){ 
    $config = $this->getConfig();     
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => self::API_URL. "/api/v2/tenant/" . $config['domain'] . "/impersonate",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: multipart/form-data',
            'key: YQEKP4ty8wJDDgWh3d/vLzayY7DBYCMedGiT3PU7wYM=',
            'secret: mGhnwSQj5r2Pk+oGDE7FAxdI+YlGWJnp8Jf88/2NgNA='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $impersonateUrl = $data['data']['impersonation_url']; 
        $correctUrl = preg_replace('/([^:])(\/{2,})/', '$1/', $impersonateUrl); //Remove extra slashes
        return $correctUrl;
      
    }


    public function getThemes($key, $secret, $domain)
    {
        $headers =  [
            'Accept: application/json',
            'Content-Type: application/json',
            'key: ' . $key,
            'secret: ' . $secret,
        ];

        $regUrl = $domain . '.' . self::API_URL . "/api/v2/theme?campaign_type=" . self::CAMPAIGN_TYPE;

        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 0);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $regCurl,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $regResult = json_decode(curl_exec($regCurl));
        $statusCode = curl_getinfo($regCurl, CURLINFO_HTTP_CODE);
        curl_close($regCurl);

        if ($statusCode != 200) {
            return [
                'success' => false,
            ];
        }

        $themes = [];

        foreach ($regResult->data as $theme) {
            $themes[] = [
                'name' => $theme->name,
                'screenshot' => $theme->screenshot,
                'is_default' => $theme->is_default,
                'theme_id' => $theme->theme_id,
                'campaign_id' => $theme->campaign_id,
            ];
        }

        return [
            'success' => true,
            'data' => $themes,
        ];
    }
    
    public function getModuleImageUrl(){
         return $this->_assetRepo->getUrl("Ec_Qr::images/graphic-video-gift.png");
    }
}
