<?php

namespace App\Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Course\Domain\Models\Course;
use App\Modules\Course\Http\Requests\CourseStoreRequest;
use App\Modules\Course\Http\Requests\CourseUpdateRequest;
use App\Modules\Course\Http\Resources\CourseCollection;
use App\Modules\Course\Http\Resources\CourseResource;
use App\Modules\Course\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): CourseCollection
    {
        $courses = $this->courseService->getAllCourses();
        
        return new CourseCollection($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return response()->json([
            'message' => 'Course created successfully',
            'data' => new CourseResource($course),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): CourseResource
    {
        $course = $this->courseService->getCourseById($course->id);
        
        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course): JsonResponse
    {
        $course = $this->courseService->updateCourse($course, $request->validated());

        return response()->json([
            'message' => 'Course updated successfully',
            'data' => new CourseResource($course),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): JsonResponse
    {
        $this->courseService->deleteCourse($course);
        
        return response()->json([
            'message' => 'Course deleted successfully',
        ], 204);
    }
}
