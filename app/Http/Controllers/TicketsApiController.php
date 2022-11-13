<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\TicketsQueryBuilder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketsApiController extends Controller
{
    /** @var TicketsQueryBuilder $ticketsQueryBuilder */
    private $ticketsQueryBuilder;

    /**
     * Constructor.
     */
    public function __construct(TicketsQueryBuilder $ticketsQueryBuilder)
    {
        $this->ticketsQueryBuilder = $ticketsQueryBuilder;
    }

    /**
     * Get all tickets.
     *
     * @return Response
     */
    public function getTickets(): Response
    {
        try {
            return new Response($this->ticketsQueryBuilder->selectTickets());
        } catch (Exception $exception) {
            $errors = $exception;
            return new Response(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Get ticket by id.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function getTicket($id): JsonResponse
    {
        try {
            return response()->json($this->ticketsQueryBuilder->selectTicket($id));
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Create ticket.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createTicket(Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $parameters['sale_date'] = date('Y-m-d H:i:s');

            $response = $this->ticketsQueryBuilder->insertTicket($parameters);

            return response()->json($response, 201);
        } catch (Exception $exception) {
            $errors = $exception;
            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Update ticket.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateTicket($id, Request $request): JsonResponse
    {
        try {
            $parameters = $request->all();

            $parameters['created'] = date('Y-m-d H:i:s');

            $parameters['sale_date'] = date('Y-m-d H:i:s');

            $response = $this->ticketsQueryBuilder->updateTicket($id, $parameters);

            return response()->json($response);
        } catch (Exception $exception) {
            $errors = $exception;

            return response()->json(["error" => 'Validation error(s) occurred', "message" => $errors], 400);
        }
    }

    /**
     * Delete ticket.
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteTicket($id): JsonResponse
    {
        try {
            return response()->json(["message" => $this->ticketsQueryBuilder->deleteTicket($id)]);
        } catch (ModelNotFoundException $e) {

            return response()->json(['status' => 'error', "message" => $e->getMessage()], 404);
        }
    }

}
