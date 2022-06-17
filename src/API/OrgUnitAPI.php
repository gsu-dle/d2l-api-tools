<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LExpectedArrayException,
    Exception\D2LExpectedObjectException,
    Model\API\PagedResultSetModel,
    Model\OrgUnit\CreateOrgUnitTypeData,
    Model\OrgUnit\OrganizationModel,
    Model\OrgUnit\OrgUnitColourSchemeModel,
    Model\OrgUnit\OrgUnitCreateDataModel,
    Model\OrgUnit\OrgUnitModel,
    Model\OrgUnit\OrgUnitPropertiesModel,
    Model\OrgUnit\OrgUnitTypeModel
};

/**
 * These actions and structures provide access to the organization structure configured for an LMS. The structure is 
 * grouped into generic nodes called _org units_ (organizational units). An org unit node can represent several 
 * different kinds of things within an LMS and the institution determines the precise mixture of custom `org unit types`
 * available through its LMS. However, by default, an LMS comes with several built-in org unit types (course offerings, 
 * departments, semesters) fundamental to most learning institutions.
 * 
 * @package GAState\Tools\D2L\API
 * @access public
 * @see https://docs.valence.desire2learn.com/res/orgunit.html
 */
class OrgUnitAPI extends D2LAPI
{
    /**
     * Retrieve the organization properties information.
     * 
     * @return OrganizationModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-organization-info
     */
    public function getOrganization(): OrganizationModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/organization/info"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrganizationModel(values: $response->data);
    }

    /**
     * Retrieve the organization’s primary (root) URL.
     * 
     * @return string
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-organization-primary-url
     */
    public function getOrganizationRootURL(): string
    {
        return strval($this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/organization/primary-url"
        )->data);
    }

    /**
     * Delete the relationship between a provided org unit and one of its children.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param int $childOrgUnitId Org unit ID for the child to detach.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#delete--d2l-api-lp-(version)-orgstructure-(orgUnitId)-children-(childOrgUnitId)
     */
    public function deleteOrgUnitChild(int $orgUnitId, int $childOrgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/orgstructure/{$orgUnitId}/children/{$childOrgUnitId}"
        );
    }

    /**
     * Delete the relationship between a provided org unit and one of its parents.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param int $parentOrgUnitId Org unit ID for the parent to detach.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#delete--d2l-api-lp-(version)-orgstructure-(orgUnitId)-parents-(parentOrgUnitId)
     */
    public function deleteOrgUnitParent(int $orgUnitId, int $parentOrgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/orgstructure/{$orgUnitId}/parents/{$parentOrgUnitId}"
        );
    }

    /**
     * Retrieve properties for all org units.
     * 
     * @param string|null $orgUnitType Filter to org units with type matching this org unit type ID.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * @param string|null $exactOrgUnitCode Filter to org units with codes precisely matching this string. Overrides 
     * orgUnitCode.
     * @param string|null $exactOrgUnitName Filter to org units with names precisely matching this string. Overrides 
     * orgUnitName.
     * 
     * @return array<OrgUnitPropertiesModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-
     */
    public function listOrgUnitProperties(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null,
        ?string $exactOrgUnitCode = null,
        ?string $exactOrgUnitName = null
    ): array {
        /** @var OrgUnitAPI $that */
        $that = $this;

        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = function (?string $bookmark) use (
            $that,
            $orgUnitType,
            $orgUnitCode,
            $orgUnitName,
            $exactOrgUnitCode,
            $exactOrgUnitName
        ) {
            return $that->getOrgUnitsProperties(
                orgUnitType: $orgUnitType,
                orgUnitCode: $orgUnitCode,
                orgUnitName: $orgUnitName,
                bookmark: $bookmark,
                exactOrgUnitCode: $exactOrgUnitCode,
                exactOrgUnitName: $exactOrgUnitName
            );
        };

        /** @var array<OrgUnitPropertiesModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve properties for all org units.
     * 
     * @param string|null $orgUnitType Filter to org units with type matching this org unit type ID.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * @param string|null $bookmark Bookmark to use for fetching next data set segment.
     * @param string|null $exactOrgUnitCode Filter to org units with codes precisely matching this string. Overrides 
     * orgUnitCode.
     * @param string|null $exactOrgUnitName Filter to org units with names precisely matching this string. Overrides 
     * orgUnitName.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-
     */
    public function getOrgUnitsProperties(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null,
        ?string $bookmark = null,
        ?string $exactOrgUnitCode = null,
        ?string $exactOrgUnitName = null
    ): PagedResultSetModel {
        $params = get_defined_vars();
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,
            createItem: function (object $item) {
                return new OrgUnitPropertiesModel(values: $item);
            }
        );
    }

    /**
     * Retrieve the properties for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return OrgUnitModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)
     */
    public function getOrgUnitProperties(int $orgUnitId): OrgUnitModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitModel(values: $response->data);
    }

    /**
     * Retrieve all org units that have no children.
     * 
     * @param string|null $orgUnitType Filter to org units of this type.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * 
     * @return array<OrgUnitPropertiesModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-childless-
     */
    public function listChildlessOrgUnits(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null
    ): array {
        /** @var OrgUnitAPI $that */
        $that = $this;

        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = function (?string $bookmark) use (
            $that,
            $orgUnitType,
            $orgUnitCode,
            $orgUnitName
        ) {
            return $that->getChildlessOrgUnits(
                orgUnitType: $orgUnitType,
                orgUnitCode: $orgUnitCode,
                orgUnitName: $orgUnitName,
                bookmark: $bookmark
            );
        };

        /** @var array<OrgUnitPropertiesModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve all org units that have no children.
     * 
     * @param string|null $orgUnitType Filter to org units of this type.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * @param string|null $bookmark Bookmark to use for fetching next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-childless-
     */
    public function getChildlessOrgUnits(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null,
        ?string $bookmark = null
    ): PagedResultSetModel {
        $params = get_defined_vars();
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/childless/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,
            createItem: function (object $item) {
                return new OrgUnitPropertiesModel(values: $item);
            }
        );
    }

    /**
     * Retrieve all org units that are orphans (have no parents).
     * 
     * @param string|null $orgUnitType Filter to org units of this type.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * 
     * @return array<OrgUnitPropertiesModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-orphans-
     */
    public function listOrphanOrgUnits(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null
    ): array {
        /** @var OrgUnitAPI $that */
        $that = $this;

        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = function (?string $bookmark) use (
            $that,
            $orgUnitType,
            $orgUnitCode,
            $orgUnitName
        ) {
            return $that->getOrphanOrgUnits(
                orgUnitType: $orgUnitType,
                orgUnitCode: $orgUnitCode,
                orgUnitName: $orgUnitName,
                bookmark: $bookmark
            );
        };

        /** @var array<OrgUnitPropertiesModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve all org units that are orphans (have no parents).
     * 
     * @param string|null $orgUnitType Filter to org units of this type.
     * @param string|null $orgUnitCode Filter to org units with codes containing this substring.
     * @param string|null $orgUnitName Filter to org units with names containing this substring.
     * @param string|null $bookmark Bookmark to use for fetching next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-orphans-
     */
    public function getOrphanOrgUnits(
        ?string $orgUnitType = null,
        ?string $orgUnitCode = null,
        ?string $orgUnitName = null,
        ?string $bookmark = null
    ): PagedResultSetModel {
        $params = get_defined_vars();
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/childless/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,
            createItem: function (object $item) {
                return new OrgUnitPropertiesModel(values: $item);
            }
        );
    }

    /**
     * Retrieve a list of ancestor-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * 
     * @return array<OrgUnitModel>
     */
    public function getOrgUnitAncestors(
        int $orgUnitId,
        ?string $ouTypeId = null
    ): array {
        $params = ["ouTypeId" => $ouTypeId];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}/ancestors/",
            params: $params
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $ancestors = [];
        foreach ($response->data as $id => $values) {
            if (is_object($values)) {
                $ancestors[] = new OrgUnitModel(values: $values);
            }
        }

        return $ancestors;
    }

    /**
     * Retrieve a list of child-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * 
     * @return array<OrgUnitModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)-children-paged-
     */
    public function listOrgUnitChildren(
        int $orgUnitId,
        ?string $ouTypeId = null
    ): array {
        /** @var OrgUnitAPI $that */
        $that = $this;

        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = function (?string $bookmark) use (
            $that,
            $orgUnitId,
            $ouTypeId
        ) {
            return $that->getOrgUnitChildren(
                orgUnitId: $orgUnitId,
                ouTypeId: $ouTypeId,
                bookmark: $bookmark
            );
        };

        /** @var array<OrgUnitModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve a list of child-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * @param string|null $bookmark Bookmark to use for fetching the next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)-children-paged-
     */
    public function getOrgUnitChildren(
        int $orgUnitId,
        ?string $ouTypeId = null,
        ?string $bookmark = null
    ): PagedResultSetModel {
        $params = ['ouTypeId' => $ouTypeId, 'bookmark' => $bookmark];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}/children/paged/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,
            createItem: function (object $item) {
                return new OrgUnitModel(values: $item);
            }
        );
    }

    /**
     * Retrieve a list of descendent-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * 
     * @return array<OrgUnitModel>
     */
    public function listOrgUnitDescendants(
        int $orgUnitId,
        ?string $ouTypeId = null
    ): array {
        /** @var OrgUnitAPI $that */
        $that = $this;

        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = function (?string $bookmark) use (
            $that,
            $orgUnitId,
            $ouTypeId
        ) {
            return $that->getOrgUnitDescendants(
                orgUnitId: $orgUnitId,
                ouTypeId: $ouTypeId,
                bookmark: $bookmark
            );
        };

        /** @var array<OrgUnitModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve a list of descendent-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * @param string|null $bookmark Bookmark to use for fetching the next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)-descendants-paged-
     */
    public function getOrgUnitDescendants(
        int $orgUnitId,
        ?string $ouTypeId = null,
        ?string $bookmark = null
    ): PagedResultSetModel {
        $params = ['ouTypeId' => $ouTypeId, 'bookmark' => $bookmark];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}/descendants/paged/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,
            createItem: function (object $item) {
                return new OrgUnitModel(values: $item);
            }
        );
    }

    /**
     * Retrieve a list of parent-units for a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param string|null $ouTypeId Filter retrieved list by this org unit type.
     * 
     * @return array<OrgUnitModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)-parents-
     */
    public function getOrgUnitParents(
        int $orgUnitId,
        ?string $ouTypeId = null
    ): array {
        $params = ["ouTypeId" => $ouTypeId];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}/parents/",
            params: $params
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $parents = [];
        foreach ($response->data as $id => $values) {
            if (is_object($values)) {
                $parents[] = new OrgUnitModel(values: $values);
            }
        }

        return $parents;
    }

    /**
     * Create a new custom org unit.
     * 
     * @param OrgUnitCreateDataModel $createdOrgUnit Data for new custom org unit.
     * 
     * @return OrgUnitModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-orgstructure-
     */
    public function createOrgUnit(OrgUnitCreateDataModel $createdOrgUnit): OrgUnitModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/",
            data: $createdOrgUnit
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitModel(values: $response->data);
    }

    /**
     * Give the provided org unit a new child org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param int $childOrgUnitId Org unit to add as a child.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-orgstructure-(orgUnitId)-children-
     */
    public function createOrgUnitChild(int $orgUnitId, int $childOrgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/{$orgUnitId}/children/",
            data: strval($childOrgUnitId)
        );
    }

    /**
     * Give the provided org unit a new parent org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param int $parentOrgUnitId Org unit to add as a parent.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-orgstructure-(orgUnitId)-parents-
     */
    public function createOrgUnitParent(int $orgUnitId, int $parentOrgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/{$orgUnitId}/parents/",
            data: strval($parentOrgUnitId)
        );
    }

    /**
     * Update a custom org unit’s properties
     * 
     * @param int $orgUnitId Org unit to update.
     * @param OrgUnitPropertiesModel $updatedOrgUnit Data for new custom org unit.
     * 
     * @return OrgUnitPropertiesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#put--d2l-api-lp-(version)-orgstructure-(orgUnitId)
     */
    public function updateOrgUnit(int $orgUnitId, OrgUnitPropertiesModel $updatedOrgUnit): OrgUnitPropertiesModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/{$orgUnitId}",
            data: $updatedOrgUnit
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitPropertiesModel(values: $response->data);
    }

    /**
     * Retrieve the colour scheme for an org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return OrgUnitColourSchemeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-(orgUnitId)-colours
     */
    public function getOrgUnitColourScheme(int $orgUnitId): OrgUnitColourSchemeModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/orgstructure/{$orgUnitId}/colours"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitColourSchemeModel(values: $response->data);
    }

    /**
     * Set a new colour scheme for an org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param OrgUnitColourSchemeModel $updatedColourScheme New colour scheme for org unit.
     * 
     * @return OrgUnitColourSchemeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#put--d2l-api-lp-(version)-orgstructure-(orgUnitId)-colours
     */
    public function setOrgUnitColourScheme(
        int $orgUnitId,
        OrgUnitColourSchemeModel $updatedColourScheme
    ): OrgUnitColourSchemeModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/orgstructure/{$orgUnitId}/colours",
            data: $updatedColourScheme
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitColourSchemeModel(values: $response->data);
    }

    /**
     * Permanently delete an org unit from the recycle bin.
     * 
     * __Note:__ You can only delete an org unit using this action if the org unit has already been sent to the recycle 
     * bin.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#delete--d2l-api-lp-(version)-orgstructure-recyclebin-(orgUnitId)
     */
    public function deleteOrgUnit(int $orgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/orgstructure/recyclebin/{$orgUnitId}",
        );
    }

    /**
     * Retrieve all the org units currently in the recycle bin.
     * 
     * @return array<OrgUnitPropertiesModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-recyclebin-
     */
    public function listOrgUnitRecycleBin(): array
    {
        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = [$this, 'getOrgUnitRecycleBin'];

        /** @var array<int, OrgUnitPropertiesModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * Retrieve all the org units currently in the recycle bin.
     * 
     * @param string|null $bookmark Bookmark to use for fetching the next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-orgstructure-recyclebin-
     */
    public function getOrgUnitRecycleBin(?string $bookmark = null): PagedResultSetModel
    {
        $params = ['bookmark' => $bookmark];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/orgstructure/recyclebin/',
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,

            /** @return OrgUnitPropertiesModel */
            createItem: function (object $values) {
                return new OrgUnitPropertiesModel($values);
            }
        );
    }

    /**
     * Send an org unit to the recycle bin.
     * 
     * __Note__: Using this action has the same effect as deleting the org unit via the OrgUnit Editor (and placing it 
     * in the recycling bin) in the Brightspace UI.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-orgstructure-recyclebin-(orgUnitId)-recycle
     */
    public function recycleOrgUnit(int $orgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/recyclebin/{$orgUnitId}/recycle",
        );
    }

    /**
     * Restore an org unit from the recycle bin.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return void
     */
    public function restoreOrgUnit(int $orgUnitId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/orgstructure/recyclebin/{$orgUnitId}/restore",
        );
    }

    /**
     * Delete a particular org unit type.
     * 
     * @param int $orgUnitTypeId Org unit type ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#delete--d2l-api-lp-(version)-outypes-(orgUnitTypeId)
     */
    public function deleteOrgUnitType(int $orgUnitTypeId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/outypes/{$orgUnitTypeId}",
        );
    }

    /**
     * Retrieve all the known and visible org unit types.
     * 
     * @return array<OrgUnitTypeModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-outypes-
     */
    public function listOrgUnitTypes(): array
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/outypes/"
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $orgUnitTypes = [];
        foreach ($response->data as $id => $values) {
            if (is_object($values)) {
                $orgUnitTypes[] = new OrgUnitTypeModel(values: $values);
            }
        }

        return $orgUnitTypes;
    }

    /**
     * Retrieve information about a particular org unit type.
     * 
     * @param int $orgUnitTypeId Org unit type ID.
     * 
     * @return OrgUnitTypeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-outypes-(orgUnitTypeId)
     */
    public function getOrgUnitType(int $orgUnitTypeId): OrgUnitTypeModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/outypes/{$orgUnitTypeId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitTypeModel(values: $response->data);
    }

    /**
     * Retrieve the org unit type information for department org units.
     * 
     * @return OrgUnitTypeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-outypes-department
     */
    public function getDepartmentOrgUnitType(): OrgUnitTypeModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/outypes/department"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitTypeModel(values: $response->data);
    }

    /**
     * Retrieve the org unit type information for semester org units.
     * 
     * @return OrgUnitTypeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#get--d2l-api-lp-(version)-outypes-semester
     */
    public function getSemesterOrgUnitType(): OrgUnitTypeModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/outypes/semester"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitTypeModel(values: $response->data);
    }

    /**
     * Create a new custom org unit type.
     * 
     * @param CreateOrgUnitTypeData $newOrgUnitType Data for new custom org unit type.
     * 
     * @return OrgUnitTypeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-outypes-
     */
    public function createOrgUnitType(CreateOrgUnitTypeData $newOrgUnitType): OrgUnitTypeModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/outypes/",
            data: $newOrgUnitType
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitTypeModel(values: $response->data);
    }

    /**
     * Update a particular org unit type.
     * 
     * @param int $orgUnitTypeId Org unit type ID.
     * @param CreateOrgUnitTypeData $updatedOrgUnitType Updated data for custom org unit type.
     * 
     * @return OrgUnitTypeModel
     * 
     * @see https://docs.valence.desire2learn.com/res/orgunit.html#post--d2l-api-lp-(version)-outypes-(orgUnitTypeId)
     */
    public function updateOrgUnitType(
        int $orgUnitTypeId,
        CreateOrgUnitTypeData $updatedOrgUnitType
    ): OrgUnitTypeModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/outypes/{$orgUnitTypeId}",
            data: $updatedOrgUnitType
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new OrgUnitTypeModel(values: $response->data);
    }
}
