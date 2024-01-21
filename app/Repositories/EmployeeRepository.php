<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use XMLReader;

final class EmployeeRepository
{
    public function __construct(
        private DepartmentRepository $departmentRepository,
        private PositionRepository   $positionRepository,
        private SalaryTypeRepository $salaryTypeRepository
    ) {}

    public function findAll(): Collection
    {
        return Employee::query()->get();
    }

    /**
     * @param array $searchParams
     *
     * @return LengthAwarePaginator|Employee[]
     */
    public function findList(array $searchParams = []): LengthAwarePaginator
    {
        $query = Employee::query();

        $perPage = $searchParams['per_page'] ?? 10;
        unset($searchParams['per_page']);

        if (isset($searchParams['column']) || isset($searchParams['order_by'])) {
            $query->orderBy($searchParams['column'] ?? 'id', $searchParams['order_by'] ?? 'asc');
            unset($searchParams['column'], $searchParams['order_by']);
        }

        foreach ($searchParams as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query->paginate($perPage);
    }

    public function create(array $employeeData): Employee
    {
        return Employee::query()->create($employeeData);
    }

    public function importFromXml(UploadedFile $file): void
    {
        $xml = new XMLReader();
        $xml->XML($file->getContent());
        $employees = $this->parseXml($xml);

        $employeesData = [];
        foreach ($employees[0]['child_nodes'] as $employee) {
            $data = [];
            foreach ($employee['child_nodes'] as $node) {
                $field = $node['tag'];
                $value = $node['child_nodes'][0]['text'];

                if (in_array($field, ['department', 'position', 'salary_type'], true)) {
                    $repo = 'departmentRepository';
                    if ($field === 'position') {
                        $repo = 'positionRepository';
                    }
                    if ($field === 'salary_type') {
                        $repo = 'salaryTypeRepository';
                    }
                    $model = $this->{$repo}->findOneByTitle($value);
                    if (!$model) {
                        continue 2;
                    }

                    $field = "{$field}_id";
                    $value = $model->id;
                }
                $data[$field] = $value;
            }

            $employeesData[] = $data;
        }

        foreach ($employeesData as $data) {
            Employee::query()->create($data);
        }
    }

    public function update(int $id, array $employeeData): Employee
    {
        /** @var Employee $employee */
        $employee = Employee::query()->where('id', $id)->firstOrFail();

        $employee->fill($employeeData)->save();

        return $employee;
    }

    public function delete(int $id): void
    {
        Employee::query()->where('id', $id)->delete();
    }

    private function parseXml(XmlReader $xml): array
    {
        $data = [];

        while ($xml->read()) {
            if ($xml->nodeType === XMLReader::END_ELEMENT) {
                break;
            } else if ($xml->nodeType === XMLReader::ELEMENT) {
                $node = [];

                $node['tag'] = $xml->name;

                if ($xml->hasAttributes) {
                    $attributes = [];
                    while ($xml->moveToNextAttribute()) {
                        $attributes[$xml->name] = $xml->value;
                    }
                    $node['attr'] = $attributes;
                }

                if (!$xml->isEmptyElement) {
                    $childNodes          = $this->parseXml($xml);
                    $node['child_nodes'] = $childNodes;
                }

                $data[] = $node;
            } else if ($xml->nodeType === XMLReader::TEXT) {
                $node         = [];
                $node['text'] = $xml->value;
                $data[]       = $node;
            }
        }

        return $data;
    }
}