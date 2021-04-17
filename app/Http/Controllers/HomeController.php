<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Storage;
use App\Models\Posts;
use App\Models\User;
use App\Services\PostsServices;
use App\Rules\CostumImageValidation;
use App\Rules\MatchOldPassword;
use App\Models\User_profile;

use App\Rules\PhoneNumberValidation;

use \Hash;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts=PostsServices::getposts();
        
        return view('home',["posts"=>$posts]);
    }
    public function create()
    {
        return view("users.posts.create");
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            "title"=>"required|min:4|max:256|string",
            "content"=>"required|min:4|string",
            "cover"=>["required",New CostumImageValidation]
        ]);
        $image_name=uniqid().time().".jpg";
        $base64_image = $request->input("cover");
        $data = substr($base64_image, strpos($base64_image, ',') + 1);
        $data = base64_decode($data);
        Storage::disk('covers')->put($image_name, $data);
    

            
        Posts::create([
            "user_id"=>Auth::user()->id,
            "content"=>$request->input("content"),
            "title"=>$request->input("title"),
            "picture"=>"/posts/".$image_name
        ]);
        return route("user.index");

    }
    
    public function edit($id)
    {
        $post=Posts::where("id",$id)->firstOrFail();
        return view("users.posts.edit",["post"=>$post]);
    }
    public function update(Request $request)
    {
        $post=Posts::where("id",$request->input("id"));
        $picture_now=$post->firstOrFail()->picture;
        $this->deletefile($picture_now);
        $image_name=uniqid().time().".jpg";
        
        if ($request->input("cover")) {
            /*because of crop i have to check image manually*/
            if (preg_match('/^data:image\/(\w+);base64,/', $request->input("cover"))) {
                $base64_image = $request->input("cover");
                $data = substr($base64_image, strpos($base64_image, ',') + 1);
                $data = base64_decode($data);
                Storage::disk('covers')->put($image_name, $data);
                $image_name=$image_name;
                // return 1;

            }
            else{
                /* return costum error message if file format was incorrect*/

                $data=[
                    "message"=> "The given data was invalid.",
                    "errors"=> [
                        "cover"=> [
                            "Cover is not allowed file format in our system."
                        ]
                    ]
                ];
                return response(
                    json_encode($data)
                , 422)->header('Content-Type', 'application/json');
            }
        }
        if (is_null($request->input("cover"))) {
            $image_name= $picture_now;
        }
        
        $post->update([
            "user_id"=>Auth::user()->id,
            "content"=>$request->input("content"),
            "title"=>$request->input("title"),
            "picture"=>"/posts/".$image_name

        ]);
        return route("user.index");
    }
    public function deletefile($name)
    {
        if ($name!="/posts/coverimagevsfeaturedimage.png") {

             Storage::disk("delete")->delete($name);
        }
        else{
            return $name."dark";
        }
    }
    public function delete(Request $request)
    {
        $post=Posts::where("id",$request->input("id"));
        $post_picture=$post->firstOrFail()->picture;
        $post->delete();
        $this->deletefile($post_picture);
        return redirect()->back();
    }
    public function profile($value='')
    {
        $user_id=Auth::user()->id;
        $user=User::where("id",$user_id)->with(["user_profile"])->first();;
        return view("users.profile.index",["user"=>$user]);
    }
    public function updateuserpassword(Request $request)
    {
        $this->validate($request,[
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required',"min:8"],
            'new_confirm_password' => ['same:new_password'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
    }
    public function deleteoldpicture($name)
    {
        if ($name!="/avatars/default_logo.png") {
            // return $name;
            Storage::disk("delete")->delete($name);
        }
        return $image_name=uniqid().time().".jpg";
        
    }
    public function updateuserinformation(Request $request)
    {
        $this->validate($request,[
            "email"=>'required|string|email|max:255',
            "picture"=>["nullable", new CostumImageValidation],
            "name"=>"required|string|max:255",
            "surname"=>"nullable|string",
            'user_id' => ['required',"numeric"],
            'phone' => ['nullable', new PhoneNumberValidation]
        ]);
        $user=User::where([
            ["email",$request->input("email")],
            ["id",Auth::user()->id],
        ])->count();
        if ($user==0) {
            $this->validate($request,[
                "email"=>'required|string|email|max:255|unique:users',
            ]);
        }
        $user_old_picture=User_profile::where("user_id",Auth::user()->id)->firstOrFail()->avatar;
        $picture_name="default_logo.png";
        if (!is_null($request->input("picture"))) {
            $picture_name=$this->deleteoldpicture($user_old_picture);
            $base64_image = $request->input("picture");
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            Storage::disk('avatars')->put($picture_name, $data);
            
        }
        User::where("id",$request->input("user_id"))->update([
            'name'=>$request->input("name"),
            'email'=>$request->input("email")
        ]);
        User_profile::where("user_id",$request->input("user_id"))->update([
            "avatar"=>"/avatars/".$picture_name,
            "surname"=>$request->input("surname"),
            "telephone"=>$request->input("phone"),
        ]);
    }
}
