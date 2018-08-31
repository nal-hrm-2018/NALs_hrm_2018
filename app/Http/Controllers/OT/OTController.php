<?php

namespace App\Http\Controllers\OT;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $objOT;
    public function __construct (Overtime $objOT)
    {
        $this->objOT=$objOT;
    }

    public function indexPO()
    {
        $id=Auth::user()->id;
//        $process = Process::where('employee_id',$id)->get();
//        $OT = [];
//        foreach ($process as $proces){
//            $OT[] = Process::where('employee_id',$id)->with('projects.overtime')->get();
//        }

        $OT[] = Process::where('employee_id',$id)->with('project.overtime')->get();
//        $OT = Process::where('project_id',$process->project_id)->with('projects.overtime')->get();
//        echo $OT; die();
        return view('overtime.po_list',['OT'=>$OT]);
    }
    public function index()
    {
        $id=Auth::user()->id;
        $ot = Overtime::where('id', $id)->with('status', 'type', 'employee')->get();
        return view('overtime.list', [
            'ot' => $ot,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('overtime.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('overtime.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
