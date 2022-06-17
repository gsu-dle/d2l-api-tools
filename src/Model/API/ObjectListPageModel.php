<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\API;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * In object list pages, the service dispenses with the need to manipulate and track bookmarks; the service wraps each 
 * of these result segments using a ObjectListPage composite structure.
 * 
 * Sometimes a paged list will contain objects that may, themselves, contain properties that are lists paged into an 
 * ObjectListPage.
 * 
 * @package GAState\Tools\D2L\Model\API
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#object-list-pages
 */
class ObjectListPageModel extends D2LModel
{
    /**
     * If more objects exist beyond this current page of results, then this property is not null and will contain an 
     * APIURL to fetch the next page of records.
     * 
     * You must still wrap the APIURL with authentication tokens to make a proper (GET) API call, but otherwise, the 
     * required route and query parameters to fetch the next page are all self-contained. Practically speaking, the 
     * service will provide back the same query parameters (if any) you used to filter/sort/search through data with 
     * your original request.
     * 
     * @var string|null|null $Next
     */
    public ?string $Next = null;

    /**
     * The generic paging wrapper folds an array of the underlying data objects being paged into this property.
     * 
     * @var array<object> $Objects
     */
    public array $Objects = [];

    /**
     * @var callable $createObject
     */
    private $createObject;

    /**
     * @param object|null $values
     * @param callable|null $createObject
     */
    public function __construct(?object $values = null, ?callable $createObject = null)
    {
        $this->createObject = $createObject ?? function ($object) {
            return $object;
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
        if (property_exists($values, "Objects") && is_array($values->Objects)) {
            foreach ($values->Objects as $object) {
                $this->Objects[] = ($this->createObject)($object);
            }
        }
        unset($values->Objects);

        parent::setValues(values: $values);
    }
}
