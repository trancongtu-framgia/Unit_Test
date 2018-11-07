<?php

namespace App\Http\Controllers;

use Auth;
use App\Review;
use Illuminate\Http\Request;
use App\Http\Policies\Review\ReviewPolicy;
use App\Http\Resources\Review as ReviewResource;
use App\Repositories\Reviews\ReviewRepositoryInterface;

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

    public function update(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
        ]);

        $id = $request->id;

        if ($id == null) {
            $this->authorize('create', Review::class);
            Review::create($request->only(
                'content',
                'report_id',
                'user_id'
            ));
        } else {
            $review = Review::findOrFail($id);
            $this->authorize('update', $review);
            $review = $this->review->update($request->only(
                'content',
                'report_id',
                'user_id'
            ), $id);
        }

        return response()->json([
            'message' => config('api.update')
        ]);
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
