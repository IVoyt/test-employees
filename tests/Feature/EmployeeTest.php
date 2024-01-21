<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PositionRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use WithFaker;

    public function test_employee_created_without_relations(): void
    {
        $data = [
            'first_name'  => $this->faker->firstName,
            'last_name'   => $this->faker->lastName,
            'patronymic'  => $this->faker->name,
            'birthdate'   => $this->faker->date,
            'salary_type' => fake()->randomElement(array_keys(Employee::SALARY_TYPES_TITLES)),
            'salary'      => $this->faker->randomFloat(),
        ];

        $response = $this->json('POST', '/api/employees', $data);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_employee_created_with_relations(): void
    {
        $departmentRepository = resolve(DepartmentRepository::class);
        $positionRepository   = resolve(PositionRepository::class);

        $data = [
            'first_name'    => $this->faker->firstName,
            'last_name'     => $this->faker->lastName,
            'patronymic'    => $this->faker->name,
            'birthdate'     => $this->faker->date,
            'department_id' => $departmentRepository->findAll()->random()->id,
            'position_id'   => $positionRepository->findAll()->random()->id,
            'salary_type'   => fake()->randomElement(array_keys(Employee::SALARY_TYPES_TITLES)),
            'salary'        => $this->faker->randomFloat(),
        ];

        $response = $this->json('POST', '/api/employees', $data);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_employees_list_404_by_non_existent_department(): void
    {
        $response = $this->json('GET', '/api/employees/abracadabra');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_employee_422(): void
    {
        $this->json('POST', '/api/employees')->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_employee_delete(): void
    {
        $employees = resolve(EmployeeRepository::class)->findAll();
        $this
            ->json('DELETE', '/api/employees/' . $employees->random()->id)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
