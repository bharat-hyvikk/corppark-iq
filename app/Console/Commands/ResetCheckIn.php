<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetCheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-check-in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $vehicles = \App\Models\Vehicle::where('check_in_status', 'Not Parked')->whereNull("check_out_time")->get();
        foreach ($vehicles as $vehicle) {
            $vehicle->check_in_status = 'Not Parked';
            $vehicle->check_in_time = null;
            $vehicle->check_out_time = now();
            $vehicle->save();

            // Log the reset action vehicle id vehicle name vehicle office name 
            Log::channel('daily_auto_check_in')->info(
                'Reset check-in status for Vehicle ID: ' . $vehicle->id .
                    ' | Vehicle Number: ' . $vehicle->vehicle_number .
                    ' | Owner Phone: ' . $vehicle->owner_phone .
                    ' | Office Name: ' . $vehicle->office->office_name
            );
        }
        $this->info('Check-in status reset for all parked vehicles.');
        return 0;
    }
}
