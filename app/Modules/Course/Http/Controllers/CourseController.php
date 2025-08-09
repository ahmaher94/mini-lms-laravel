<?php

namespace App\Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Course\Domain\Models\Course;
use App\Modules\Course\Http\Requests\CourseStoreRequest;
use App\Modules\Course\Http\Requests\CourseUpdateRequest;
use App\Modules\Course\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        
        return response()->json([
            'data' => $courses->items(),
            'meta' => [
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
                'per_page' => $courses->perPage(),
                'total' => $courses->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request)
    {
        $course = $this->courseService->createCourse($request->validated());

        return response()->json(['data' => $course], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course = $this->courseService->getCourseById($course->id);
        
        return response()->json(['data' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course = $this->courseService->updateCourse($course, $request->validated());

        return response()->json(['data' => $course]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->courseService->deleteCourse($course);
        
        return response()->json(null, 204);
    }
}
