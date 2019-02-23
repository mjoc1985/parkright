<table>
    <thead>
    <tr>
        <th>Ref</th>
        <th>Name</th>
        <th>TERM</th>
        <th>Stay</th>
        <th>Time</th>
        <th>Return</th>
        <th>Reg</th>
        <th>Model</th>
        <th>Flight</th>
        <th>Mobile</th>
        <th>PX</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking['ref']}}</td>
            <td>{{ $booking['name'] }}</td>
            <td>{{ $booking['terminal'] }}</td>
            <td>{{ $booking['stay'] }}</td>
            <td>{{ $booking['time'] }}</td>
            @if(key_exists('return', $booking))
            <td>{{ $booking['return'] }}</td>
            @endif
            <td>{{ $booking['vehicle_reg'] }}</td>
            <td>{{ $booking['vehicle'] }}</td>
            <td>{{ $booking['flight'] }}</td>
            <td>{{ $booking['mobile'] }}</td>
            <td>{{ $booking['passengers'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>