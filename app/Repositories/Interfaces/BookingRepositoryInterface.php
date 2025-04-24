<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    public function create(array $data): Booking;
    public function getAllWithRoomsPaginated(int $perPage = 10): LengthAwarePaginator;
    public function hasOverlappingBookings(int $roomId, string $checkInDate, string $checkOutDate): bool;
}
