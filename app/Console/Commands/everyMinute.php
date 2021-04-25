<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Factory;


class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ScheduleSwitch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it use switch on/off light';

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
     * @return int
     */
    public function handle()
    {
        $factory = (new Factory())
        ->withDatabaseUri('https://demohung-79e75-default-rtdb.firebaseio.com');

        $database   =   $factory->createDatabase();      

        $reference = $database->getReference();
  
        $userHome =$reference->getValue();
    
        foreach($userHome as $key => $locations)
        {

            if($locations==null)
            {
                        
                continue;
            }
            foreach($locations as $key1=>$lights){
                foreach($lights as $key2=>$value){
                   
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                  
                    $timefirebase=$value['TimeOn'][0].$value['TimeOn'][1].':'.$value['TimeOn'][3].$value['TimeOn'][4];
                    if($timefirebase==date("H:i")){
                        $updates = [
                            "$key/$key1/$key2/status"=> 'ON',
                        ];//tạo mảng với key là route để lưu vào firebase nếu chưa có thì nó sẽ thêm mới   
                        $database->getReference('') // this is the root reference
                        ->update($updates);
                    }
               
                }
            }

        }
        echo "done update";
    }
}
