<?php

declare(strict_types=1);

use GAState\Tools\D2L\{
    API\DataHubAPI,
    Exception\D2LException,
    Model\DataHub\CreateExportJobDataModel,
    Exception\D2LResponseException,
    Model\DataHub\ExportJobStatusType
};

global $d2l;

require 'Bootstrap.php';

main: {
    $dataHubAPI = new DataHubAPI($d2l);

    try {
        //var_dump($dataHubAPI->listDataSets());

        //var_dump($dataHubAPI->getDataSet(dataSetId: 'c1bf7603-669f-4bef-8cf4-651b914c4678'));

        //var_dump($dataHubAPI->listExportJobs());

        // var_dump($dataHubAPI->downloadExportJob(
        //     exportJobId: "7a096e94-2c48-4c6c-8025-c1e43de84818",
        //     downloadFilePath: __DIR__ . '/test.zip'
        // ));

        // var_dump($dataHubAPI->createAndDownloadDataExport(
        //     createExportJob: new CreateExportJobDataModel((object)([
        //         "DataSetId" => 'c1bf7603-669f-4bef-8cf4-651b914c4678',
        //         "Filters" => [
        //             (object)([
        //                 "Name" => "parentOrgUnitId",
        //                 "Value" => $d2l->rootOrgUnit
        //             ]),
        //             (object)([
        //                 "Name" => "startDate",
        //                 "Value" => D2L::convertToUTC(date('Y-m-d\T00:00:00P', strtotime('-10 months')))
        //             ]),
        //             (object)([
        //                 "Name" => "endDate",
        //                 "Value" => D2L::convertToUTC(date('Y-m-d\T23:59:59P', strtotime('-1 day')))
        //             ])
        //         ]
        //     ])),
        //     downloadFilePath: __DIR__ . '/test.zip'
        // ));

        //var_dump($dataHubAPI->getDataSetsVersions());

        //var_dump($dataHubAPI->listBrightspaceDataSets());

        $datasets = $dataHubAPI->getBrightspaceDataSets();

        $full = [];
        $diff = [];
        foreach ($datasets as $dataset) {
            if (stripos($dataset->Name, 'Differential') === false) {
                $full[$dataset->Name] = $dataset;
            } else {
                $diff[trim(str_ireplace('Differential', '', $dataset->Name))] = $dataset;
            }
        }

        echo "INSERT IGNORE INTO DataHubDataset\n";
        echo "  (PluginId, ParentPluginId, Name, Description, FilePrefix)  \n";
        echo "VALUES                           \n";

        $separator = '';
        foreach ($full as $name => $dataset) {
            $filePrefix = str_replace(' ', '', $dataset->Name);
            $description = str_replace("'", "''", $dataset->Description);
            echo "{$separator}('{$dataset->PluginId}',null,'{$dataset->Name}','{$description}','{$filePrefix}')";
            if ($separator === '') $separator = ",\n  ";
        }
        echo "\n;\n\n";

        echo "INSERT IGNORE INTO DataHubDataset\n";
        echo "  (PluginId, ParentPluginId, Name, Description, FilePrefix)  \n";
        echo "VALUES                           \n";
        foreach ($diff as $name => $dataset) {
            $filePrefix = str_replace(' ', '', str_ireplace('Differential', 'Diff', $dataset->Name));
            $description = str_replace("'", "''", $dataset->Description);
            $parentPluginId = $full[$name]->PluginId ?? '';
            echo "{$separator}('{$dataset->PluginId}','{$parentPluginId}','{$dataset->Name}','{$description}','{$filePrefix}')";
            if ($separator === '') $separator = ",\n  ";
        }
        echo "\n;\n\n";

        exit;

        echo "
INSERT IGNORE INTO DataHubDataset
    (PluginId, Name, Description)
VALUES
";
        foreach ($datasets as $dataset) {
            if (stripos($dataset->Name, 'Quiz') !== false) {
                echo "  ('{$dataset->PluginId}','{$dataset->Name}','{$dataset->Description}'),\n";
            }
        }

        //file_put_contents(__DIR__ . '/test.json', json_encode($dataHubAPI->getBrightspaceDataSets(), JSON_PRETTY_PRINT));

        // var_dump($dataHubAPI->downloadBrightspaceDataSet(
        //     pluginId: "e8339b7a-2d32-414e-9136-2adf3215a09c",
        //     identifier: strval(strtotime("2022-04-11T06:30:04.000Z")),
        //     downloadFilePath: __DIR__ . '/Users.zip'
        // ));
    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}
