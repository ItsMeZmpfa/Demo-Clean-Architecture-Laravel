<?php

    namespace App\Http\Resources\User;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserSearchResource extends JsonResource
    {
        protected $userRecords;

        public function __construct($userRecords)
        {
            $this->userRecords = $userRecords;
        }

        public function withResponse(Request $request, JsonResponse $response)
        {
            parent::withResponse($request, $response->setStatusCode(200));
        }

        /**
         * Transform the resource into an array.
         *
         * @param  Request  $request
         * @return array
         */
        public function toArray($request)
        {
            return [
                'data' => $this->userRecords,
            ];
        }
    }
