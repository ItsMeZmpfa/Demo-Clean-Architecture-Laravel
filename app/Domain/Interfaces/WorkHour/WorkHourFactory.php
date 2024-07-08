<?php

namespace App\Domain\Interfaces\WorkHour;

interface WorkHourFactory
{
    /**
     * Create a Factory Object for new User
     *
     * @param array<mixed> $attributes
     * @return WorkHourEntity
     */
    public function makeWorkHour(array $attributes = []): WorkHourEntity;


}
