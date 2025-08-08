<?php

namespace App\Modules\Course\Repositories;

use App\Modules\Course\Domain\Contracts\CourseRepositoryInterface;
use App\Modules\Course\Domain\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function findAll(int $perPage = 15): LengthAwarePaginator
    {
        return Course::with('teacher')->paginate($perPage);
    }

    public function findById(int $id): ?Course
    {
        return Course::with('teacher', 'sessions')->find($id);
    }

    public function create(array $data): Course
    {
        $course = Course::create($data);
        $course->load('teacher');
        
        return $course;
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        $course->load('teacher');
        
        return $course;
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }
}