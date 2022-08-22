<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\Exception\D2LExpectedObjectException;
use GAState\Tools\D2L\Model\IPSIS\IPSISLogInfoRequestModel;
use GAState\Tools\D2L\Model\IPSIS\PagedIPSISLogInfoModel;

class IPSISAPI extends D2LAPI
{
    /**
     * @param string $sourceSystemId
     * @param IPSISLogInfoRequestModel $filters
     * 
     * @return PagedIPSISLogInfoModel
     */
    public function getLogEntries(
        string $sourceSystemId,
        IPSISLogInfoRequestModel $filters
    ): PagedIPSISLogInfoModel {
        $response = $this->callAPI(
            product: 'ipsis',
            action: 'POST',
            route: '/logs/', 
            params: ['sourceSystemId' => $sourceSystemId],
            data: json_encode($filters)
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedIPSISLogInfoModel(values: $response->data);
    }
}
