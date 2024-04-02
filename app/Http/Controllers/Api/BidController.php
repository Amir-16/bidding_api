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
        $bidRequestJson = config('static.bidRequest1'); //given request

        //$bidRequestJson = config('static.bidRequest2'); // test bid request

        $campaigns = config('static.campaign');

        $response = $this->bidService->bidRequestProcess($bidRequestJson, $campaigns);

        return $response;
    }
}
