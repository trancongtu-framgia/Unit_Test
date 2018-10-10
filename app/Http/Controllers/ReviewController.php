<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reviews\ReviewRepositoryInterface;
use App\Http\Policies\Review\ReviewPolicy;
use App\Http\Resources\Review as ReviewResource;
use Auth;

class ReviewController extends Controller
{
    protected $review;

    public function __construct(ReviewRepositoryInterface $review)
    {
        $this->review = $review;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
            'user_id' => 'required',
            'report_id' => 'required'
        ]);

        $this->review->create($request->all());

        return response()->json([
            'message' => config('api.create')
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|string',
        ]);
        $review = $this->review->find($id);
        $this->authorize('update', $review);
        $review = $this->review->update($request->all(), $id);

        return new ReviewResource($review);
    }

    public function destroy($id)
    {
        $review = $this->review->find($id);
        $this->authorize('delete', $review);
        $this->review->delete($id);

        return response()->json([
            'message' => config('api.deleted')
        ]);
    }
}
