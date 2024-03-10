<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Validation error response
     *
     * @param array $errors
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseValidationError(array $errors = [], int $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        $data = [
            "message" => "Validation error",
            "errors" => $errors
        ];

        return response()->json($errors, $code);
    }

    /**
     * Resource not found respons with message
     *
     * @param array $errors = []
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseNotFound(string $msg = "Resource not found", int $code = Response::HTTP_NOT_FOUND)
    {
        $data = [
            "message" => $msg
        ];

        return response()->json($data, $code);
    }

    /**
     * server error
     *
     * @param array $errors = []
     * @param string $msg = 'Error'
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseErrorMsg(string $msg = "Error", array $errors = [], int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "message" => $msg,
            "errors" => $errors
        ];

        return response()->json($data, $code);
    }

    /**
     * Creating model error response
     *
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseErrorCreatingModel(string $msg = "Error while creating model.", int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Saving model error response
     *
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseErrorSavingModel(string $msg = "Error while saving model.", int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Success response message
     *
     * @param array $attributes = []
     * @param string $msg = 'Success'
     * @param integer $code = 200
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess($msg = "Success", $data = [], $code = Response::HTTP_OK)
    {
        $data = [
            "message" => $msg,
            "data" => $data
        ];

        return response()->json($data, $code);
    }
}
