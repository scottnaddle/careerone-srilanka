<?php

namespace App\Services\Trainee;

use App\Models\Job;
use App\Models\JobBookmark;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class JobBookmarkService
{
    protected object $model;

    /**
     * JobBookmarkService constructor.
     * @param JobBookmark $model
     */
    public function __construct(JobBookmark $model) {
        $this->model = $model;
    }

    /**
     *
     * @param $request
     * @return string|bool
     */
    public function mark(Request $request): string|bool
    {
        try {
            if ($request->bearerToken()) {
                $trainee = auth('sanctum')->user();
            } else {
                $trainee = auth()->guard('trainee')->user();
            }
            $trainee_id = $trainee->id;
            $marked = $this->model::where('trainee_id', $trainee_id)->where('job_id', $request['job_id'])->first();

            if ($marked) {
                $marked->delete();
                return 'unmark';
            }

            $this->model::create([
                'job_id' => $request['job_id'],
                'trainee_id' => $trainee_id,
            ]);
            return 'mark';

        } catch (\Exception $exception) {
            return false;
        }
    }
}
