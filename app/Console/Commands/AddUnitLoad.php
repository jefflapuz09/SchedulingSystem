<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddUnitLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddUnitLoad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AddUnitLoad';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = \App\User::where('accesslevel',1)->get();
        foreach($users as $user){
            $info = \App\instructors_infos::where('instructor_id',$user->id)->first();
            if(!empty($info)){
               $record = new \App\UnitsLoad;
               $record->instructor_id = $user->id;
               $record->employee_type = $info->employee_type;
               if($info->employee_type == 'Full Time'){
                   $record->units = 36;
               }else{
                   $record->units = 15;
               }
               $record->save();
            }
        }
    }
}
