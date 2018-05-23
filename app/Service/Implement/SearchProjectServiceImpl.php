<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/23/2018
 * Time: 8:48 AM
 */

namespace App\Service\Implement;


use App\Models\Project;
use App\Models\Role;
use App\Service\SearchProjectService;
use Illuminate\Http\Request;

class SearchProjectServiceImpl implements SearchProjectService
{

    public function searchProject(Request $params)
    {
        $poRole = Role::select('id')
            ->where('name', 'PO')->first();
        $query = Project::query();
        $query->where('delete_flag', '=', 0);

        if (!empty($params['name'])) {
            $query->where("name", $params['name']);
        }
        if (!empty($params['po_name'])) {
            $query
                ->whereHas('processes', function ($query) use ($params, $poRole) {
                    $query->where("id", '=', $poRole->id)
                    ->whereHas('employee', function ($query) use ($params) {
                        $query->where("names", 'like', '%' .  $params['po_name'].'%');
                    });
                });
        }
        return $query;
    }
}