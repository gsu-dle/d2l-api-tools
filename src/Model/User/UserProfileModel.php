<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This block contains a user’s personal profile data.
 * 
 * Profile images - As they’re binary data, profile images get provided, or fetched, directly and not as part of the 
 * UserProfile JSON structure. Clients can provide any valid image file that’s typically renderable in a browser (for 
 * example, JPEG, GIF, or PNG). The back-end service expects to receive a file named “profileImage”, but is not 
 * case-sensitive (so “PROFILEIMAGE” will also work, as will “ProfileImage”).
 * 
 * The actions that retrieve a user’s profile image let you specify an expected size, prompting the service to re-size 
 * the image to a useful dimension. You may want to perform ad-hoc testing against your back-end service to determine 
 * the best sizes to ask for: the service will send you back an image that’s at least as large on each side (in pixels) 
 * as the size value you provide.
 * 
 * Currently, the default size for the profile image is 300 pixels in height and width.
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see 
 */
class UserProfileModel extends D2LModel
{
    /**
     * @var string $Nickname
     */
    public string $Nickname = '';

    /**
     * @var UserProfileBirthdayModel|null $Birthday
     */
    public ?UserProfileBirthdayModel $Birthday = null;

    /**
     * @var string $HomeTown
     */
    public string $HomeTown = '';

    /**
     * @var string $Email
     */
    public string $Email = '';

    /**
     * @var string $HomePage
     */
    public string $HomePage = '';

    /**
     * @var string $HomePhone
     */
    public string $HomePhone = '';

    /**
     * @var string $BusinessPhone
     */
    public string $BusinessPhone = '';

    /**
     * @var string $MobilePhone
     */
    public string $MobilePhone = '';

    /**
     * @var string $FaxNumber
     */
    public string $FaxNumber = '';

    /**
     * @var string $Address1
     */
    public string $Address1 = '';

    /**
     * @var string $Address2
     */
    public string $Address2 = '';

    /**
     * @var string $City
     */
    public string $City = '';

    /**
     * @var string $Province
     */
    public string $Province = '';

    /**
     * @var string $PostalCode
     */
    public string $PostalCode = '';

    /**
     * @var string $Country
     */
    public string $Country = '';

    /**
     * @var string $Company
     */
    public string $Company = '';

    /**
     * @var string $JobTitle
     */
    public string $JobTitle = '';

    /**
     * @var string $HighSchool
     */
    public string $HighSchool = '';

    /**
     * @var string $University
     */
    public string $University = '';

    /**
     * @var string $Hobbies
     */
    public string $Hobbies = '';

    /**
     * @var string $FavMusic
     */
    public string $FavMusic = '';

    /**
     * @var string $FavTVShows
     */
    public string $FavTVShows = '';

    /**
     * @var string $FavMovies
     */
    public string $FavMovies = '';

    /**
     * @var string $FavBooks
     */
    public string $FavBooks = '';

    /**
     * @var string $FavQuotations
     */
    public string $FavQuotations = '';

    /**
     * @var string $FavWebSites
     */
    public string $FavWebSites = '';

    /**
     * @var string $FutureGoals
     */
    public string $FutureGoals = '';

    /**
     * @var string $FavMemory
     */
    public string $FavMemory = '';

    /**
     * @var array<UserProfileSocialMediaUrlModel> $SocialMediaUrls
     */
    public array $SocialMediaUrls = [];

    /**
     * @var string
     */
    public string $ProfileIdentifier = '';

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "Birthday") && is_object($values->Birthday)) {
            $this->Birthday = new UserProfileBirthdayModel(values: $values->Birthday);
        }
        if (property_exists($values, "SocialMediaUrls") && is_array($values->SocialMediaUrls)) {
            foreach ($values->SocialMediaUrls as $socialMediaUrl) {
                $this->SocialMediaUrls[] = new UserProfileSocialMediaUrlModel(values: $socialMediaUrl);
            }
        }
        unset($values->Birthday, $values->SocialMediaUrls);

        parent::setValues(values: $values);
    }
}
