<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\IPSISAPI;
use GAState\Tools\D2L\D2L;
use GAState\Tools\D2L\D2LRequest;
use GAState\Tools\D2L\Model\IPSIS\IPSISLogInfoRequestModel;

require __DIR__ . '/../vendor/autoload.php';

$d2l = new D2L(
    host: 'https://gastate.view.usg.edu',
    appID: '_w_1-FoGz9bvpDkkpKosCg',
    appKey: '9nsPV0SKQSPlR5jt6bCwDw',
    userID: 'BNoUN69hhbzGxyMJKaJ4CH',
    userKey: 'v7Ov5iVGj33pTrTant7w_8',
    rootOrgUnit: 1070555
);

// $params = [
//     'sourceSystemId' => '18',
//     'limit' => '150',
//     'startAfter' => '2022-05-20T18:36:30.510Z',
//     'startBefore' => 'null'
// ];

// $batches = $d2l->callAPI(request: 
//     new D2LRequest(
//         d2l: $d2l,
//         product: 'ipsis',
//         action: 'GET',
//         route: '/batches/ids', 
//         params: $params
//     )
// );

// var_dump($batches->data);

$ipsisAPI = new IPSISAPI($d2l);

$pagedLogInfo = $ipsisAPI->getLogEntries(
    sourceSystemId: '18',
    filters: new IPSISLogInfoRequestModel(
        values: (object) [
            "Search" => null,
            "BatchIds" => [],
            "SortOrder" => "Descending",
            "LogLevels" => ["Error"],
            "EntityTypes" => [],
            "Grouped" => false,
            "PageSize" => 5000,
            "Start" => "2022-08-20T00:00:00.000Z",
            "End" => null,
            "HashValue" => null
        ]
    )
);

$pagedLogInfo->Items = [
    count($pagedLogInfo->Items),
    array_pop($pagedLogInfo->Items),
];

var_dump($pagedLogInfo);
