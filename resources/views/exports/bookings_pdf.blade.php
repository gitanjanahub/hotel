<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bookings Export</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* force consistent column widths */
        }

        th, td {
            border: 1px solid #666;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 120px;
        }

        th {
            background-color: #f5f5f5;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <h2>Booking Report</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 100px;">Customer Name</th>
                <th style="width: 80px;">Phone</th>
                <th style="width: 100px;">Room</th>
                <th style="width: 60px;">Rooms</th>
                <th style="width: 90px;">Total Price</th>
                <th style="width: 80px;">Payment</th>
                <th style="width: 80px;">Status</th>
                <th style="width: 110px;">Check-In</th>
                <th style="width: 110px;">Check-Out</th>
                <th style="width: 110px;">Booked At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking['Customer Name'] }}</td>
                    <td>{{ $booking['Phone'] }}</td>
                    <td>{{ $booking['Room'] }}</td>
                    <td>{{ $booking['No. of Rooms'] ?? '-' }}</td>
                    <td>{{ $booking['Total Price'] ?? '-' }}</td>
                    <td>{{ $booking['Payment Status'] }}</td>
                    <td>{{ $booking['Booking Status'] }}</td>
                    <td>{{ $booking['Check-In'] }}</td>
                    <td>{{ $booking['Check-Out'] }}</td>
                    <td>{{ $booking['Booked At'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
