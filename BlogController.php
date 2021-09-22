<?php
namespace App\Http\Controllers;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * BlogController
 */
class BlogController extends Controller {
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
        
    /**
     * index
     *
     * @return void
     */
    public function index() {
        try {
            $blogs = Blog::all();
            $res = array(
                'message' => 'List of blogs', 
                'data' => $blogs, 
                'status' => 1
            );
        } catch (\Throwable $e) {
            $res = array(
                'message' => $e->getMessage(), 
                'data' => array(), 
                'status' => 0
            );
        }
        return response()->json($res);
    }
    
    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
    public function create(Request $request) {

        // Manually Creating Validators
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:blogs',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $res = array(
                'message' => $validator->errors(), 
                'data' => [], 
                'status' => 0
            );
        } else {
            try {
                $blog = new Blog;
                $blog->name = $request->name;
                $blog->description = $request->description;
                $blog->save();
                $res = array(
                    'message' => 'Blog post added successfully', 
                    'data' => array($blog), 
                    'status' => 1
                );
            } catch (\Throwable $e) {
                $res = array(
                    'message' => $e->getMessage(), 
                    'data' => array(), 
                    'status' => 0
                );
            }            
        }        
        return response()->json($res);
    }
        
    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id) {
        try {
            $blog = Blog::find($id);
            $res = array(
                'message' => 'Blog post details', 
                'data' => is_null($blog) ? [] : array($blog), 
                'status' => 1
            );
        } catch (\Throwable $e) {
            $res = array(
                'message' => $e->getMessage(), 
                'data' => array(), 
                'status' => 0
            );
        }
        return response()->json($res);
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $res = array(
                'message' => $validator->errors(), 
                'data' => [], 
                'status' => 0
            );
        } else {
            try {
                $blog = Blog::find($id);
                $blog->name = $request->input('name');
                $blog->description = $request->input('description');
                $blog->save();
                $res = array(
                    'message' => 'Blog post updated successfully', 
                    'data' => array($blog), 
                    'status' => 1
                );
            } catch (\Throwable $e) {
                $res = array(
                    'message' => $e->getMessage(), 
                    'data' => array(), 
                    'status' => 0
                );
            } 
        }        
        return response()->json($res);
    }
        
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id) {
        try { 
            $blog = Blog::find($id);
            $blog->delete();
            $res = array(
                'message' => 'Blog post removed successfully', 
                'data' => [], 
                'status' => 1
            );
        } catch (\Throwable $e) {
            $res = array(
                'message' => $e->getMessage(), 
                'data' => array(), 
                'status' => 0
            );
        } 
        return response()->json($res);
    }
}
