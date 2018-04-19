<?php

namespace App\Http\Controllers\User\Employee;

use App\Http\Requests\SearchRequest;
use App\Models\Processe;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SearchService;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function setupsearch(){
        return view('test.test');
    }

   public function search(SearchRequest $request){
       $processes = $this->searchService->search($request)->paginate(config('settings.paginate'));

       $processes->setPath('');

       $param = (Input::except('page'));

       return view('test.list',compact('processes', $processes ,'param',$param));
   }
}
