<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\ServicesQueryBuilder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServicesApiController extends Controller
{
    /** @var ServicesQueryBuilder $serviceQueryBuilder */
    private $serviceQueryBuilder;

    /**
     * Constructor.
     */
    public function __construct(ServicesQueryBuilder $serviceQueryBuilder)
    {
        $this->serviceQueryBuilder = $serviceQueryBuilder;
    }

    /**
     * Get all services.
     *
     * @return Response
     */
    public function getServices(): Response
    {
        try {
            return new Response($this->serviceQueryBuilder->selectServices());
        } catch (Exception $exception) {
            $errors = $exception;
            return new Response(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Get service by id.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function getService($id): JsonResponse
    {
        try {
            return response()->json($this->serviceQueryBuilder->selectService($id));
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Create service.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createService(Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->serviceQueryBuilder->insertService($parameters);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Update service.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateService($id, Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->serviceQueryBuilder->updateService($id, $parameters);

            return response()->json($response);
        } catch (Exception $exception) {
            $errors = $exception;

            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Delete service.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteService($id): JsonResponse
    {
        try {
            return response()->json(["message" => $this->serviceQueryBuilder->deleteService($id)]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['status' => 'error', "message" => $e->getMessage()], 404);
        }
    }
}
