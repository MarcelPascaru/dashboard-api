<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\BrandsQueryBuilder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandsApiController extends Controller
{
    /** @var BrandsQueryBuilder $brandsQueryBuilder */
    private $brandsQueryBuilder;

    /**
     * Constructor.
     */
    public function __construct(BrandsQueryBuilder $brandsQueryBuilder)
    {
        $this->brandsQueryBuilder = $brandsQueryBuilder;
    }

    /**
     * Get all brands.
     *
     * @return Response
     */
    public function getBrands(): Response
    {
        try {
            return new Response($this->brandsQueryBuilder->selectBrands());
        } catch (Exception $exception) {
            $errors = $exception;
            return new Response(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Get brand by id.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function getBrand($id): JsonResponse
    {
        try {
            return response()->json($this->brandsQueryBuilder->selectBrand($id));
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Create brand.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createBrand(Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->brandsQueryBuilder->insertBrand($parameters);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Update brand.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBrand($id, Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->brandsQueryBuilder->updateBrand($id, $parameters);

            return response()->json($response);
        } catch (Exception $exception) {
            $errors = $exception;

            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Delete brand.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteBrand($id): JsonResponse
    {
        try {
            return response()->json(["message" => $this->brandsQueryBuilder->deleteBrand($id)]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['status' => 'error', "message" => $e->getMessage()], 404);
        }
    }
}
