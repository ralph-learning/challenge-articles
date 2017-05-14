<?php

namespace App\Http\Controllers;

class ApiController extends Controller {

    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(404)->respondWithErrors($message);
    }

    public function respondInvalidFields($validator) {
        $messagesError = $validator->errors()->all();
        return $this->setStatusCode(422)->respondWithErrors($messagesError);
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithErrors($message)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }



}