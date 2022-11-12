<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\EmployeeQueryBuilder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeesApiController extends Controller
{
    /** @var EmployeeQueryBuilder $employeeQueryBuilder */
    private $employeeQueryBuilder;

    /**
     * Constructor.
     */
    public function __construct(EmployeeQueryBuilder $employeeQueryBuilder)
    {
        $this->employeeQueryBuilder = $employeeQueryBuilder;
    }

    /**
     * Get all employees.
     *
     * @return Response
     */
    public function getEmployees(): Response
    {
        try {
            return new Response($this->employeeQueryBuilder->selectEmployees());
        } catch (Exception $exception) {
            $errors = $exception;
            return new Response(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Get employee by id.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function getEmployee($id): JsonResponse
    {
        try {
            return response()->json($this->employeeQueryBuilder->selectEmployee($id));
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Create employee.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createEmployee(Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->employeeQueryBuilder->insertEmployee($parameters);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Update employee.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateEmployee($id, Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->employeeQueryBuilder->updateEmployee($id, $parameters);

            return response()->json($response);
        } catch (Exception $exception) {
            $errors = $exception;

            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Delete employee.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteEmployee($id): JsonResponse
    {
        try {
            return response()->json(["message" => $this->employeeQueryBuilder->deleteEmployee($id)]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['status' => 'error', "message" => $e->getMessage()], 404);
        }
    }
}
