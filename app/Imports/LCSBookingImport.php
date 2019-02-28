<?php

namespace App\Imports;

use App\Agents;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LCSBookingImport implements ToModel, WithHeadingRow
{
    protected $agent;
    
    public function __construct(Agents $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        $name = explode(" ", $row['name']);
        
        $bookingData = [
            'title' => $name[0],
            'first_name' => $name[1],
            'last_name' => $name[2],
            'phone' => null,
            'mobile' => $row['mobile'],
            'arrival_date' => $this->getDate($row['datefrom']),
            'arrival_time' => $row['meettime'],
            'return_date' => $this->getDate($row['returndate']),
            'return_time' => $row['returntime'],
            'terminal_out' => $row['term'],
            'terminal_in' => $row['term'],
            'flight_out' => null,
            'flight_in' => $row['fliteno'],
            'vehicle' => $row['model'],
            'vehicle_reg' => $row['reg'],
            'vehicle_colour' => null,
            'list_price' =>$row['paid'],
            'price_paid' => $row['paid'],
            'supplier_cost' => $row['paid'] / 100 * 75,
            'product_id' => $row['product']
            //'passengers' => $row['passengers']
        ];
        if (key_exists('passengers', $row)){
            $bookingData['passengers'] = $row['passengers'];
        }
        if ($booking = Booking::where('ref', $row['bookingref'])->first()) {
            if (key_exists('status', $row)) {
                $booking->status = $row['status'];
            }
            $booking->booking_data = $bookingData;

        } else {
            $booking = new Booking([
                'agent_id' => $this->agent['id'],
                'ref' => $row['bookingref'],
                'status' => 'booked',
                'created_at' => Carbon::now()
            ]);
            $booking->booking_data = $bookingData;
        }
        $booking->save();
        return $booking;
    }
    
    public function getDate($date)
    {
       // $newDate = preg_replace('~\x{00a0}~u', ' ', $date);
        $newDate = Carbon::parse(strtotime($date));
        return $newDate->format('d-m-Y');
    }
}
