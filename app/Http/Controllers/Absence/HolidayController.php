<?php

namespace App\Http\Controllers\Absence;

use App\Http\Requests\StoreHoliday;
use App\Models\Holiday;
use App\Models\HolidayStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_holiday = Holiday::with('status')->get();
        $holiday_type = HolidayStatus::all();
        $year_now = date("Y");
        $min_year = Holiday::all('date')->min()->date->Format('Y');
        $max_year = Holiday::all('date')->max()->date->Format('Y');
        return view('absences.hr_holiday', [
            'list_holiday' => $list_holiday,
            'holiday_type' => $holiday_type,
            'year_now' => $year_now,
            'min_year' => $min_year,
            'max_year' => $max_year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHoliday $request)
    {
        $holiday = new Holiday([
            'name' => $request['name'],
            'date' => $request['holiday_date'],
            'description' => $request['ghi_chu'],
            'holiday_status_id' => $request['holiday_type_id']
        ]);
        $holiday->save();
        return redirect('holiday');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request['modal-input-id'];
        $holiday = Holiday::find($id);
        $holiday->name = $request['modal-input-name'];
        $date = $request['modal-input-year'].'-'.$request['modal-input-month'].'-'.$request['modal-input-day'];
        $holiday->date = $date;
        $holiday->holiday_status_id = $request['modal-input-type'];
        $holiday->description = $request['modal-input-description'];
        $holiday->save();
        return redirect('holiday');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holiday = Holiday::find($id);
        $holiday->delete();
        return redirect('holiday');
    }
}
