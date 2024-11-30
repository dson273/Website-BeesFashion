<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('theme/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('theme/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Notification library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Slimselect -->
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    
    <!-- RateYo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .invoice-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 150px;
            box-sizing: border-box;
        }

        .sku {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        .customer-info, .order-info {
            margin-bottom: 20px;
        }

        h3 {
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        p {
            margin: 5px 0;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .cod {
            font-size: 70px;
            font-weight: bold;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        .total .amount {
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="bg-img"><img src="" alt=""></div>
        <div class="header">
            @foreach ($order->order_details as $detail)
                <div class="barcode">
                    {!! $barcodes[$detail->product_variant->SKU] !!}
                </div>
                <div class="sku">
                    {{ $detail->product_variant->SKU }}
                </div>
            @endforeach
        </div>
        <div class="customer-info">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->full_name }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
        </div>
        <div class="order-info">
            <h3>Order Information</h3>
            <strong>Payment Method:</strong>
            <p class="cod"> {{ $order->payment_method }}</p>
        </div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Discount code</th>
                    <th>Shipping fee</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->order_details as $detail)
                    <tr>
                        <td><strong>{{ $detail->product_variant->product->name }}</strong></td>
                        <td>{{  number_format($detail->order->voucher, 0, ',', '.') }}₫</td>
                        <td>{{  number_format($detail->order->shipping_voucher, 0, ',', '.') }}₫</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->original_price, 0, ',', '.') }}₫</td>
                        <td>{{ number_format($detail->quantity * $detail->original_price, 0, ',', '.') }}₫</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <div class="label">Total Amount and Tax:</div>
            <div class="amount">{{ number_format($order->total_payment, 0, ',', '.') }}₫</div>
        </div>
    </div>
</body>
</html>
