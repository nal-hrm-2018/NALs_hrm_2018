<?php

namespace App\Http\Controllers\User\Employee;

use App\Http\Requests\SearchRequest;
use App\Models\Processe;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Service\SearchService;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

//    public function setupsearch(){
//        return view('test.test');
//    }

   public function search(SearchRequest $request){

       $processes = $this->searchService->search($request)->paginate(config('settings.paginate'));

//       $roles = Role::all();

       $processes->setPath('');

       $param = (Input::except('page'));

       $employee = Employee::find($request->get('id'));

       if(!isset($employee)){
           return abort(404);
       }

       return view('employee.detail',compact('processes','employee' ,'param','roles'));
   }
}
