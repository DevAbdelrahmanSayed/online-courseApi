<?php

namespace Modules\Section\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Section\Entities\Section;
use Modules\Section\Http\Requests\SectionRequest;
use Modules\Section\Http\Requests\SectionUpdateRequest;
use Modules\Section\Transformers\CourseResource;

class SectionController extends Controller
{
    public function store(SectionRequest $request)
    {
        $course = Course::find($request->course_id);
        $authenticatedTeacher = Auth::guard('teacher')->user()->id;
        if (!$course || $course->teacher_id !==  $authenticatedTeacher) {
            return ApiResponse::sendResponse('Unauthorized: You do not have permission to access this section', [], 403);
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'teacher_id' => $authenticatedTeacher,
            'created_at' => now(),

        ];
        $sectionInsert = DB::table('sections')->insert($data);
        if ($sectionInsert) {
            return ApiResponse::sendResponse(201, 'Section created successfully', []);
        }
        return ApiResponse::sendResponse(200, 'Failed to create the section', []);

    }

    public function show($courseId)
    {

        $course = Course::with('sections.videos', 'sections.files', 'teachers')->where('id', $courseId)->first();

        if (!$course) {
            return ApiResponse::sendResponse(200, 'Course not found', []);
        }

        $authenticatedTeacherId = Auth::guard('teacher')->id();

        if ($course->teacher_id !== $authenticatedTeacherId) {
            return ApiResponse::sendResponse(403, 'Unauthorized: You do not have permission to access this course', []);
        }

        return ApiResponse::sendResponse(200, 'Sections and videos and files for the course retrieved successfully', new CourseResource($course));
    }


    public function update(SectionUpdateRequest $request,$sectionId)
    {

        $section = Section::find($sectionId);

            if (!$section) {
                return ApiResponse::sendResponse(200, 'Section not found', []);
            }
            $authenticatedTeacher = Auth::guard('teacher')->user()->id;
            if ($section->teacher_id !== $authenticatedTeacher) {
                return ApiResponse::sendResponse(403, 'Unauthorized: You do not have permission to update this section', []);
        }
        $data =[
            'title' => $request->title,
            'description' => $request->description,
            'updated_at' => now(),
        ];
        $sectionUpdate = DB::table('sections')->where('id',$sectionId)->update($data);
        if ($sectionUpdate) {
            return ApiResponse::sendResponse(200, 'Section updated successfully', []);
        }

        return ApiResponse::sendResponse(200, 'Failed to update the section', []);
    }


    public function destroy($sectionId)
    {
        $section = Section::find($sectionId);

        if (!$section) {
            return ApiResponse::sendResponse(200, 'Section not found', []);
        }
        $authenticatedTeacher = Auth::guard('teacher')->user()->id;
        if ($section->teacher_id !== $authenticatedTeacher) {
            return ApiResponse::sendResponse(403, 'Unauthorized: You do not have permission to delete this section', []);
        }
        $section->delete();
        return ApiResponse::sendResponse(200, 'Section deleted successfully', []);
    }
}
