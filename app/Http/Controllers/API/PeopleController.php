<?php

namespace App\Http\Controllers\API;

use Validator;
use App\People;
use Illuminate\Http\Request;
use App\Http\Resources\People as PeopleResource;
use App\Http\Controllers\API\BaseController as BaseController;

class PeopleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = People::all();

        return $this->sendResponse(PeopleResource::collection($people), 'People retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $person = People::where('name', $input['name'])
            ->first();

        if (is_null($person)) {
            return $this->sendError('Person not found.');
        }

        return $this->sendResponse(new PeopleResource($person), 'Person retrieved successfully.');
    }
}
