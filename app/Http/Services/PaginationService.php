<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/19/2018
 * Time: 11:02 AM
 */

namespace App\Http\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationService
{
    public static function paginate(Collection $collection, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $collection = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        return $collection;
    }
}