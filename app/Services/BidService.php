<?php

namespace App\Services;

use App\Traits\ApiManage;

class BidService
{
    use ApiManage;

    public function bidRequestProcess(string $bidRequestJson, array $campaignData)
    {
        $bidRequest = json_decode($bidRequestJson, true);

        // Validate bid request parameters
        if (
            ! isset($bidRequest['device']) ||
            ! isset($bidRequest['app']['publisher']['ext']['country']) ||
            ! isset($bidRequest['imp'][0]['banner']['format'][0]['w']) ||
            ! isset($bidRequest['imp'][0]['banner']['format'][0]['h']) ||
            ! isset($bidRequest['imp'][0]['bidfloor']) ||
            ! isset($bidRequest['imp'][0]['bidfloorcur'])
        ) {

            return $this->errorResponse('Invalid bid request parameters', 422);
        }
        // Extract bid request parameters
        $device = $bidRequest['device']['make'].' '.$bidRequest['device']['model'];
        $country = $bidRequest['app']['publisher']['ext']['country'];
        $adFormat = $bidRequest['imp'][0]['banner']['format'][0]['w'].'x'.$bidRequest['imp'][0]['banner']['format'][0]['h'];
        $bidFloor = $bidRequest['imp'][0]['bidfloor'];

        $campaigns = $campaignData;

        $eligibleCampaigns = [];
        foreach ($campaigns as $campaign) {
            if (
                strpos(strtolower($campaign['hs_os']), $bidRequest['device']['os']) !== false &&
                strpos($campaign['country'], $country) !== false &&
                $campaign['price'] >= $bidFloor &&
                $campaign['dimension'] == $adFormat
            ) {
                $eligibleCampaigns[] = $campaign;
            }
        }

        // Select campaign with highest bid price
        if (empty($eligibleCampaigns)) {

            return $this->errorResponse('No eligible campaigns found', 404);
        } else {
            $selectedCampaign = $this->selectCampaign($eligibleCampaigns);
            $campaignResponse = $this->generateCampaignResponse($selectedCampaign);

            return $this->successResponse($campaignResponse);
        }
    }

    //select campaign 
    private function selectCampaign(array $eligibleCampaigns)
    {
        usort($eligibleCampaigns, function ($a, $b) {
            return $b['price'] <=> $a['price'];
        });

        return $eligibleCampaigns[0];
    }

    //return response as format
    private function generateCampaignResponse(array $selectedCampaign)
    {
        return [
            'bidPrice' => $selectedCampaign['price'],
            'adID' => uniqid(),
            'creativeID' => uniqid(),
            'name' => $selectedCampaign['campaignname'],
            'advertiser' => $selectedCampaign['advertiser'],
            'creativeType' => $selectedCampaign['creative_type'],
            'imageURL' => $selectedCampaign['image_url'],
            'landingPageURL' => $selectedCampaign['url'],
        ];
    }
}
