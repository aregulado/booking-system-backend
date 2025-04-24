<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingCollection;
use App\Services\Interfaces\BookingServiceInterface;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Booking API",
 *     version="1.0.0",
 *     description="API for managing hotel room bookings"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingServiceInterface $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Get all active bookings",
     *     tags={"Bookings"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of bookings",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="guest_name", type="string"),
     *                 @OA\Property(property="check_in_date", type="string", format="date"),
     *                 @OA\Property(property="check_out_date", type="string", format="date"),
     *                 @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"}),
     *                 @OA\Property(property="promo_code", type="string", nullable=true),
     *                 @OA\Property(property="room", type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="number", type="string"),
     *                     @OA\Property(property="type", type="string"),
     *                     @OA\Property(property="is_available", type="boolean")
     *                 )
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index(): JsonResponse
    {
        $bookings = $this->bookingService->getAllBookings();
        return response()->json(new BookingCollection($bookings));
    }

    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Create a new booking",
     *     tags={"Bookings"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"guest_name", "room_id", "check_in_date", "check_out_date"},
     *             @OA\Property(property="guest_name", type="string", maxLength=255),
     *             @OA\Property(property="room_id", type="integer"),
     *             @OA\Property(property="check_in_date", type="string", format="date"),
     *             @OA\Property(property="check_out_date", type="string", format="date"),
     *             @OA\Property(property="promo_code", type="string", nullable=true, maxLength=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Booking created"),
     *             @OA\Property(property="booking", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="guest_name", type="string"),
     *                 @OA\Property(property="room_id", type="integer"),
     *                 @OA\Property(property="check_in_date", type="string", format="date"),
     *                 @OA\Property(property="check_out_date", type="string", format="date"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="promo_code", type="string", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=409, description="Conflict - Room not available"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function store(CreateBookingRequest $request): JsonResponse
    {
        $result = $this->bookingService->createBooking($request->validated());

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message']
            ], $result['status']);
        }

        return response()->json([
            'message' => $result['message'],
            'booking' => new BookingResource($result['booking']),
        ], $result['status']);
    }
}
