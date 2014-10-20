<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Arr;
use inklabs\kommerce\Entity as Entity;

class Pagination
{
    public static function loadByQuery($maxResults = 12)
    {
        $page = Arr::get($_GET, 'page', 1);
        return new Entity\Pagination($maxResults, $page);
    }
}
