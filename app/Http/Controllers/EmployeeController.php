<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\EmployeeCreateUpdateRequest;
use App\Http\Requests\Employee\EmployeeImportFromXmlRequest;
use App\Http\Requests\Employee\EmployeeListRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    use ValidatesRequests;

    public function __construct(
        public EmployeeRepository   $employeeRepository,
        public DepartmentRepository $departmentRepository
    ) {}

    public function index(EmployeeListRequest $request, ?string $departmentTitle = null): AnonymousResourceCollection
    {
        $searchParams = $request->validated();
        if ($departmentTitle) {
            /** @var Department $department */
            $department = $this->departmentRepository->findOneByTitle($departmentTitle, true);
            $searchParams['department_id'] = $department->id;
        }

        $employees = $this->employeeRepository->findList($searchParams);

        return EmployeeResource::collection($employees);
    }

    public function create(EmployeeCreateUpdateRequest $request): JsonResponse
    {
        $employee = $this->employeeRepository->create($request->validated());

        return EmployeeResource::make($employee)->toResponse($request)->setStatusCode(201);
    }

    public function importXml(EmployeeImportFromXmlRequest $request): Response
    {
        $this->employeeRepository->importFromXml($request->validated()['file']);

        return response()->noContent();
    }

    public function update(EmployeeCreateUpdateRequest $request, int $id): JsonResponse
    {
        $employee = $this->employeeRepository->update($id, $request->validated());

        return EmployeeResource::make($employee)->toResponse($request);
    }

    public function delete(int $id): Response
    {
        $this->employeeRepository->delete($id);
        
        return response()->noContent();
    }
}
