<div>
    <table>
        <thead>
        <tr>
            <th>Schedule for: {{ $schedule->date->format('d-m-Y') }}</th>
        </tr>
        </thead>
    </table>
    <table>

        <thead>
        <tr>
            <th class="px-2">Ref</th>
            <th class="px-2">Name</th>
            <th class="px-2">Terminal</th>
            <th class="px-2">Stay</th>
            {{--<th class="px-2">Arrival</th>--}}
            <th class="px-2">Time</th>
            <th class="px-2">Type</th>

            {{--<th class="px-2">Return</th>--}}
            {{--<th class="px-2">Time</th>--}}
            <th class="px-2">Reg</th>
            <th class="px-2">Model</th>
            <th class="px-2">Flight</th>
            <th class="px-2">Mobile</th>
            <th class="px-2">Passengers</th>
            <th class="px-2">Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($schedule->bookings as $booking)
            <tr class="border-b border-grey">
                <td class="px-2"><strong>{{ $booking['ref']}}</strong></td>
                <td class="px-2">{{ $booking['name'] }}</td>
                <td class="px-2 text-center">{{ $booking['terminal'] }}</td>
                <td class="px-2 text-center">{{ $booking['stay'] }}</td>
                {{--<td class="px-2">{{ $booking['arrival_date'] }}</td>--}}
                <td class="px-2">{{ $booking['time'] }}</td>
                <td class="px-2 text-center">{{ $booking['type'] }}</td>

                {{--<td class="px-2">{{ $booking['return_date'] }}</td>--}}
                {{--<td class="px-2">{{ $booking['return'] }}</td>--}}

                <td class="px-2">{{ $booking['vehicle_reg'] }}</td>
                <td class="px-2">{{ $booking['vehicle'] }}</td>
                <td class="px-2">{{ $booking['flight'] }}</td>
                <td class="px-2">{{ $booking['mobile'] }}</td>
                <td class="px-2 text-center">{{ $booking['passengers'] }}</td>
                <td class="px-2 text-center">{{ $booking['price_paid'] }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>