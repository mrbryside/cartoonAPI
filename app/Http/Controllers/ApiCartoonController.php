<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Cartoon;
use App\CartoonList;
use App\User;
use App\UsersFollow;

class ApiCartoonController extends Controller
{
    public function cartoonNewChapter(){
       
        $res = [];
        $cartoonLists = CartoonList::where('created_at', '>=', Carbon::now()->subDays(15)->toDateTimeString())
                                    ->orderBy('created_at')->get();

        foreach($cartoonLists as $cartoonList){
            $cartoon = Cartoon::where('cartoonID',$cartoonList->cartoonID)->first();
            array_push($res,[
                'cartoonID'=>$cartoon->cartoonID,
                'chapterID'=>$cartoonList->chapterID,
                'cartoonName'=>$cartoon->cartoonName,
                'image_url'=>env('APP_URL','').'/'.$cartoon->cartoonName.'/'.$cartoonList->chapterID.'/1.jpg',
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $res
        ]); 
        
    }
    public function cartoonFollow(Request $request){
        $validator = Validator::make($request->all(),[
            'userID'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $res = [];
        $cartoons = Cartoon::orderBy('created_at')->get();

        foreach($cartoons as $cartoon){
            $cartoonLists = CartoonList::where('cartoonID',$cartoon->cartoonID)
                                        ->where('created_at', '>=', Carbon::now()->subDays(7)->toDateTimeString())
                                        ->orderBy('created_at')
                                        ->get();

            $cartoonList = CartoonList::where('cartoonID',$cartoon->cartoonID)->first();

            $cartoonStatus="Update";
            if(count($cartoonLists) == 0){
                $cartoonStatus="notUpdate";
            }
            $userFollow = UsersFollow::where('userID',$request->input('userID'))->where('cartoonID',$cartoon->cartoonID)->first();
            if($userFollow != null){
                array_push($res,[
                    'cartoonID'=>$cartoon->cartoonID,
                    'cartoonName'=>$cartoon->cartoonName,
                    'cartoonStatus'=>$cartoonStatus,
                    'image_url'=>env('APP_URL','').'/'.$cartoon->cartoonName.'/'.$cartoonList->chapterID.'/1.jpg',
                ]);
            }
            
        }
        return response()->json([
            'success' => true,
            'data' => $res
        ]); 
        
    }
    public function cartoonList(Request $request){
        $validator = Validator::make($request->all(),[
            'userID'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $res = [];
        $cartoons = Cartoon::get();

        foreach($cartoons as $cartoon){
            $cartoonLists = CartoonList::where('cartoonID',$cartoon->cartoonID)
                                        ->where('created_at', '>=', Carbon::now()->subDays(7)->toDateTimeString())
                                        ->orderBy('created_at')
                                        ->get();

            $cartoonList = CartoonList::where('cartoonID',$cartoon->cartoonID)->first();

            $cartoonStatus="Update";
            if(count($cartoonLists) == 0){
                $cartoonStatus="notUpdate";
            }
            $userFollow = UsersFollow::where('userID',$request->input('userID'))->where('cartoonID',$cartoon->cartoonID)->first();
            $userFollowStatus = 'Follow';
            if($userFollow == null){
                $userFollowStatus = 'notFollow';
            }
            array_push($res,[
                'cartoonID'=>$cartoon->cartoonID,
                'cartoonName'=>$cartoon->cartoonName,
                'userFollow'=>$userFollowStatus,
                'cartoonStatus'=>$cartoonStatus,
                'image_url'=>env('APP_URL','').'/'.$cartoon->cartoonName.'/'.$cartoonList->chapterID.'/1.jpg',
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $res
        ]); 
        
    }
    public function cartoonChapter($cartoonID){
        $res = [];
        $cartoonLists = CartoonList::where('cartoonID',$cartoonID)->orderBy('created_at')->get();
        $cartoon = Cartoon::where('cartoonID',$cartoonID)->first();
        foreach($cartoonLists as $cartoonList){
            array_push($res,[
                'cartoonID'=>$cartoon->cartoonID,
                'chapterID'=>$cartoonList->chapterID,
                'cartoonName'=>$cartoon->cartoonName,
                'created_at'=>$cartoonList->created_at,
                'image_url'=>env('APP_URL','').'/'.$cartoon->cartoonName.'/'.$cartoonList->chapterID.'/1.jpg',
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $res
        ]); 
        
    }
    public function cartoonShow($cartoonID,$chapterID){
        $res = [];
        $cartoonList = CartoonList::where('cartoonID',$cartoonID)
                                    ->where('chapterID',$chapterID)->first();

        $cartoon = Cartoon::where('cartoonID',$cartoonID)->first();


        for($i=1;$i<=$cartoonList->cartoonPage;$i++){
            array_push($res,[
                'page'=>$i,
                'image_url'=>env('APP_URL','').'/'.$cartoon->cartoonName.'/'.$cartoonList->chapterID.'/'.$i.'.jpg',
            ]);
        }
        
 
        return response()->json([
            'success' => true,
            'cartoonName' => $cartoon->cartoonName,
            'chapterID' => $cartoonList->chapterID,
            'data_images' => $res
        ]); 
        
    }
    
}
