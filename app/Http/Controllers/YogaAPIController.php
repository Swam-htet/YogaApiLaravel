<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
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
    // eg. endpoint - http://127.0.0.1:8000/api/classes?day_of_week=Tuesday&time_of_course=00:25&date_of_class=02/24/2000
    public function getClasses(Request $request)
    {
        // get filter params from request
        $day_of_week = $request->input('day_of_week');
        // $time_of_course = $request->input('time_of_course');
        // $date_of_class = $request->input('date_of_class');
        $ids = $request->input('ids');
        Log::info("day_of_week: " . $day_of_week);
        // get courses by day_of_week
        $courses = YogaCourse::query();
        if($day_of_week){
            $courses->where('day_of_week', $day_of_week);
        }


        $courses = $courses->get();

        // get classes by courses
        $classes = YogaClass::query();

        // filter classes by courses
        if($courses->count() > 0){
            $classes->whereIn('yoga_course_id', $courses->pluck('id'));
        }

        // filter classes by ids
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
                    // 'time_of_course' => $time_of_course,
                    // 'date_of_class' => $date_of_class,
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

    // get all courses
    public function getCourses()
    {
        try{
            $courses = YogaCourse::all();
            return response()->json([
                'message' => 'Courses retrieved successfully',
                'dto' => $courses,
            ]);
        }
        catch(Exception $e){
            Log::error("Get courses error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in getCourses',
            ], 500);
        }
    }

    // create course
    public function createCourse(Request $request)
    {
        // request's day_of_week, time_of_course, capacity, duration, price_per_class, type_of_class, description, location
        try{
            $course = YogaCourse::create($request->all());
            return response()->json([
                'message' => 'Course created successfully',
                'dto' => $course,
            ], 201);
        }
        catch(Exception $e){
            Log::error("Create course error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in createCourse',
            ], 500);
        }
    }

    // update course
    public function updateCourse(Request $request, int $id)
    {
        try{
            $course = YogaCourse::find($id);
            if(!$course){
                return response()->json([
                    'message' => 'Course not found',
                ], 404);
            }
            $course->update($request->all());
            return response()->json([
                'message' => 'Course updated successfully',
                'dto' => $course,
            ]);
        }
        catch(Exception $e){
            Log::error("Update course error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in updateCourse',
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

    // create class
    public function createClass(Request $request)
    {
        // request's yoga_course_id, date, teacher, additional_comments
        try{
            $class = YogaClass::create($request->all());
            return response()->json([
                'message' => 'Class created successfully',
                'dto' => $class,
            ], 201);
        }
        catch(Exception $e){
            Log::error("Create class error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in createClass',
            ], 500);
        }
    }

    // update class
    public function updateClass(Request $request, int $id)
    {
        try{
            $class = YogaClass::find($id);
            if(!$class){
                return response()->json([
                    'message' => 'Class not found',
                ], 404);
            }
            // request's yoga_course_id, date, teacher, additional_comments
            $class->update($request->all());
            return response()->json([
                'message' => 'Class updated successfully',
                'dto' => $class,
            ]);
        }
        catch(Exception $e){
            Log::error("Update class error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in updateClass',
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

    // get all bookings
    public function getBookings(Request $request)
    {
        // filter by - name, email, phone
        try{

            // freeWord search
            $freeWord = $request->input('freeWord');

            $bookings = YogaClassBooking::query();

            if($freeWord){
                $bookings->where('name', 'like', "%$freeWord%")
                    ->orWhere('email', 'like', "%$freeWord%")
                    ->orWhere('phone', 'like', "%$freeWord%");
            }

            $bookings = $bookings->get();

            return response()->json([
                'message' => 'Bookings retrieved successfully',
                'dto' => BookingResource::collection($bookings),
                'filterParams' => [
                    'freeWord' => $freeWord,
                ]
            ]);
        }
        catch(Exception $e){
            Log::error("Get bookings error: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred in getBookings',
            ], 500);
        }
    }

}
