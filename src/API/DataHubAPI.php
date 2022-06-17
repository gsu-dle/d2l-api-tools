<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LException,
    Exception\D2LResponseException,
    Exception\D2LExpectedObjectException,
    Exception\D2LExpectedArrayException,
    Model\DataHub\DataSetDataModel,
    Model\DataHub\CreateExportJobDataModel,
    Model\DataHub\ExportJobDataModel,
    Model\DataHub\ExportJobStatusType,
    Model\DataHub\DataSetsVersionInfoModel,
    Model\DataHub\DataSetsReportInfoModel,
    Model\DataHub\BrightspaceDataSetReportInfoModel
};

/**
 * The Data Hub is a tool in the Learning Environment for generating and accessing data extracts. The data export 
 * framework is the API layer that the functionality of the Data Hub is built upon. These routes let you gather 
 * information about the back-end service and extract it in a useful format you can use with other tools for analysis or
 * reporting (for example, CSV).
 * 
 * @package GAState\Tools\D2L\API
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html
 */
class DataHubAPI extends D2LAPI
{
    /**
     * Lists all available data sets.
     * 
     * @return array<DataSetDataModel> This action retrieves a JSON array of DataSetData blocks.
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-list
     */
    public function listDataSets(): array
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/dataExport/list'
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $outputList = [];
        foreach ($response->data as $dataSetData) {
            if (is_object($dataSetData)) {
                $outputList[] = new DataSetDataModel(values: $dataSetData);
            }
        }

        return $outputList;
    }

    /**
     * Retrieve a data set.
     * 
     * @param string $dataSetId Data set identifier
     * 
     * @return DataSetDataModel This action retrieves a DataSetData JSON block containing the information for the 
     * requested data set.
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-list-(dataSetId)
     */
    public function getDataSet(string $dataSetId): DataSetDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/dataExport/list/{$dataSetId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new DataSetDataModel(values: $response->data);
    }

    /**
     * Create an export job for the requested data set.
     * 
     * @param CreateExportJobDataModel $createExportJob Properties of the export job request
     * 
     * @return ExportJobDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#post--d2l-api-lp-(version)-dataExport-create
     */
    public function createExportJob(CreateExportJobDataModel $createExportJob): ExportJobDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/dataExport/create",
            data: $createExportJob
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new ExportJobDataModel(values: $response->data);
    }

    /**
     * Lists all available export jobs that you have previously submitted. This action retrieves a JSON array of 
     * ExportJobData blocks, sorted by most recent SubmitDate. By default, only the first 100 records are retrieved. 
     * Additional records can be retrieved by specifying the optional page query string parameter.
     * 
     * @param int|null $page Page number to retrieve (page size is 100 records).
     * 
     * @return array<ExportJobDataModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-jobs
     */
    public function listExportJobs(?int $page = null): array
    {
        $params = ['page' => $page];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/dataExport/jobs',
            params: $params
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $outputList = [];
        foreach ($response->data as $dataSetData) {
            if (is_object($dataSetData)) {
                $outputList[] = new ExportJobDataModel(values: $dataSetData);
            }
        }

        return $outputList;
    }

    /**
     * Retrieves information about a data export job that you have previously submitted.
     * 
     * @param string $exportJobId Export job identifier.
     * 
     * @return ExportJobDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-jobs-(exportJobId)
     */
    public function getExportJob(string $exportJobId): ExportJobDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/dataExport/jobs/{$exportJobId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new ExportJobDataModel(values: $response->data);
    }

    /**
     * Retrieves a ZIP file containing a CSV file with the data of the requested export job that you previously 
     * submitted.
     * 
     * @param string $exportJobId Export job identifier.
     * @param string $downloadFilePath File location to save ZIP file that contains a CSV file that contains the data of
     * the export job that you requested.
     * 
     * @return int
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-download-(exportJobId)
     */
    public function downloadExportJob(
        string $exportJobId,
        string $downloadFilePath
    ): int {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/dataExport/download/{$exportJobId}",
            outputFile: $downloadFilePath
        );

        if (!is_numeric($response->data)) {
            // TODO: do i need an expected integer exception for this?
            throw new D2LResponseException(response: $response, message: 'Expected response->data to be an integer');
        }

        /** @var int */
        return $response->data;
    }

    /**
     * Create an export job for the requested data set and then retrieves a ZIP file containing a CSV file with the data
     * of the requested export job.
     * 
     * @param CreateExportJobDataModel $createExportJob Export job identifier.
     * @param string $downloadFilePath File location to save ZIP file that contains a CSV file that contains the data of
     * the export job that you requested.
     * @param int $timeout Number of seconds to wait until timing out on download
     * 
     * @return int
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#post--d2l-api-lp-(version)-dataExport-create
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-jobs-(exportJobId)
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-download-(exportJobId)
     */
    public function createAndDownloadDataExport(
        CreateExportJobDataModel $createExportJob,
        string $downloadFilePath,
        int $timeout = 3600
    ): int {
        $timeout += time();
        $exportJob = $this->createExportJob(createExportJob: $createExportJob);
        $jobStatus = $exportJob->Status;

        while ($jobStatus === ExportJobStatusType::Queued || $jobStatus === ExportJobStatusType::Processing) {
            if (time() > $timeout) {
                // TODO: need better exception
                throw new D2LException(message: 'Timeout');
            }
            sleep(10);
            $jobStatus = $this->getExportJob(exportJobId: $exportJob->ExportJobId)->Status;
        }

        if ($jobStatus !== ExportJobStatusType::Complete) {
            // TODO: need better exception
            throw new D2LException(message: 'status is not complete');
        }

        return $this->downloadExportJob(
            exportJobId: $exportJob->ExportJobId,
            downloadFilePath: $downloadFilePath
        );
    }

    /**
     * Retrieves information about the Data Sets versions.
     * 
     * @return DataSetsVersionInfoModel
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-version
     */
    public function getDataSetsVersions(): DataSetsVersionInfoModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/dataExport/version"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new DataSetsVersionInfoModel(values: $response->data);
    }

    /**
     * Retrieves a list of Brightspace Data Sets plugins that you have permission to see.
     * 
     * @return array<DataSetsReportInfoModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-bds-list
     */
    public function listBrightspaceDataSets(): array
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/dataExport/bds/list'
        );


        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $outputList = [];
        foreach ($response->data as $dataSetData) {
            if (is_object($dataSetData)) {
                $outputList[] = new DataSetsReportInfoModel(values: $dataSetData);
            }
        }

        return $outputList;
    }

    /**
     * Retrieves a list of Brightspace Data Sets plugins that you have permission to see.
     * 
     * @return array<BrightspaceDataSetReportInfoModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-bds
     */
    public function getBrightspaceDataSets(): array
    {
        $page = 0;
        $datasets = [];

        do {
            $params = ['page' => ++$page, 'pageSize' => 100];
            $response = $this->callAPI(
                product: 'lp',
                action: 'GET',
                route: '/dataExport/bds',
                params: $params
            );

            if (!is_object($response->data)) {
                throw new D2LExpectedObjectException(response: $response);
            }
            if (!property_exists($response->data, "BrightspaceDataSets") || !is_array($response->data->BrightspaceDataSets)) {
                throw new D2LExpectedArrayException(response: $response);
            }

            foreach ($response->data->BrightspaceDataSets as $dataSet) {
                $datasets[] = new BrightspaceDataSetReportInfoModel($dataSet);
            }
        } while (count($response->data->BrightspaceDataSets) > 0);

        return $datasets;
    }

    /**
     * Retrieves a file stream for the requested Brightspace Data Sets plugin.
     * 
     * @param string $downloadFilePath File location to save ZIP file that contains a CSV file that contains the data of
     * the requested Brightspace Data Set plugin.
     * @param string $pluginId  Plugin identifier.
     * @param string|null $identifier Scheduled export identifier.
     * 
     * @return int
     * 
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-bds-download-(pluginid)
     * @see https://docs.valence.desire2learn.com/res/dataExport.html#get--d2l-api-lp-(version)-dataExport-bds-(pluginid)-(identifier)
     */
    public function downloadBrightspaceDataSet(
        string $downloadFilePath,
        string $pluginId,
        ?string $identifier = null
    ): int {
        if ($identifier !== null) {
            $response = $this->callAPI(
                product: 'lp',
                action: 'GET',
                route: "/dataExport/bds/{$pluginId}/{$identifier}",
                outputFile: $downloadFilePath
            );
        } else {
            $response = $this->callAPI(
                product: 'lp',
                action: 'GET',
                route: "/dataExport/bds/download/{$pluginId}",
                outputFile: $downloadFilePath
            );
        }

        if (!is_numeric($response->data)) {
            // TODO: do i need an expected integer exception for this?
            throw new D2LResponseException(response: $response, message: 'Expected response->data to be an integer');
        }

        /** @var int */
        return $response->data;
    }
}
