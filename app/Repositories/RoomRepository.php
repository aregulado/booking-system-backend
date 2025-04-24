<?php

namespace App\Repositories;

use App\Models\Room;
use App\Repositories\Interfaces\RoomRepositoryInterface;

class RoomRepository implements RoomRepositoryInterface
{
    public function findById(int $id): ?Room
    {
        return Room::find($id);
    }

    public function isAvailable(int $id): bool
    {
        $room = $this->findById($id);
        return $room ? $room->is_available : false;
    }
}
