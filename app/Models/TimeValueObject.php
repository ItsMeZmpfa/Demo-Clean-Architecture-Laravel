<?php

    namespace App\Models;

    use Carbon\Carbon;

    class TimeValueObject
    {
        private Carbon $date;

        public function __construct(string $date)
        {

            $dateInfo = Carbon::createFromFormat('Y-m-d H:i:s', $date);


            $this->date = $dateInfo;

        }

        public function getDayMonthYear()
        {
            $infoDayMonthYear = $this->date->format('d-m-Y');

            return $infoDayMonthYear;
        }

        public function getYear()
        {
            return $this->date->year;
        }

        public function getMonth()
        {
            return $this->date->month;
        }

        public function getDay()
        {
            return $this->date->day;
        }


        public function isEqualTo(self $newDate): bool
        {
            return $this->date->toDateTimeString() === $newDate->date->toDateTimeString();
        }

        public function toString()
        {
            return $this->date->toDateTimeString();
        }
    }
