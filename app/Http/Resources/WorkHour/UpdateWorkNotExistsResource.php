<?php

    namespace App\Http\Resources\WorkHour;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UpdateWorkNotExistsResource extends JsonResource
    {

        public function __construct()
        {

        }

        public function withResponse(Request $request, JsonResponse $response)
        {
            parent::withResponse($request, $response->setStatusCode(402)); // TODO: Change the autogenerated stub
        }

        /**
         * Transform the resource into an array.
         *
         * @param  Request  $request
         * @return array<string, mixed>
         */
        public function toArray($request)
        {

            return [
                'message' => "WorkHour isn't exists.",
            ];
        }
    }
