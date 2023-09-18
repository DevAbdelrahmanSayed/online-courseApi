<?php

namespace Modules\Course\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Actions\DeleteCourseAction;
use Modules\Course\Actions\GetCoursesWithPaginationAction;
use Modules\Course\Actions\StoreCourseAction;
use Modules\Course\Actions\UpdateCourseAction;
use Modules\Course\Entities\Course;
use Modules\Course\Http\Requests\IndexCourseRequest;
use Modules\Course\Http\Requests\StoreCourseRequest;
use Modules\Course\Http\Requests\UpdatecourseRequest;
use Modules\Course\Transformers\AllCourseResource;
use Modules\Course\Transformers\CourseResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class CourseController extends Controller
{
    public function index(IndexCourseRequest $request, GetCoursesWithPaginationAction $getCoursesWithPaginationAction)
    {
        $courses = $getCoursesWithPaginationAction->execute(request(['teacher_id']));
        if (! $courses) {
            return ApiResponse::sendResponse(JsonResponse::HTTP_NOT_FOUND, 'No courses found');
        }
        $data = array_merge(AllCourseResource::collection($courses)->toArray(request()), $courses->pagination ?? []);

        return ApiResponse::sendResponse(JsonResponse::HTTP_OK, 'Courses retrived successfully.', $data);
    }

    public function store(StoreCourseRequest $request, StoreCourseAction $StoreCourseAction)
    {
        $course = $StoreCourseAction->execute($request->validated(), Auth::guard('teacher')->user());

        return ApiResponse::sendResponse(JsonResponse::HTTP_CREATED, 'Course created successfully. ',['courseID'=>$course->id]);
    }

    public function show($teacherId)
    {
    }

    public function update(Course $course, UpdatecourseRequest $request, UpdateCourseAction $updateCourseAction)
    {
        if ($course->teacher_id !== Auth::guard('teacher')->user()->getKey()) {
            return ApiResponse::sendResponse(JsonResponse::HTTP_FORBIDDEN, 'You do not have permission to take this action');
        }

        $course = $updateCourseAction->execute($course, $request->validated());

        return ApiResponse::sendResponse(JsonResponse::HTTP_OK, 'Course Updated successfully.', ['courseID'=>$course->id]);
    }

    public function destroy(Course $course, DeleteCourseAction $deleteCourseAction)
    {
        if ($course->teacher_id !== Auth::guard('teacher')->user()->getKey()) {
            return ApiResponse::sendResponse(JsonResponse::HTTP_FORBIDDEN, 'You do not have permission to take this action');
        }

        $deleteCourseAction->execute($course);

        return ApiResponse::sendResponse(JsonResponse::HTTP_OK, 'Course deleted successfully.');
    }
}
