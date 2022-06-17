<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\API;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\API
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/apicall.html#paged-result-sets
 */
class PagingInfoModel extends D2LModel
{
    /**
     * @var string $Bookmark
     */
    public string $Bookmark = '';

    /**
     * @var bool $HasMoreItems
     */
    public bool $HasMoreItems = false;
}
