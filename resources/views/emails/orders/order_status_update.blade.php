<!DOCTYPE html>
<html lang="en" style="background-color: #f8f9fa;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ ucfirst($latestStatus->name) }}- #{{ $order->id }} | {{ env('APP_NAME') }}</title>

    @php $base_url = URL::to('/'); @endphp
</head>

<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0;">
    <span style="display: none;">Update for order #{{ $order->id }}</span>

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #fff; border: 1px solid #dee2e6; border-radius: 8px;">
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #343a40;">
                {{-- <img src="{{ asset('custom-assets/default/admin/images/siteimages/logo/header-logo-c.png') }}"
                    height="50" alt="{{ config('app.name') }}"> --}}
                <h2 style="color: #fff; margin: 0;">{{ config('app.name') }}</h2>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px;">
                <p>Hello <strong>{{ $order->user->name ?? 'Customer' }}</strong>,</p>
                <p style="color: #007bff;"><strong> Your Order No. #{{ $order->id }} | {{ $latestStatus->description }}</strong></p>

                {{-- Latest Status --}}
                <p><strong>Status:</strong> {{ ucfirst($latestStatus->name) }}</p>
                @if ($latestStatus->pivot->description)
                    <p style="font-size: 14px;">{{ $latestStatus->pivot->description }}</p>
                @endif

                {{-- Order Summary --}}
                <h3 style="border-bottom: 1px solid #ccc;">Order Summary</h3>
                <table width="100%" cellpadding="8">
                    <tr>
                        <td><strong>Subtotal:</strong></td>
                        <td style="text-align: right;">${{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td><strong>Shipping:</strong></td>
                        <td style="text-align: right;">${{ number_format($order->shipping_charge, 2) }}</td>
                    </tr>
                    <tr style="background-color: #d4d4d4;">
                        <td><strong>Total:</strong></td>
                        <td style="text-align: right; color: green;">
                            <strong>${{ number_format($order->total_order, 2) }}</strong></td>
                    </tr>
                </table>

                <h3 style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px;">Order Status Timeline</h3>
                <table width="100%" cellpadding="10" cellspacing="0"
                    style="border-left: 4px solid #6c757d; margin-bottom: 20px;">
                    @foreach ($order->statuses as $status)
                        <tr>
                            <td style="padding-left: 10px;border-bottom: 2px dashed #000000;">
                                <p style="margin: 0; font-weight: bold;">
                                    {{ ucfirst($status->name) }}
                                    @if ($status->id === $latestStatus->id)
                                        <span style="color: #28a745;">(Latest)</span>
                                    @endif
                                </p>
                                <p style="margin: 5px 0;">{{ $status->description ?? '-' }}</p>
                                <p style="margin: 0; font-size: 12px; color: #6c757d;">
                                    {{ $status->pivot->created_at->format('d M Y, h:i A') }}
                                </p>
                                <p style="margin: 0; font-size: 13px;">{!! $status->pivot->description ?? '-' !!}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>

                {{-- View Button --}}
                <div style="text-align: center; margin: 25px 0;">
                    <a href="{{ route('front.orders.details', ['id' => $order->id]) }}"
                        style="background: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View
                        Order Details</a>
                </div>

                <p>Thanks,<br><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; font-size: 12px; color: #6c757d; padding: 15px;">
                If you have any questions, contact us at <a target="_blank" href="{{ $base_url }}/contact"
                    style="color: #007bff;">{{ env('APP_NAME', 'Laravel App') }}</a>
            </td>
        </tr>
    </table>
</body>

</html>
