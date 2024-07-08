<?php

    namespace App\Http\Resources\User;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserNotFoundResource extends JsonResource
    {
        public function __construct()
        {

        }

        public function withResponse(Request $request, JsonResponse $response)
        {
            parent::withResponse($request, $response->setStatusCode(402));
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
                'message' => "User not found",
            ];
        }
    }
