<?php

namespace App\Http\Controllers;

use App\Models\YogaClass;
use App\Models\YogaCourse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YogaAPIController extends Controller
{
    //

    // upload data
    public function uploadData(Request $request)
    {
        Log::info($request->all());
        try{
            // $request->validate([
            //     'courses' => 'required|array',
            //     'courses.*.day_of_week' => 'required|string',
            //     'courses.*.time_of_course' => 'required|string',
            //     'courses.*.capacity' => 'required|integer|min:1',
            //     'courses.*.duration' => 'required|integer|min:1',
            //     'courses.*.price_per_class' => 'required|numeric|min:0',
            //     'courses.*.type_of_class' => 'required|string',
            //     'courses.*.description' => 'nullable|string',
            //     'courses.*.location' => 'nullable|string',
            //     'classes' => 'required|array',
            //     'classes.*.yoga_course_id' => 'required|exists:courses,id',
            //     'classes.*.date' => 'required|date',
            //     'classes.*.teacher' => 'required|string',
            //     'classes.*.additional_comments' => 'nullable|string',
            // ]);

            collect($request->input('courses'))->map(function ($course) {
                return YogaCourse::create($course);
            });

            collect($request->input('classes'))->map(function ($class) {
                return YogaClass::create($class);
            });

            return response()->json([
                'message' => 'Data uploaded successfully',
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occurred',
            ], 500);
        }
    }


    // get all courses
    public function getCourses()
    {
        try{
            return response()->json([
                'message' => 'Courses retrieved successfully',
                'dto' => YogaCourse::all(),
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occurred in getCourses',
            ], 500);
        }
    }


    // get all classes
    public function getClasses()
    {
        try{
            return response()->json([
                'message' => 'Classes retrieved successfully',
                'dto' => YogaClass::with('course')->get(),
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occurred in getClasses',
            ], 500);
        }
    }


    // booking class
    
}
