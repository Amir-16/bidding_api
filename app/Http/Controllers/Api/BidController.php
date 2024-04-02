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

        $campaigns = config('static.campaign1');  //given campaign

        //$campaigns = config('static.campaign2');  // test campaign found response

        $response = $this->bidService->bidRequestProcess($bidRequestJson, $campaigns);

        return $response;
    }
}
