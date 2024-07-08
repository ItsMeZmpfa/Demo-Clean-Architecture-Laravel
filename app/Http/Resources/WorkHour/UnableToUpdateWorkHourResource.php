<?php

    namespace App\Http\Resources\WorkHour;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Throwable;

    class UnableToUpdateWorkHourResource extends JsonResource
    {
        protected Throwable $e;

        public function __construct(Throwable $e)
        {
            $this->e = $e;
        }

        public function withResponse(Request $request, JsonResponse $response)
        {
            parent::withResponse($request, $response->setStatusCode(403));
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
                'message' => $this->e->getMessage(),
            ];
        }
    }
