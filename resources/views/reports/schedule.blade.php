<table>
    <thead>
    <tr>
        <th class="px-2">Ref</th>
        <th>Name</th>
        <th>TERM</th>
        <th>Stay</th>
        <th>Time</th>
        <th>Return</th>
        <th>Reg</th>
        <th>Model</th>
        <th>Flight</th>
        <th>Mobile</th>
        <th>Px</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr class="border-b border-grey">
            <td class="px-2"><strong>{{ $booking['ref']}}</strong></td>
            <td class="px-2">{{ $booking['name'] }}</td>
            <td class="px-2">{{ $booking['terminal'] }}</td>
            <td class="px-2">{{ $booking['stay'] }}</td>
            <td class="px=2">{{ $booking['time'] }}</td>
          
            <td class="px-2">{{ $booking['return'] }}</td>
     
            <td class="px-2">{{ $booking['vehicle_reg'] }}</td>
            <td class="px-2">{{ $booking['vehicle'] }}</td>
            <td class="px-2">{{ $booking['flight'] }}</td>
            <td class="px-2">{{ $booking['mobile'] }}</td>
            {{--<td>{{ $booking['passengers'] }}</td>--}}
        </tr>
    @endforeach
    </tbody>
</table>