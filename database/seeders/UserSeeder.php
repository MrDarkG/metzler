<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\User_profile;
use Str;
use Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	

        $user=User::create([
            'name'=>"admin",
            'email'=>"admin@mail.com",
            "password"=>Hash::make("roottoor"),
            
            "email_verified_at"=>Carbon::now()
        ]);
        User_profile::create([
            "avatar"=>"/avatars/default_logo.png",
            "surname"=>Str::random(12),
            "telephone"=>"+1324568",
            "user_id"=>$user->id
        ]);
    	for ($i=0; $i <5 ; $i++) { 
    		
        	$user=User::create([
	        	'name'=>Str::random(8),
		        'email'=>Str::random(12)."@mail.com",
	            "password"=>Hash::make(Str::random(24)),
		        
		        "email_verified_at"=>Carbon::now()
	        ]);
	        User_profile::create([
	        	"avatar"=>"/avatars/default_logo.png",
		    	"surname"=>Str::random(12),
		    	"telephone"=>"+1324568",
                "user_id"=>$user->id
	        ]);
    	}
    }
}
