<?php

namespace App\Http\Controllers;

use App\User;
use App\Report;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(\App\Repositories\ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->has('search') ? $request->search : "";

        return ReportResource::collection($this->reportRepository->getReports($search));
    }

    public function getReportsBySubject(Request $request, $search)
    {
        return response()->json(['data' => $this->reportRepository->getReportsBySubject($search)]);
    }

    public function getReportsGroupBySubject(Request $request, $id)
    {
        $users = User::where('batch_id', $id)->paginate(config('api.report_paginate'));
        foreach ($users as $user) {
            $user->reports = $this->reportRepository->getReportsGroupBySubject($user->id);
        }
        
        return response()->json($users);
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
    public function store(ReportRequest $request)
    {
        if (Auth::user()->cannot('create', Subject::findOrFail($request->subject_id))) {
            return response()->json(['message' => config('api.denied')], 403);
        }

        return $this->reportRepository->create(
            array_merge(
                $request->only(
                    'content',
                    'link',
                    'test_link',
                    'subject_id'
                ),
                ['user_id' => Auth::user()->id]
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->reportRepository->find($id);
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
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        if (Auth::user()->cannot('update', $report)) {
            return response()->json(['message' => config('api.denied')], 403);
        }

        return $this->reportRepository->update($request->all(), $id);
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
