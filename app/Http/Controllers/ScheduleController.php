<?php

namespace App\Http\Controllers;

use App\Day;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ScheduleResource;
use \App\Repositories\ScheduleRepository;
use App\Http\Resources\WeekScheduleResource;

class ScheduleController extends Controller
{
    private $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->notTrainee()) {
            return ScheduleResource::collection($this->scheduleRepository->traineeSchedule());
        }
        
        return ScheduleResource::collection($this->scheduleRepository->showSchedule($user->id));
    }

    public function getBatchSchedule(Request $request, $id)
    {
        return ScheduleResource::collection($this->scheduleRepository->traineeSchedule($request->id));
    }

    public function getUserSchedule(Request $request, $id)
    {
        return ScheduleResource::collection($this->scheduleRepository->showSchedule($request->id));
    }

    public function getUserScheduleByWeek(Request $request, $id)
    {
        return WeekScheduleResource::collection($this->scheduleRepository->showScheduleByWeek($id));
    }

    public function getUserByDate(Request $request, $date)
    {
        return response()->json($this->scheduleRepository->getUserByDate($date));
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
        $user = User::findOrFail($id);

        return ScheduleResource::collection($this->scheduleRepository->showSchedule($user->id));
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
        $this->validate($request, [
            'status' => 'required|integer',
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        
        $schedule = $this->scheduleRepository->findByDate($request->date, $user->id);

        if ($user->cannot('update', $schedule)) {
            return response()->json(['message' => config('api.denied')]);
        }

        return $this->scheduleRepository->update(
            $request->only('status'),
            $schedule->id
        );
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
