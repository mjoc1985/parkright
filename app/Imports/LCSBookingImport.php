<?php

namespace App\Imports;

use App\AgentProduct;
use App\Agents;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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
     * @throws \Exception
     */
    public function model(array $row)
    {
        // Skip the row if the booking reference field is empty.
        if (empty($row['bookingref'])) {
            return null;
        }

            $name = explode(" ", $row['name']);
            if (count($name) < 3){
                $firstname = '?';
                $lastname = $name[1];
            } else {
                $firstname = $name[1];
                $lastname = $name[2];
            }

            $bookingData = [
                'title' => $name[0],
                'first_name' => $firstname,
                'last_name' => $lastname,
                'phone' => null,
                'mobile' => $row['mobile'],
                'arrival_date' => $this->getDate($row['datefrom'], $row['meettime']),
                'arrival_time' => $row['meettime'],
                'return_date' => $this->getDate($row['returndate'], $row['returntime']),
                'return_time' => $row['returntime'],
                'terminal_out' => $row['term'],
                'terminal_in' => $row['term'],
                'flight_out' => null,
                'flight_in' => $row['fliteno'],
                'vehicle' => $row['model'],
                'vehicle_reg' => $row['reg'],
                'vehicle_colour' => null,
                'list_price' => $row['paid'],
                'price_paid' => $row['paid'],
                'supplier_cost' => (float)$row['paid'] / 100 * 75,
                'product_id' => $row['product'],
                'passengers' => $row['pass']
            ];
            if (key_exists('passengers', $row)) {
                $bookingData['passengers'] = $row['passengers'];
            }
            if ($booking = Booking::where('ref', $row['bookingref'])->first()) {
                if (key_exists('status', $row)) {
                    $booking->status = $row['status'];
                }
                $booking->agent_id = $this->agent['id'];
                $booking->agents_products_id = $row['product'];
                $booking->product_id = $this->getProduct($this->agent['id'], $row['product']);
                $booking->booking_data = $bookingData;

            } else {
                $booking = new Booking([
                    'agent_id' => $this->agent['id'],
                    'agents_products_id' => $row['product'],
                    'product_id' => $this->getProduct($this->agent['id'], $row['product']),
                    'ref' => $row['bookingref'],
                    'status' => 'booked',
                    'created_at' => Carbon::now()
                ]);
                $booking->booking_data = $bookingData;
            }
            $booking->save();
            return $booking;
        
        
    }

    /**
     * @param $date
     * @return string
     * @throws \Exception
     */
    public function getDate($date, $time)
    {
       // $newDate = preg_replace('~\x{00a0}~u', ' ', $date);
      $newDate = Carbon::createFromFormat('d/m/Y H:i', $date . ' ' .$time);
        return $newDate->toDateTimeString();
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
            $event->reader->ignoreEmpty();
            }
        ];
    }

    public function getProduct($agentId, $productId)
    {
        $agentProduct = AgentProduct::where('agent_id', $agentId)->where('agent_code', $productId)->first();

        return $agentProduct->product->id;


    }

//    /**
//     * @return array
//     */
//    public function columnFormats(): array
//    {
//        return [
//            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
//            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
//        ];
//    }
}
