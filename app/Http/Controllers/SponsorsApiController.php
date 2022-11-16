<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\SponsorsQueryBuilder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SponsorsApiController extends Controller
{
    /** @var SponsorsQueryBuilder $sponsorQueryBuilder */
    private $sponsorQueryBuilder;

    /**
     * Constructor.
     */
    public function __construct(SponsorsQueryBuilder $sponsorQueryBuilder)
    {
        $this->sponsorQueryBuilder = $sponsorQueryBuilder;
    }

    /**
     * Get all sponsors.
     *
     * @return Response
     */
    public function getSponsors(): Response
    {
        try {
            return new Response($this->sponsorQueryBuilder->selectSponsors());
        } catch (Exception $exception) {
            $errors = $exception;
            return new Response(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Get sponsor by id.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function getSponsor($id): JsonResponse
    {
        try {
            return response()->json($this->sponsorQueryBuilder->selectSponsor($id));
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Create sponsor.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createSponsor(Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->sponsorQueryBuilder->insertSponsor($parameters);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Update sponsor.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateSponsor($id, Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $response = $this->sponsorQueryBuilder->updateSponsor($id, $parameters);

            return response()->json($response);
        } catch (Exception $exception) {
            $errors = $exception;

            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Delete sponsor.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteSponsor($id): JsonResponse
    {
        try {
            return response()->json(["message" => $this->sponsorQueryBuilder->deleteSponsor($id)]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['status' => 'error', "message" => $e->getMessage()], 404);
        }
    }
}
