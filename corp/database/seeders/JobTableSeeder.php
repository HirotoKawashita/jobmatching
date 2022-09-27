<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Job;

class JobTableSeeder extends Seeder {

    public function run() {
        DB::table('jobs')->truncate();
        Job::factory()->count(20)->create();
    }
}
