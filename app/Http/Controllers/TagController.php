<?php

namespace App\Http\Controllers;

use App\Review;
use App\Show;
use App\Tag;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Object_;
use PhpMyAdmin\Console;
use stdClass;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {

        $tags_name = DB::table('tags')
            ->join('shows', 'tags.show_id', '=', 'shows.id')
            ->select('tags.tag_name')
            ->get();

        $tags_name_show_ids = DB::table('tags')
            ->join('shows', 'tags.show_id', '=', 'shows.id')
            ->select('tags.tag_name', 'tags.show_id')
            ->get();

    
       foreach ($tags_name as $tag_name) {
           $tag_name_array[] =  $tag_name->tag_name;
       }

       $tag_name_array_unique = array_unique($tag_name_array);

        
       // return response()->json(['tags_name' => $tag_name_array_unique, 'show_ids' => $show_id_array_unique]);
    return response()->json(['tags_name' => $tag_name_array_unique, 'tags_name_show_ids' => $tags_name_show_ids]);

    }

    public function tagsSearch (Request  $request)
    {
        if ($request!=null) {

                    foreach ($request->tags_search as $tag_name) {

                        $result = DB::table('tags')
                                ->where('tags.tag_name', '=', $tag_name)
                                ->select('tags.show_id')
                                ->get();

                        $show_ids[] = $result;

                    }

                    foreach ($show_ids as $show_id) {
                        for ($i=0; $i<count($show_id); $i++) {

                            $array_final[] = $show_id[$i]->show_id;
   
                        }
                    }

                   

                    return array_unique($array_final);

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
