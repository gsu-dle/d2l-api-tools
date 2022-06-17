<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\API;

use GAState\Tools\D2L\Model\D2LModel;
use stdClass;

/**
 * In paged result sets, the service wraps each of these result segments using a PagedResultSet composite structure.
 * 
 * The service uses a Bookmark property to act as a paging control value:
 * - Each time the service provides you with a segment of the entire data set, the Bookmark property identifies the 
 *   last item in the returned segment.
 * - Each time you use an action to retrieve items from the entire data set, you can use a bookmark query parameter to
 *   indicate that you've already received the segment containing that item, and you want the next segment from the 
 *   set. If you use the action with an empty or absent bookmark parameter, then the service always returns the first 
 *   segment.
 * 
 * The service uses a HasMoreItems property to indicate that its containing segment is not the last segment in the data
 * set.
 * 
 * Paging value opacity - In some cases, the service will use one of the properties inherent to the items in the data 
 * set as a paging value. For example, in a data set of users, the service may directly use the UserId property as a 
 * paging value. Where this is the case, the documentation for the action in question will tell you. If the documention
 * doesn't specifically tell you that a bookmark value has some underlying inherent meaning, should not assume that it 
 * does, and you should assume that the value is just an opaque string with no particular meaning (other than to get 
 * used as a bookmark).
 * 
 * When the paging value does use a documented value with meaning, this could be useful to you in several ways:
 * - You can use that property from any known item to act as a bookmark (for example, given any arbitrary user's UserId
 *   property, you can always request the segment that would follow that user's position in the entire data set).
 * - You can use a bookmark's value elsewhere where you might otherwise need that kind of value (for example, if the 
 *   action uses the UserId as a paging value, you can use a bookmark's value in another action that would use a UserId 
 *   as a parameter).
 * 
 * Sorting - Notice that, although the service does guarantee that it will have sorted the entire data set upon some
 * key, it does not guarantee to use the same key for sorting and paging control. In fact, in most cases, the sorting
 * key and the paging control property are entirely different. For example, the service may sort the entire data set on
 * "last modified time", but provide paging control with a property like UserId. Accordingly, if the entire data set
 * gets resorted in between two uses of an action, the segment you got from the first use of the bookmark may not
 * naturally match up with the segment you get from the second use.
 * 
 * Missing bookmarks - Because the service always maintains a unique mapping between paging values and the items in the
 * entire data set, if a "bookmarked" item gets deleted between your two uses of an action, the second attempt may not 
 * succeed because the service can no longer find the item that maps your provided bookmark parameter and may,
 * therefore, not be able to determine the item it should use as the first item in the next segment to return to you.
 * 
 * In cases where the paging property is not opaque (that is, it's a UserId or some other known item property), you can
 * always fall back to trying the second-to-last item from the previously fetched segment. Accordingly, it may be wise 
 * to maintain a cache of some recently retrieved paging values when you know they're not opaque values.
 * 
 * In cases where the paging property is opaque, you may want to cache previously returned Bookmark values, so you can 
 * at least attempt to "re-fetch" a segment and see what it's returned bookmark value is.
 * 
 * @package GAState\Tools\D2L\Model\API
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#paged-result-sets
 */
class PagedResultSetModel extends D2LModel
{
    /**
     * @var PagingInfoModel $PagingInfo
     */
    public PagingInfoModel $PagingInfo;

    /** 
     * list of items in current batch
     * 
     * @var array<object>
     */
    public array $Items = [];

    /** 
     * callback function to create strongly-typed item
     * 
     * @var callable $createItem
     * */
    private $createItem;

    /**
     * @param object|null $values
     * @param callable|null $createItem
     */
    public function __construct(?object $values = null, ?callable $createItem = null)
    {
        $this->createItem = $createItem ?? function ($item) {
            return $item;
        };
        parent::__construct($values);
    }

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        $pagingInfo = property_exists($values, "PagingInfo") && is_object($values->PagingInfo) ? $values->PagingInfo : new stdClass();
        $this->PagingInfo = new PagingInfoModel(values: $pagingInfo);

        if (property_exists($values, "Items") && is_array($values->Items)) {
            foreach ($values->Items as $item) {
                $this->Items[] = ($this->createItem)($item);
            }
        }
    }
}
