<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LResponseException,
    Exception\D2LExpectedObjectException,
    Exception\D2LExpectedArrayException,
    Model\API\PagedResultSetModel,
    Model\User\CreateUserDataModel,
    Model\User\GoogleAppsLinkingItemModel,
    Model\User\LegalPreferredNamesModel,
    Model\User\UpdateUserDataModel,
    Model\User\UserDataModel,
    Model\User\UserPasswordDataModel,
    Model\User\UserProfileModel,
    Model\User\WhoAmIUserModel,
    Model\User\UserActivationDataModel,
    Model\User\UserRoleCopyDataModel,
    Model\User\UserRoleModel
};
use InvalidArgumentException;

/**
 * Users are the people participating in the Learning Platform’s services. There are a few actions that operate directly
 * upon user entities themselves, but most often they appear as factors in various other actions, identified by their 
 * associated UserId property (for example, the actions you’d use to find the courses a user is enrolled in are 
 * associated more directly with the enrollment and course resources).
 * 
 * @package GAState\Tools\D2L\API
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html
 */
class UsersAPI extends D2LAPI
{
    /**
     * Retrieve the current user context’s user information.
     * 
     * @return WhoAmIUserModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-whoami
     */
    public function whoAmI(): WhoAmIUserModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/users/whoami'
        );
        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }
        return new WhoAmIUserModel(values: $response->data);
    }

    /**
     * Retrieve data for all users.
     * 
     * @return array<int, UserDataModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-
     */
    public function listUsers(): array
    {
        /** @var callable(string|null $bookmark): PagedResultSetModel $callAPI*/
        $callAPI = [$this, 'getUsers'];

        /** @var array<int, UserDataModel> */
        return $this->pagedResultAPI(
            callAPI: $callAPI,
            keyField: 'UserId'
        );
    }

    /**
     * Retrieve data for all users.
     * 
     * @param string $bookmark Bookmark to use for fetching next data set segment.
     * 
     * @return PagedResultSetModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-
     */
    public function getUsers(string $bookmark = ''): PagedResultSetModel
    {
        $params = ['bookmark' => $bookmark];
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: '/users/',
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new PagedResultSetModel(
            values: $response->data,

            /** @return UserDataModel */
            createItem: function (object $values) {
                return new UserDataModel($values);
            }
        );
    }

    /**
     * Retrieve data for a particular user.
     * 
     * @param int|null $userId User ID.
     * @param string|null $orgDefinedId Org-defined identifier to look for.
     * @param string|null $userName User name to look for.
     * @param string|null $externalEmail External email address to look for.
     * 
     * @return UserDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-(userId)
     */
    public function getUser(
        ?int $userId = null,
        ?string $orgDefinedId = null,
        ?string $userName = null,
        ?string $externalEmail = null
    ): UserDataModel {
        if (
            $userId !== null &&
            ($orgDefinedId === null && $userName === null && $externalEmail === null)
        ) {
            $response = $this->callAPI(
                product: 'lp',
                action: 'GET',
                route: "/users/{$userId}"
            );
        } else if (
            $userId === null &&
            ($orgDefinedId !== null || $userName !== null || $externalEmail !== null)
        ) {
            $params = get_defined_vars();
            $response = $this->callAPI(
                product: 'lp',
                action: 'GET',
                route: "/users/",
                params: $params
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        if (is_array($response->data)) {
            if (count($response->data) !== 1) {
                throw new D2LResponseException(
                    response: $response,
                    message: 'Expected only one record. Please refine filter criteria'
                );
            }
            $response->data = is_object($response->data[0]) ? $response->data[0] : null;
        }

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserDataModel(values: $response->data);
    }

    /**
     * Create a new user entity.
     * 
     * @param CreateUserDataModel $newUser Data for new user.
     * 
     * @return UserDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#post--d2l-api-lp-(version)-users-
     */
    public function createUser(CreateUserDataModel $newUser): UserDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/users/",
            data: $newUser
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserDataModel(values: $response->data);
    }

    /**
     * Update data for a particular user.
     * 
     * @param int $userId User ID.
     * @param UpdateUserDataModel $updatedUser Updated data for user.
     * 
     * @return UserDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#put--d2l-api-lp-(version)-users-(userId)
     */
    public function updateUser(
        int $userId,
        UpdateUserDataModel $updatedUser
    ): UserDataModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/users/{$userId}",
            data: $updatedUser
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserDataModel(values: $response->data);
    }

    /**
     * Delete a particular user.
     * 
     * @param int $userId User ID
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#delete--d2l-api-lp-(version)-users-(userId)
     */
    public function deleteUser(int $userId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/users/{$userId}"
        );
    }

    /**
     * Retrieve legal, preferred, and sort names for a particular user.
     * 
     * @param int $userId User ID.
     * 
     * @return LegalPreferredNamesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-(userId)-names
     */
    public function getLegalPreferredNames(int $userId): LegalPreferredNamesModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/users/{$userId}/names"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new LegalPreferredNamesModel(values: $response->data);
    }

    /**
     * Update legal, preferred, and sort name data for a particular user.
     * 
     * @param int $userId User ID.
     * @param LegalPreferredNamesModel $updatedNames Updated names data for user.
     * 
     * @return LegalPreferredNamesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#put--d2l-api-lp-(version)-users-(userId)-names
     */
    public function updateLegalPreferredNames(
        int $userId,
        LegalPreferredNamesModel $updatedNames
    ): LegalPreferredNamesModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/users/{$userId}/names",
            data: $updatedNames
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new LegalPreferredNamesModel(values: $response->data);
    }

    /**
     * Update a particular user’s password.
     * 
     * The site admin for the back-end service can configure the characteristics for a valid password, and the API 
     * doesn’t provide a way to fetch these characteristics; rather than checking for a valid password form on the 
     * client side, we suggest that callers notice invalid new passwords based on the 400 error returned (invalid 
     * password provided) and then suggest the user should contact the site admin for guidance on how to submit a 
     * well-formed password.
     * 
     * @param int $userId User ID.
     * @param UserPasswordDataModel $passwordData Updated password for user.
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#put--d2l-api-lp-(version)-users-(userId)-password
     */
    public function updateUserPassword(
        int $userId,
        UserPasswordDataModel $passwordData
    ): void {
        $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/users/{$userId}/password",
            data: $passwordData
        );
    }

    /**
     * Reset a particular user’s password. This action prompts the service to send a password-reset email to the 
     * provided user.
     * 
     * @param int $userId User ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#post--d2l-api-lp-(version)-users-(userId)-password
     */
    public function resetUserPassword(int $userId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/users/{$userId}/password"
        );
    }

    /**
     * Clear a particular user’s password. This action deletes a user’s current password.
     * 
     * @param int $userId User ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#delete--d2l-api-lp-(version)-users-(userId)-password
     */
    public function clearUserPassword(int $userId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/users/{$userId}/password"
        );
    }

    /**
     * Retrieve a particular user’s activation settings.
     * 
     * @param int $userId User ID.
     * 
     * @return UserActivationDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-users-(userId)-activation
     */
    public function getUserActivation(int $userId): UserActivationDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/users/{$userId}/activation"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserActivationDataModel(values: $response->data);
    }

    /**
     * Update a particular user’s activation settings.
     * 
     * @param int $userId User ID.
     * @param UserActivationDataModel $updatedActivation Updated user activation settings for user.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#put--d2l-api-lp-(version)-users-(userId)-activation
     */
    public function updateUserActivation(
        int $userId,
        UserActivationDataModel $updatedActivation
    ): void {
        $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/users/{$userId}/activation",
            data: $updatedActivation
        );
    }

    /**
     * Retrieve a particular personal profile, by Profile ID.
     * 
     * @param string $profileId Profile ID
     * 
     * @return UserProfileModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-profile-(profileId)
     */
    public function getUserProfile(string $profileId): UserProfileModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/profile/{$profileId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserProfileModel(values: $response->data);
    }

    /**
     * Update a particular personal profile, by Profile ID.
     * 
     * @param string $profileId Profile ID.
     * @param UserProfileModel $updatedProfile Updated profile data for user profile.
     * 
     * @return UserProfileModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#put--d2l-api-lp-(version)-profile-(profileId)
     */
    public function updateUserProfile(
        string $profileId,
        UserProfileModel $updatedProfile
    ): UserProfileModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/profile/{$profileId}",
            data: $updatedProfile
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserProfileModel(values: $response->data);
    }

    /**
     * Terminate all active sessions for a user.
     * 
     * @param int $userId User ID.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#delete--d2l-api-lp-(version)-sessions-(userId)
     */
    public function terminateActiveUserSessions(int $userId): void
    {
        $this->callAPI(
            product: 'lp',
            action: 'PUT',
            route: "/sessions/{$userId}"
        );
    }

    /**
     * Link a user to a Google Apps user account.
     * 
     * @param GoogleAppsLinkingItemModel $userLink Linking data for user.
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#post--d2l-api-gae-(version)-linkuser
     */
    public function linkGoogleAppsUser(GoogleAppsLinkingItemModel $userLink): void
    {
        $this->callAPI(
            product: 'gae',
            action: 'POST',
            route: "/linkuser",
            data: $userLink
        );
    }

    /**
     * Retrieve a list of all known user roles.
     * 
     * @return array<UserRoleModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-roles-
     */
    public function listUserRoles(): array
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/roles/"
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $roles = [];
        foreach ($response->data as $values) {
            if (is_object($values)) {
                $roles[] = new UserRoleModel(values: $values);
            }
        }
        return $roles;
    }

    /**
     * Retrieve a particular user role.
     * 
     * @param int $roleId Role ID.
     * 
     * @return UserRoleModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-roles-(roleId)
     */
    public function getUserRole(int $roleId): UserRoleModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/roles/{$roleId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserRoleModel(values: $response->data);
    }


    /**
     * Retrieve a list of all the enrolled user roles the calling user can view in an org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * 
     * @return array<UserRoleModel>
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#get--d2l-api-lp-(version)-(orgUnitId)-roles-
     */
    public function listOrgUnitUserRoles(int $orgUnitId): array
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/{$orgUnitId}/roles/"
        );

        if (!is_array($response->data)) {
            throw new D2LExpectedArrayException(response: $response);
        }

        $roles = [];
        foreach ($response->data as $values) {
            if (is_object($values)) {
                $roles[] = new UserRoleModel(values: $values);
            }
        }
        return $roles;
    }

    /**
     * Create a new role copied from an existing role.
     * 
     * Provide a RoleCopyData JSON data block containing name to give to the new role. The back-end service creates a 
     * new role with this name, and copies over the permissions, properties, and capabiltiies of the role you identify 
     * with the deepCopyRoleId query parameter.
     * 
     * Note that this action conservatively copies inter-role capabilities:
     * - The new role will not have any capabilities at all upon the old role from which it was created. You will need 
     *   to manually create such capabilities after the copy (either via API or the standard user interface).
     * - The new role will only have some capabilities upon the new role: for example, if the users with the old role 
     *   had the ability to impersonate other users with the old role, then this impersonation capability will get 
     *   copies: new role users will be able to impersonate other new role users.
     * 
     * @param int $deepCopyRoleId Source role to act as template for new role.
     * @param UserRoleCopyDataModel $userRoleCopyData Properties for new role.
     * 
     * @return UserRoleModel
     * 
     * @see https://docs.valence.desire2learn.com/res/user.html#post--d2l-api-lp-(version)-roles-
     */
    public function copyRole(
        int $deepCopyRoleId,
        UserRoleCopyDataModel $userRoleCopyData
    ): UserRoleModel {
        $params = ['deepCopyRoleId' => $deepCopyRoleId];
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/roles/",
            params: $params,
            data: $userRoleCopyData
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new UserRoleModel(values: $response->data);
    }
}
