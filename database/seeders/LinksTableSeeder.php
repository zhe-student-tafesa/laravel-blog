<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data=[
            [
                'link_name' => '百度',
                'link_title' =>'百度一下，中国最好的搜索引擎',
                'link_url' => 'www.baidu.com',
                'link_order' => 1,
            ],
            [
                'link_name' => '谷歌',
                'link_title' =>'google一下，世界最好的搜索引擎',
                'link_url' => 'www.google.com',
                'link_order' => 2,
            ]

        ];
        DB::table('links')->insert($data);
    }
}
