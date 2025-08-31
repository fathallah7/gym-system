<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #4F46E5;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .content {
            padding: 20px;
        }

        .invoice-details {
            margin: 20px 0;
            border-collapse: collapse;
            width: 100%;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .invoice-details th {
            background: #f4f4f7;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #4F46E5;
        }

        .footer {
            padding: 15px;
            text-align: center;
            background: #f4f4f7;
            font-size: 12px;
            color: #777;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Invoice #{{ $invoice->number }}</h1>
            <p>Thank you for your purchase</p>
        </div>
        <div class="content">
            <p>Hello {{ $invoice->membership->member->name ?? 'Customer' }},</p>
            <p>Here are the details of your invoice:</p>

            <table class="invoice-details">
                <tr>
                    <th>Invoice Number</th>
                    <td>{{ $invoice->number }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td class="total">{{ number_format($invoice->total_amount, 2) }} EGP</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($invoice->status) }}</td>
                </tr>
                <tr>
                    <th>Plan</th>
                    <td>{{ $invoice->membership->plan->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ $invoice->membership->start_date }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ $invoice->membership->end_date }}</td>
                </tr>
            </table>

            <a href="#" class="btn">Download</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Black fox Gym. All rights reserved.
        </div>
    </div>
</body>

</html>