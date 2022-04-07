<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Register extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $email = $post['email'];
        $domain = $post['domain'];
        $configValue = $this->apiHelper->getConfig();
        $register = $this->apiHelper->getRegister($email, $domain);        
        if (isset($register['errors']['email'])) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config');
            $this->messageManager->addError(__($register['errors']['email'][0]));
            return $resultRedirect->setPath($url);
        }

        if (isset($register['errors']['domain'])) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config');
            $this->messageManager->addError(__($register['errors']['domain'][0]));
            return $resultRedirect->setPath($url);
        }

        if (isset($register['data']['domain']) && $register['data']['domain']) { 
           $configModel = $this->configFactory->create();
           $configModel->setData(
               [
                   'name' => 'domain',
                   'value' => $register['data']['domain']
               ]
           );           
           $configModel->save();

           $configModel->setData(
               [
                   'name' => 'email',
                   'value' => $email
               ]
           );           
           $configModel->save();
           sleep(8); //Wait for the db value

           if($register['data']['domain'] !=''){
           $configValue = $this->apiHelper->getConfig();             
           $domain = $configValue['domain'];  
           $tenantToken =  $this->apiHelper->createTenantToken($domain);           
           $tenantKey = @$tenantToken['data']['key'];
           $tenantSecret = @$tenantToken['data']['secret'];          
           $configModel = $this->configFactory->create();
           $configModel->setData(
               [
                   'name' => 'key',
                   'value' => $tenantKey
               ]
           );
           $configModel->save();          
           $configModel->setData(
               [
                   'name' => 'secret',
                   'value' => $tenantSecret
               ]
           );
           $configModel->save();

           $key = $configValue['key']; 
           $secret = $configValue['secret'];
           $domain = $configValue['domain'];

           $campaigns =  $this->apiHelper->getCampaigns($key, $secret, $domain);

           if (!$campaigns['success']) {  //echo "No campaign available";          
              $newCampaign = $this->apiHelper->createCampaigns();
              $newCampaignId = $newCampaign['data']['id'];
              $hasQrCodeCheck = $newCampaign['data']['has_saved_qr_package'];

              if($hasQrCodeCheck !=1){ // Set default QR code
                $setDefaultQrPackage = $this->apiHelper->setDefaultQrPackage($newCampaignId);
              }

              $configModel = $this->configFactory->create();
              $configModel->setData(
                  [
                      'name' => 'campaign',
                      'value' => $newCampaignId
                  ]
              );
              $configModel->save();
            }  
           
           if ($campaigns['success']) {           
           foreach ($campaigns['data'] as $campaign){
               $campaignId = $campaign['id']; 
               $hasQrCodeCheck = $campaign['has_saved_qr_package'];
               if($hasQrCodeCheck !=1){ // Set default QR code
                 $setDefaultQrPackage = $this->apiHelper->setDefaultQrPackage($campaignId);
               }
             }            
             $configModel = $this->configFactory->create();
             $configModel->setData(
                 [
                     'name' => 'campaign',
                     'value' => $campaignId
                 ]
             );
             $configModel->save();
           }
           $themes = $this->apiHelper->getThemes($tenantKey, $tenantSecret, $domain); //Set default theme
           $empty_array = array();
             foreach ($themes['data'] as $theme){
                  if($theme['is_default'] == 1){                     
                     $empty_array['theme_id'] = array($theme['theme_id']); 
                     $defaultThemeId = json_encode($empty_array);
                  }
             }
              $configModel->setData(
                 [
                     'name' => 'theme_ids',
                     'value' => $defaultThemeId
                 ]
             );
          
           $configModel->save(); 

           $configModel->setData(
               [
                   'name' => 'template',
                   'value' => '<p style="text-align: center;">{{qr-title}}</p>
                    <p style="text-align: center;">{{qr}}</p>'
               ]
           );
           $configModel->save();
           $configModel->setData(
               [
                   'name' => 'price',
                   'value' => 0.1
               ]
           );
           $configModel->save();
           $configModel->setData(
               [
                   'name' => 'width',
                   'value' => '150px'
               ]
           );
           $configModel->save();
           $configModel->setData(
               [
                   'name' => 'title',
                   'value' => 'Add Video'
               ]
           );
           $configModel->save();
           $configModel->setData(
               [
                   'name' => 'button-title',
                   'value' => 'ADD A VIDEO MESSAGE'
               ]
           );
           $configModel->save();
           $configModel->setData(
               [
                   'name' => 'button-color',
                   'value' => '#FFFFFF'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'button-background',
                   'value' => '#000000'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'enabled',
                   'value' => 1
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'qr-title',
                   'value' => 'Scan the QR to see the <br /> Emotional Message'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'popup-title-text',
                   'value' => 'Send A Personal Video Message With Your Gift!'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'occasion-text',
                   'value' => 'Choose your occasion:'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-record-button-text',
                   'value' => 'Record'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-stop-button-text',
                   'value' => 'Stop'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-accept-button-text',
                   'value' => 'Select'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-recording-text',
                   'value' => 'Recording'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-recorded-text',
                   'value' => 'Recorded'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'upload-button-text',
                   'value' => 'Recorded Clip'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'recording-clip-text',
                   'value' => 'Record'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'remove-video-text',
                   'value' => 'Remove Personal Video Message'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-upload-text',
                   'value' => 'Upload'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-error-text',
                   'value' => 'Something went wrong'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'video-submit-text',
                   'value' => 'Your video has been uploaded'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'record-upload-butoon-primary-color',
                   'value' => '#D2D2D2'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'submit-button-text-color',
                   'value' => '#FFFFFF'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'record-upload-butoon-text-color',
                   'value' => '#000000'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'submit-button-primary-color',
                   'value' => '#F77E27'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'record-upload-butoon-secondary-color',
                   'value' => '#D2D2D2'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'submit-button-secondary-color',
                   'value' => '#FAD25D'
               ]
           );
           $configModel->save(); 
           $configModel->setData(
               [
                   'name' => 'button-banner',
                   'value' => ''
               ]
           );
           $configModel->save();          
         }
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config');
            $this->messageManager->addSuccess(__("You have registered successfully"));
            return $resultRedirect->setPath($url);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config');
        $this->messageManager->addError(__("Invalid Email / domain Entered"));
        return $resultRedirect->setPath($url);
    }
}
