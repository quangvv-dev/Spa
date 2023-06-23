<?php

namespace App\Jobs;

use App\Models\ChamCong;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessChamCong implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $item)
    {
        $this->data = $data;
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $array_approval_code = User::select('approval_code')->whereNotNull('approval_code')->pluck('approval_code')->toArray();
        $input = [];
        $i = 0;

        foreach ($this->item as $vl){
            if (str_contains($vl['DateTimeRecord'], 'SA') || str_contains($vl['DateTimeRecord'], 'CH')) {
                $date = str_replace('SA', 'AM', $vl['DateTimeRecord']);
                $date = str_replace('CH', 'PM', $date);
                $date = date_create_from_format('d/m/Y g:i:s A', $date)->format('Y-m-d H:i:s');
            }elseif (str_contains($vl['DateTimeRecord'], 'AM') || str_contains($vl['DateTimeRecord'], 'PM')) {
                $date = date_create_from_format('d/m/Y g:i:s A', $vl['DateTimeRecord'])->format('Y-m-d H:i:s');
            } else {
                $date = Carbon::createFromFormat('d/m/Y H:i:s',$vl['DateTimeRecord'])->format('Y-m-d H:i:s');
            }
            $isset = ChamCong::where('name_machine', $this->data)->where('ind_red_id', $vl['IndRedID'])
                ->where('date_time_record', $date)->first();
            $approval_code = $this->data . '.' . $vl['IndRedID'];
            if (in_array($approval_code, array_values($array_approval_code))) {
                $i ++;
                if (empty($isset)) {
                    $input[] = [
                        'name_machine'     => $this->data,
                        'machine_number'   => $vl['MachineNumber'],
                        'date_time_record' => $date,
                        'ind_red_id'       => $vl['IndRedID'],
                        'approval_code'    => $approval_code,
                        'created_at'       => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                        'updated_at'       => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                    ];
                }
            }
        }
        ChamCong::insert($input);
        return "SUCCESS";
    }
}
