<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\User;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test yoyo';

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
        $user = new User();
        $new = $user->getUsers('babyshark');
        if (empty($new)) {
            $msg = '你的帳號或密碼不正確，請稍後再試';
            var_dump($msg);
        }
        var_dump($new->password);

        return 0;
    }
}
