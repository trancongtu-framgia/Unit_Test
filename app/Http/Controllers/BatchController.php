<?php

namespace App\Http\Controllers;

use App\Batch;
use Illuminate\Http\Request;
use App\Http\Requests\BatchRequest;
use App\Repositories\BatchRepository;
use App\Http\Resources\BatchResoure;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    private $batchRepository;

    public function __construct(BatchRepository $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BatchResoure::collection($this->batchRepository->getAll());
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
        $errors = Validator::make($request->all(), [
            'start_day' => 'required|date',
            'stop_day' => 'required|date',
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'team_id' => 'required|integer|exists:teams,id',
            'type_id' => 'required|integer|exists:types,id',
            'subject_ids' => 'required|array|min:1|exists:subjects,id',
        ]);

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()]);
        }

        return $this->batchRepository->create(
            $request->only(
                'start_day',
                'stop_day',
                'workspace_id',
                'team_id',
                'type_id',
                'subject_ids'
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
        return $this->batchRepository->find($id);
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
        $errors = Validator::make($request->all(), [
            'start_day' => 'required|date',
            'stop_day' => 'required|date',
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'team_id' => 'required|integer|exists:teams,id',
            'type_id' => 'required|integer|exists:types,id',
            'subject_ids' => 'required|array|min:1|exists:subjects,id',
        ]);

        if ($errors->fails()) {
            return response()->json(['errors' => $errors->errors()]);
        }

        return $this->batchRepository->update(
            $request->only(
                'start_day',
                'stop_day',
                'workspace_id',
                'team_id',
                'type_id',
                'subject_ids'
            ),
            $id
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
        return $this->batchRepository->destroy($id);
    }
}
