<?php

namespace App\Http\Controllers;

use App\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    public function getTraineeByBatch(Request $request, $id)
    {
        return ResourceUser::collection($this->traineeRepository->getAllTrainee($id));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        if ($errors->fails()) {
            return Response()->json(['errors' => $errors->errors()]);
        }

        if (!$request->has('password')) {
            $request->merge(['password' => config('api.default.password')]);
        }

        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        return $this->traineeRepository->createTrainee(
            array_merge(
                $request->only(
                    'name',
                    'email',
                    'password',
                    'batch_id',
                    'school'
                ),
                ['role_id' => $request->get('role_id')]
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
