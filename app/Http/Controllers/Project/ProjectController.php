<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */
namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.list');

    }

    public function create()
    {

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id, Request $request)
    {
    }

    public function phucTest(Request $request){
        $id = $request->id;
        $name = $request->name;
        $user = array('id'=>$id, 'name'=>$name);
        $request->session()->push('listUser', $user);
        return response('Success');
    }

    public function phucTest2(Request $request){
        $user = $request->session()->get('listUser');
        foreach ($user as $item){
            foreach($item as $key => $value) {
                echo "$key is at $value--";
            };
        }

    }
}