<?php

namespace App\Repositories\Interfaces;

use App\Models\Room;

interface RoomRepositoryInterface
{
    public function findById(int $id): ?Room;
    public function isAvailable(int $id): bool;
}
