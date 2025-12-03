<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Send a success response with optional data.
     */
    public function success($message, $data = null, $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Send a created response (201).
     */
    public function created($message, $data = null)
    {
        return $this->success($message, $data, 201);
    }

    /**
     * Send a no-content response (204).
     */
    public function noContent()
    {
        return response()->json(null, 204);
    }

    /**
     * Send an error response.
     */
    public function error($message, $statusCode = 400, $data = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Shortcut for common errors
     */
    public function notFound($message = 'Resource not found')
    {
        return $this->error($message, 404);
    }

    public function unauthorized($message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    public function forbidden($message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    public function validationError($message = 'Validation failed', $data = null)
    {
        return $this->error($message, 422, $data);
    }

    public function serverError($message = 'Internal server error')
    {
        return $this->error($message, 500);
    }

    public function methodNotAllowed($message = 'Method not allowed')
    {
        return $this->error($message, 405);
    }
}
