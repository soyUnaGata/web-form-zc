<?php

namespace App\Http\Controllers;

use App\DTOs\RecordCreationResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\DealRequest;
use App\Models\Account;
use App\Models\Deal;
use App\Services\ZohoCrmApi;


class DealController extends Controller
{
    private $zohoCrmApi;

    public function __construct(ZohoCrmApi $zohoCrmApi)
    {
        $this->zohoCrmApi = $zohoCrmApi;
    }

    public function __invoke(DealRequest $request)
    {
        $data = $request->validated();

        $deal = new Deal($data['name'], $data['stage']);
        $isDealCreated =  $this->zohoCrmApi->UpsertDeal($deal);

        if (!$isDealCreated){
            return 'Something went wrong';
        }

        $account = new Account($data['accName'], $data['accSite'], $data['accPhone']);
        $isAccountCreated = $this->zohoCrmApi->UpsertAccount($account);

        if (!$isAccountCreated){
            return 'Something went wrong';
        }

        return 'Deal and Account have been created successfully.';
    }
}
