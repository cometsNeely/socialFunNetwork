<?php

namespace App\Http\Controllers;

use App\Show;
use Composer\IO\ConsoleIO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ShowController extends Controller
{
    public function getData() {

        $data = Show::all();
        return $data;
    }

    public function avg_Rate($title) {
    
    
        $avg_rate = DB::table('shows')
            ->where('title', $title)
            ->avg('rate');

        return $avg_rate;
    }

    public function postData (Request  $request)
    {

        $show = new Show;
        $show->user_id = $request->user_id;
        $show->title = $request->title;
        $show->description = $request->description;
        $show->rate = $request->rate;
        $show->href = $request->href;
        $show->cover_src = $request->cover_src;
        $show->status = $request->status;
        $show->avg_rate = 0;   
        $show->rateChecked = 0;       
        $show->save();

        $avg_rate = $this->avg_Rate($request->title); 

        //$request->avg_rate = $avg_rate;

        DB::table('shows')->where('id', $request->id)->update(array('avg_rate' => $avg_rate, 'rateChecked' => $request->rateChecked));
        
        return response()->json(['avg_rate' => $avg_rate]);
    }

    public function changeRateChecked(Request $request) {
                for ($i=0; $i<count($request->id); $i++) {
             DB::table('shows')->where('id', $request->id[$i])->update(array('rateChecked' => $request->changeRateChecked));
         }
    }
}


