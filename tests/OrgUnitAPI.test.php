<?php

declare(strict_types=1);

use GAState\Tools\D2L\{
    API\OrgUnitAPI,
    Exception\D2LException,
    Model\DataHub\CreateExportJobDataModel,
    Exception\D2LResponseException,
    Model\DataHub\ExportJobStatusType
};

global $d2l;

require 'Bootstrap.php';

main: {
    $orgUnitAPI = new OrgUnitAPI($d2l);

    try {
        //var_dump($orgUnitAPI->getOrganization());

        //var_dump($orgUnitAPI->getOrganizationRootURL());

        //var_dump($orgUnitAPI->listOrgUnitProperties(orgUnitType: '1'));

        var_dump($orgUnitAPI->getOrgUnitProperties(1070555));
    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}
