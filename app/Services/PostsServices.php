<?php

namespace App\Services;

/**
	useing services to use functions in user side and in guest side too
	

 */
use App\Models\Posts;

class PostsServices 
{
	
	static public function getposts($value='')
	{

        /* shortening content size, since user is able to store big text in this column it may slow down site.*/

		return $posts=Posts::orderBy("created_at","DESC")->
        selectRaw("`id`,`created_at`,`title`,`created_at`,`picture`,left(`content`,150) as 'shorten_content'")
        ->paginate(9);
	}
}
