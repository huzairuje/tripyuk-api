<?php


namespace App\Helpers;


use App\Library\ApiBaseResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Helpers
{
    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator){
        $responseLib = new ApiBaseResponse();
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json($responseLib->validationFailResponse($errors),
            Response::HTTP_BAD_REQUEST));
    }

}
