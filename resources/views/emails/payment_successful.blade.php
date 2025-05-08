<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body>
    <h1>Thank you for your payment!</h1>
    <p>Payment ID: {{ $payment->stripe_payment_id }}</p>
    <p>Amount: ${{ number_format($payment->amount / 100, 2) }}</p>
    <p>Status: {{ $payment->status }}</p>
</body>
</html>
