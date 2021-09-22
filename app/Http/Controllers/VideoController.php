<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use App\Models\Likes;
use Illuminate\Http\Request;
 
use Validator;

class VideoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'file' => 'required',
            ]);

            $video=Videos::create(array_merge(
                $validator->validated(),
                [
                    'created_by' => auth()->user()->id
                ]
            ));
            return response()->json(['result' => true, 'video' => $video]);
        } catch (\Throwable $th) {
            return response()->json(['result' => false, 'msg' => $th]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Videos  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // find video
            $video=Videos::find($id);
            if(!$video){
                return response()->json(['result' => false, 'msg' => "Don't find"]);
            }
            return response()->json(['result' => true, 'video' => $video]);
        } catch (\Throwable $th) {
            return response()->json(['result' => false, 'msg' => $th]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Videos  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'file' => 'required',
            ]);

            // check video exist.
            $video = Videos::find($id);
            if(!$video){
                return response()->json(['result' => false, 'msg' => "Can't find video"]);
            }

            //update
            $video->update(array_merge(
                $validator->validated(),
                [
                    'created_by' => auth()->user()->id
                ]
            ));
            return response()->json(['result' => true, 'video' => $video]);
        } catch (\Throwable $th) {
            return response()->json(['result' => false, 'msg' => $th]);
        }
    }

    public function like($id){
        // check video exist
        $video=Videos::find($id);
        if(!$video){
            return response()->json(['result' => false, 'msg' => "Can't find video"]);
        }

        // check like status
        $check_like=Likes::where('video_id', $id)->first();
        if($check_like){
            return response()->json(['result' => false, 'msg' => "This video already like one."]);
        }

        $like = Likes::create([
            'video_id' => $id,
            'created_by' => auth()->user()->id,
        ]);
        return response()->json(['result' => true]);
    }

    public function unlike($id){
        $like = Likes::where('video_id', $id)->first();
        if(!$like){
            return response()->json(['result' => false, 'msg' => "This video isn't like one."]);
        }
        $like->delete();
        return response()->json(['result' => true]);
    }
}
