{{-- resources/views/exports/rooms_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Rooms PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Rooms List</h2>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Room Name</th>
                <th>Room Type</th>
                <th>Services</th>
                <th>Is Active</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room['S.No'] }}</td>
                <td>{{ $room['Room Name'] }}</td>
                <td>{{ $room['Room Type'] }}</td>
                <td>{{ $room['Services'] }}</td>
                <td>{{ $room['Is Active'] }}</td>
                <td>{{ $room['Created At'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
