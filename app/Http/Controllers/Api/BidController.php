<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BidService;

class BidController extends Controller
{
    public $bidService;

    public function __construct(BidService $bidService)
    {
        $this->bidService = $bidService;
    }

    public function handleBidRequest()
    {
        $bidRequestJson = config('static.bidRequest');

        $campaigns = config('static.campaign');

        $response = $this->bidService->bidRequestProcess($bidRequestJson, $campaigns);

        return $response;

    }
    // {
    //     $jsonData = '[{
    //         "campaignname": "Test_Banner_13th-31st_march_Developer",
    //         "advertiser": "TestGP",
    //         "code": "118965F12BE33FB7E",
    //         "appid": "20240313103027",
    //         "tld": "https://adplaytechnology.com/",
    //         "portalname": "",
    //         "creative_type": "1",
    //         "creative_id": 167629,
    //         "day_capping": 0,
    //         "dimension": "320x480",
    //         "attribute": "rich-media",
    //         "url": "https://adplaytechnology.com/",
    //         "billing_id": "123456789",
    //         "price": 0.1,
    //         "bidtype": "CPM",
    //         "image_url": "https://s3-ap-southeast-1.amazonaws.com/elasticbeanstalk-ap-southeast-1-5410920200615/CampaignFile/20240117030213/D300x250/e63324c6f222208f1dc66d3e2daaaf06.png",
    //         "htmltag": "",
    //         "from_hour": "0",
    //         "to_hour": "23",
    //         "hs_os": "Android,iOS,Desktop",
    //         "operator": "Banglalink,GrameenPhone,Robi,Teletalk,Airtel,Wi-Fi",
    //         "device_make": "No Filter",
    //         "country": "Bangladesh",
    //         "city": "",
    //         "lat": "",
    //         "lng": "",
    //         "app_name": null,
    //         "user_list_id": "0",
    //         "adplay_logo": 1,
    //         "vast_video_duration": null,
    //         "logo_placement": 1,
    //         "hs_model": null,
    //         "is_rewarded_inventory": 0,
    //         "pixel_tag": null,
    //         "dmp_campaign_audience": 0,
    //         "platform": null,
    //         "open_publisher": 1,
    //         "audience_targeting": 0,
    //         "native_title": null,
    //         "native_type": null,
    //         "native_data_value": null,
    //         "native_data_cta": null,
    //         "native_data_rating": null,
    //         "native_data_price": null,
    //         "native_img_icon": null
    //     }]';

    //     return json_decode($jsonData, true);
    // }

}
