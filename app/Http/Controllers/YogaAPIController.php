<?php

namespace App\Http\Controllers;
;
use App\Http\Resources\YogaClassResource;
use App\Http\Resources\YogaClassDetailResource;
use App\Models\YogaClass;
use App\Models\YogaCourse;
use App\Models\YogaClassBooking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YogaAPIController extends Controller
{
    // upload data
    public function uploadData(Request $request)
    {
        try{
            Log::info("uploadData - ", $request->all());
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
            Log::error("Upload data error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred',
            ], 500);
        }
    }

    // reset db
    public function resetDB()
    {
        try{
            YogaClassBooking::query()->delete();
            YogaClass::query()->delete();
            YogaCourse::query()->delete();

            return response()->json([
                'message' => 'Database reset successfully',
            ]);
        }
        catch(Exception $e){
            Log::error("Reset db error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in resetDB',
            ], 500);
        }
    }

    // get all classes
    public function getClasses(Request $request)
    {
        $day_of_week = $request->input('day_of_week');
        $ids = $request->input('ids');

        $courses = YogaCourse::query();
        if($day_of_week){
            $courses->where('day_of_week', $day_of_week);
        }

        $courses = $courses->get();

        if($courses->count() == 0){
            return response()->json([
                'message' => 'No classes found',
                'dto' => [],
                'filterParams' =>   [
                    'day_of_week' => $day_of_week,
                    'ids' => $ids,
                ]
            ], 404);
        }

        $classes = YogaClass::query();

        if($courses->count() > 0){
            $classes->whereIn('yoga_course_id', $courses->pluck('id'));
        }
        if($ids){
            $classes->whereIn('id', explode(',', $ids));
        }

        $classes = $classes->with('course')->get();

        try{
            return response()->json([
                'message' => 'Classes retrieved successfully',
                'dto' => YogaClassResource::collection($classes),
                'filterParams' =>   [
                    'day_of_week' => $day_of_week,
                    'ids' => $ids,
                ]
            ]);
        }
        catch(Exception $e){
            Log::error("Get classes error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in getClasses',
            ], 500);
        }
    }

    // get class by id
    public function getClassById(int $id)
    {
        try{
            $class = YogaClass::with('course')->find($id);
            if(!$class){
                return response()->json([
                    'message' => 'Class not found',
                ], 404);
            }
            return response()->json([
                'message' => 'Class retrieved successfully',
                'dto' => new YogaClassDetailResource($class),
            ]);
        }
        catch(Exception $e){
            Log::error("Get class by id error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in getClassById',
            ], 500);
        }
    }

    // booking class
    public function bookClass(Request $request)
    {
        try{
            $booking = collect(explode(',', $request->input('class_ids')))->map(function($class_id) use ($request) {
                return YogaClassBooking::create([
                    'yoga_class_id' => $class_id,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                ]);
            });


            return response()->json([
                'message' => 'Class booked successfully',
                'dto' => $booking,
            ], 201);
        }
        catch(Exception $e){
            Log::error("Book class error: " . $e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // delete course
    public function deleteCourse(int $id)
    {
        try{
            $course = YogaCourse::find($id);
            if(!$course){
                return response()->json([
                    'message' => 'Course not found',
                ], 404);
            }
            $course->delete();
            return response()->json([
                'message' => 'Course deleted successfully',
            ]);
        }
        catch(Exception $e){
            Log::error("Delete course error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in deleteCourse',
            ], 500);
        }
    }

    // delete class
    public function deleteClass(int $id)
    {
        try{
            $class = YogaClass::find($id);
            if(!$class){
                return response()->json([
                    'message' => 'Class not found',
                ], 404);
            }
            $class->delete();
            return response()->json([
                'message' => 'Class deleted successfully',
            ]);
        }
        catch(Exception $e){
            Log::error("Delete class error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in deleteClass',
            ], 500);
        }
    }

    // get classes by booking information - email
    public function getClassesByBookingInfo(Request $request)
    {
        try{
            Log::info("getClassesByBookingInfo - ", $request->all());
            // freeWord search
            $freeWord = $request->input('freeWord');
            $email = $request->input('email');

            $bookings = YogaClassBooking::query();

            if($freeWord){
                $bookings->where('name', 'like', "%$freeWord%")
                    ->orWhere('email', 'like', "%$freeWord%")
                    ->orWhere('phone', 'like', "%$freeWord%");
            }

            $bookings = $bookings->get();

            $classes = YogaClass::query();

            if($bookings->count() > 0){
                $classes->whereIn('id', $bookings->pluck('yoga_class_id'));
            }

            $classes = $classes->with('course')->get();

            return response()->json([
                'message' => 'Classes retrieved successfully',
                'dto' => YogaClassResource::collection($classes),
                'filterParams' => [
                    'freeWord' => $freeWord,
                ]
            ]);
        }
        catch(Exception $e){
            Log::error("Get classes by booking info error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in getClassesByBookingInfo',
            ], 500);
        }
    }

}
