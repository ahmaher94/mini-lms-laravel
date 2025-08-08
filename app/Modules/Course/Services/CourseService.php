<?php

namespace App\Modules\Course\Services;

use App\Modules\Course\Domain\Contracts\CourseRepositoryInterface;
use App\Modules\Course\Domain\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseService
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {}

    public function getAllCourses(int $perPage = 15): LengthAwarePaginator
    {
        return $this->courseRepository->findAll($perPage);
    }

    public function getCourseById(int $id): ?Course
    {
        return $this->courseRepository->findById($id);
    }

    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse(Course $course, array $data): Course
    {
        return $this->courseRepository->update($course, $data);
    }

    public function deleteCourse(Course $course): bool
    {
        return $this->courseRepository->delete($course);
    }
}