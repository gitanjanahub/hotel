<!DOCTYPE html>
<html>
<head>
    <title>Room Types List</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Room Types List</h2>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Rooms</th>
                <th>Is Active</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roomtypes as $index => $roomtype)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $roomtype['Room Type Name'] }}</td>
                    <td>{{ $roomtype['Rooms'] }}</td>
                    <td>{{ $roomtype['Is Active'] }}</td>
                    <td>{{ $roomtype['Created At'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
