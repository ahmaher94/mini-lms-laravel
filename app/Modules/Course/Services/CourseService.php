<?php

namespace App\Modules\Course\Services;

use App\Modules\Course\Domain\Contracts\CourseRepositoryInterface;
use App\Modules\Course\Domain\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CourseService
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {}

    public function getAllCourses(int $perPage = 15): LengthAwarePaginator
    {
        $cacheKey = "courses_page_1_per_page_{$perPage}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($perPage) {
            return $this->courseRepository->findAll($perPage);
        });
    }

    public function getCourseById(int $id): ?Course
    {
        return Cache::remember("course_{$id}", now()->addMinutes(30), function () use ($id) {
            return $this->courseRepository->findById($id);
        });
    }

    public function createCourse(array $data): Course
    {
        $course = $this->courseRepository->create($data);
        
        // Clear course cache when new course is created
        $this->clearCourseCache();
        
        return $course;
    }

    public function updateCourse(Course $course, array $data): Course
    {
        $updatedCourse = $this->courseRepository->update($course, $data);
        
        // Clear specific course cache and list cache
        Cache::forget("course_{$course->id}");
        $this->clearCourseCache();
        
        return $updatedCourse;
    }

    public function deleteCourse(Course $course): bool
    {
        $result = $this->courseRepository->delete($course);
        
        if ($result) {
            Cache::forget("course_{$course->id}");
            $this->clearCourseCache();
        }
        
        return $result;
    }

    private function clearCourseCache(): void
    {
        // Clear paginated course lists
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("courses_page_{$page}_per_page_15");
        }
    }
}