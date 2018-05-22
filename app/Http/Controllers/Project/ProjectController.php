<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 5/7/2018
 * Time: 10:51 AM
 */
namespace App\Http\Controllers\Project;


use App\Http\Controllers\Controller;
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
}