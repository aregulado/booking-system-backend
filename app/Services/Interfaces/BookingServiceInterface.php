<?php

namespace App\Services\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingServiceInterface
{
    public function createBooking(array $validatedData): array;
    public function getAllBookings(int $perPage = 10): LengthAwarePaginator;
}
