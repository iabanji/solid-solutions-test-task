<?php

use App\TreeLeave;
use Illuminate\Database\Seeder;

class TreeLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TreeLeave::query()->truncate();

        for($i = 1; $i < 5; $i++) {
            $tree = TreeLeave::create([
                'title' => 'Leave-' . $i,
            ]);
            for($j = 1; $j < 5; $j++) {
                $tree1 = TreeLeave::create([
                    'parent_id' => $tree->id,
                    'title' => 'Leave-' . $i . '-' . $j,
                ]);
                for($k = 1; $k < 5; $k++) {
                    $tree2 = TreeLeave::create([
                        'parent_id' => $tree1->id,
                        'title' => 'Leave-' . $i . '-' . $j . '-' . $k,
                    ]);
                }
            }
        }
    }
}
