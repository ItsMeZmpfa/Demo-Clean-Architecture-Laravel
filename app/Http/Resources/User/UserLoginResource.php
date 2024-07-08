<?php

    namespace App\Http\Resources\User;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserLoginResource extends JsonResource
    {
        protected $token;

        public function __construct($token)
        {
            $this->token = $token;
        }

        public function withResponse(Request $request, JsonResponse $response)
        {
            parent::withResponse($request, $response->setStatusCode(200));
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
                'token' => $this->token,
            ];
        }
    }
