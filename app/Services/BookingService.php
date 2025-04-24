<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Services\Interfaces\BookingServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BookingService implements BookingServiceInterface
{
    protected $bookingRepository;
    protected $roomRepository;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        RoomRepositoryInterface $roomRepository
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->roomRepository = $roomRepository;
    }

    public function createBooking(array $validatedData): array
    {
        // Transaction to ensure data integrity
        return DB::transaction(function () use ($validatedData) {
            // Check if the room is available
            if (!$this->roomRepository->isAvailable($validatedData['room_id'])) {
                return [
                    'success' => false,
                    'message' => 'The selected room is not available.',
                    'status' => 409
                ];
            }

            // Check for overlapping bookings
            if ($this->bookingRepository->hasOverlappingBookings(
                $validatedData['room_id'],
                $validatedData['check_in_date'],
                $validatedData['check_out_date']
            )) {
                return [
                    'success' => false,
                    'message' => 'The room is not available for the selected dates.',
                    'status' => 409
                ];
            }

            // Create booking
            $booking = $this->bookingRepository->create([
                'guest_name' => $validatedData['guest_name'],
                'room_id' => $validatedData['room_id'],
                'check_in_date' => $validatedData['check_in_date'],
                'check_out_date' => $validatedData['check_out_date'],
                'status' => 'pending',
                'promo_code' => $validatedData['promo_code'] ?? null,
            ]);

            return [
                'success' => true,
                'message' => 'Booking created',
                'booking' => $booking,
                'status' => 201
            ];
        });
    }

    public function getAllBookings(int $perPage = 10): LengthAwarePaginator
    {
        return $this->bookingRepository->getAllWithRoomsPaginated($perPage);
    }
}
