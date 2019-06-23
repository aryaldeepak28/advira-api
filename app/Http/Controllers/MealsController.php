<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Meal;
use App\Models\MealComment;
use App\Models\MealLike;
use App\Models\Restaurant;
use Carbon\Carbon;

class MealsController extends Controller
{
    public function index(Request $request){
        try{
            $meals = Meal::paginate(20);
            foreach($meals as $meal){
                $meal['liked_by_me']= MealLike::where([['meal_id',$meal['id']],['user_id',$request->get('user_id')]])->count();
                $total_likes = MealLike::select('meal_id')->where('meal_id',$meal['id'])->get();
                $meal['total_likes'] = count($total_likes);
                $total_comments = MealComment::select('meal_id')->where('meal_id',$meal['id'])->get();
                $meal['total_comments']= count($total_comments);
                $meal['restaurant']=Restaurant::select("id","place_id","place_name","place_lat","place_lng")->where('id',$meal['restaurant_id'])->first();
                $meal['user']= User::select("id","username","profile_pic","profile_pic_rotation","profile_pic_url")->where('id',$request->get('user_id'))->first();
                $meal['like_count']= $total_likes;
                $meal['comments_count']= $total_comments;
            }
            return response()->json(["status"=>false,"meals"=>$meals]);
        }catch(\Exception $e){
            \Log::info($e);
            return response()->json(["status"=>false,"message"=>$e->getMessage()]);
        }
    }
    public function getScheduleAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
}
