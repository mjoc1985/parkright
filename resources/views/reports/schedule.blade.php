<table>
    
    <thead>
    <tr>
        <th class="px-2">Ref</th>
        <th class="px-2">Name</th>
        <th class="px-2">TERM</th>
        <th class="px-2">Stay</th>
        <th class="px-2">Time</th>
        <th class="px-2">Return</th>
        <th class="px-2">Reg</th>
        <th class="px-2">Model</th>
        <th class="px-2">Flight</th>
        <th class="px-2">Mobile</th>
        <th class="px-2">Passengers</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr class="border-b border-grey">
            <td class="px-2"><strong>{{ $booking['ref']}}</strong></td>
            <td class="px-2">{{ $booking['name'] }}</td>
            <td class="px-2 text-center">{{ $booking['terminal'] }}</td>
            <td class="px-2 text-center">{{ $booking['stay'] }}</td>
            <td class="px=2">{{ $booking['time'] }}</td>
          
            <td class="px-2">{{ $booking['return'] }}</td>
     
            <td class="px-2">{{ $booking['vehicle_reg'] }}</td>
            <td class="px-2">{{ $booking['vehicle'] }}</td>
            <td class="px-2">{{ $booking['flight'] }}</td>
            <td class="px-2">{{ $booking['mobile'] }}</td>
            <td class="px-2 text-center">{{ $booking['passengers'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>