<?php

namespace App\Modules\Course\Domain\Contracts;

use App\Modules\Course\Domain\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function findAll(int $perPage = 15): LengthAwarePaginator;
    
    public function findById(int $id): ?Course;
    
    public function create(array $data): Course;
    
    public function update(Course $course, array $data): Course;
    
    public function delete(Course $course): bool;
}