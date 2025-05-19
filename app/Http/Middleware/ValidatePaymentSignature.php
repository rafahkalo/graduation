<?php

namespace App\Http\Middleware;

use App\Models\FinancialTransaction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ValidateSignature as BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;

class ValidatePaymentSignature extends BaseMiddleware
{
    public function handle($request, Closure $next, ...$args)
    {
        // التحقق من التوقيع باستخدام method الـ Request
        if ($request->hasValidSignature()) {

            // التحقق الإضافي من وجود الدفعة
            $data = $request->route('payment');
            info('payment is ' . $data['id']);
            if (!FinancialTransaction::where('id', $data['id'])->exists()) {
                abort(404, 'Payment not found');
            }

            return $next($request);
        }

        // معالجة الخطأ
        return $this->handleInvalidSignature($request);
    }

    protected function handleInvalidSignature($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        abort(403, 'Invalid signature');
    }
}
