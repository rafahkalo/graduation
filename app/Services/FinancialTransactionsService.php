<?php

namespace App\Services;

use App\Models\FinancialTransaction;
use App\Models\Notification;
use App\Models\PaymentToLandlord;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\FinancialTransactionsRepo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class FinancialTransactionsService
{

    public function __construct(
        private FinancialTransactionsRepo $repo,
    private PaymentToLandlordService $paymentToLandlordService,)
    {
    }

    public function index(int $per_page = 0, ?string $status = null): Collection|LengthAwarePaginator
    {
        $filters = array_filter([
            'status' => $status,
        ]);

        $with = ['reservation.user', 'reservation.tenant'];

        return $this->repo->index(
            per_page: $per_page,
            filters: $filters,
            with: $with
        );
    }

    public function create(string $reservationId)
    {
         $data = [];
        $reservation = Reservation::find($reservationId);
        $data['reservation_id'] = $reservationId;
        $data['lessor_commission_amount'] = $reservation->lessor_commission_amount;
        $data['lessor_amount'] = $reservation->lessor_amount;
        $data['tenant_commission_amount'] = $reservation->tenant_commission_amount;
        $data['tenant_amount'] = $reservation->lessor_commission_amount;
        $data['platform_commission_amount'] = $reservation->lessor_commission_amount;

        $this->repo->create($data);
    }

    public function handlePaymentToLandlord(array $data): void
    {
        if ($this->paymentExists($data['financial_transaction_id'])) {
            return;
        }

        $financialTransaction = FinancialTransaction::findOrFail($data['financial_transaction_id']);
        $reservation = Reservation::findOrFail($financialTransaction->reservation_id);

        $signedUrl = $this->generateSignedUrl($data['financial_transaction_id']);
        $this->sendConfirmationNotification($signedUrl);

        $this->createPaymentToLandlord($data, $reservation->user_id);
        $this->updateStatusOfFinancialTransaction($data['financial_transaction_id']);
    }

    protected function paymentExists(string $transactionId): bool
    {
        return PaymentToLandlord::where('financial_transaction_id', $transactionId)->exists();
    }

    protected function generateSignedUrl(string $transactionId): string
    {
        return URL::temporarySignedRoute(
            'payments.confirm',
            now()->addHours(24),
            ['payment' => $transactionId]
        );
    }

    protected function sendConfirmationNotification(string $signedUrl): void
    {
        Notification::create([
            'type' => 'payment-confirmation',
            'data' => json_encode([
                'url' => $signedUrl,
                'message' =>  'notifications.payment_confirmation',
            ])
        ]);
    }

    protected function createPaymentToLandlord(array $data, string $userId): void
    {
        $this->paymentToLandlordService->create([
            'financial_transaction_id' => $data['financial_transaction_id'],
            'bank_id' => $data['bank_id'],
            'type_transfer' => $data['type_transfer'],
            'admin_id' => Auth::id(),
            'user_id' => $userId,
            'user_type' => User::class,
        ]);
    }

    protected function updateStatusOfFinancialTransaction(string $financial_transaction_id): void
    {
        $this->repo->update(['status' => 'sent'], $financial_transaction_id);
    }
}
