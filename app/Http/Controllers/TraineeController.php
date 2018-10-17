<?php

namespace App\Http\Controllers;

use App\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as ResourceUser;

class TraineeController extends Controller
{
    private $traineeRepository;

    public function __construct(UserRepository $traineeRepository)
    {
        $this->traineeRepository = $traineeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResourceUser::collection($this->traineeRepository->getAllTrainee());
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
    public function store(UserRequest $request)
    {
        if (!$request->has('password')) {
            $request->merge(['password' => config('api.default.password')]);
        }

        $request->merge([
            'password' => Hash::make($request->password)
        ]);

        return $this->traineeRepository->createTrainee(
            array_merge(
                $request->only(
                    'name',
                    'email',
                    'password',
                    'batch_id'
                ),
                ['role_id' => '3']
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
        return $this->traineeRepository->delete($id);
    }
}