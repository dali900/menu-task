<!DOCTYPE html>
<html>
<head>
    <style>
        .right {
            text-align: right;
        }
        .left {
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Order</h2>
    <table>
        <tr>
            <td class="right">ID:</td>
            <td class="left">{{ $data['id'] }}</td>
        </tr>
        <tr>
            <td class="right">Amount purchased:</td>
            <td class="left">{{ $data['amount_purchased']}}</td>
        </tr>
        <tr>
            <td class="right">Exchange rate:</td>
            <td class="left">{{ $data['exchange_rate'] }}</td>
        </tr>
        <tr>
            <td class="right">Surcharge percentage:</td>
            <td class="left">{{ $data['surcharge_percentage'] }}%</td>
        </tr>
        <tr>
            <td class="right">Surcharge amount:</td>
            <td class="left">{{ $data['surcharge_amount'] }}</td>
        </tr>
        <tr>
            <td class="right">Total amount:</td>
            <td class="left">{{ $data['total_amount_usd'] }}</td>
        </tr>
        <tr>
            <td class="right">Discount percentage:</td>
            <td class="left">{{ $data['discount_percentage'] }}%</td>
        </tr>
        <tr>
            <td class="right">Discount amount:</td>
            <td class="left">{{ $data['discount_amount'] }}</td>
        </tr>
        <tr>
            <td class="right">Final payment:</td>
            <td class="left">{{ $data['amount_paid_usd'] }}</td>
        </tr>
    </table>
</body>

</html>