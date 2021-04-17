<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts;
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <50 ; $i++) { 
        	Posts::create([
        		"picture"=>"/posts/coverimagevsfeaturedimage.png",
        		"content"=>"This is post with number $i. it is generated from seeder so almost evry text is same",
        		"title"=>"post with number of $i",
        		"user_id"=>1
        	]);
        }
    }
}
