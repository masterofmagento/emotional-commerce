<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Campaigns extends Config
{

    public function getCampaigns($key, $secret, $domain)
    {
        $campaigns = $this->apiHelper->getCampaigns($key, $secret, $domain);

        if (!$campaigns['success']) {
            return false;
        }

        return $campaigns;
    }

    public function getCampaignsActionUrl($id, $themeId)
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/campaigns', ['id' => $id, 'theme'=>$themeId]);
    }
    public function getImpersonateUrl()
    {
        $impersonateUrl = $this->apiHelper->getImpersonateUrl();     
        return $impersonateUrl;
    }

    public function getDefaultThemes($key, $secret, $domain)
    {
        $themes = $this->apiHelper->getThemes($key, $secret, $domain);
        if (!$themes['success']) {
            return false;
        }
        return $themes;
    }   
}
