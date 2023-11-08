<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        $categoryNames = [];

        foreach ($categories as $category) {
            if (!$category->is_parent && $category->parent_id) {
                // If it's not a parent and has a parent_id
                $parentCategory = Category::find($category->parent_id);
                if ($parentCategory) {
                    $categoryNames[$category->id] = $parentCategory->title;
                } else {
                    $categoryNames[$category->id] = 'No Parent';
                }
            } else {
                $categoryNames[$category->id] = 'No Parent';
            }
        }


        return view('dashboard.category.index',compact('categories','categoryNames'));
    }


    public function create()
    {
        $categories = Category::where('is_parent',true)->get();
        return view('dashboard.category.create',compact('categories'));

    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
//            'summary'=>'string|nullable',
//            'photo'=>'required',
            'is_parent'=>'sometimes|in:0,1',
            'parent_id'=>'exists:categories,id',
            'status'=>'nullable|in:active,inactive',
        ]);

        $data = $request->all();
        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug',$slug)->count();
        if ($slug_count>0)
        {
            $slug .= time().'-'.$slug;
        }
        $data['slug']=$slug;

        $data['is_parent'] = $request->input('is_parent',0);

        if(!$data['is_parent']){
            $data['parent_id'] = $request->input('parent_id');
        }


        $category = Category::create($data);
        if ($category){
            return redirect()->route('category.index')->with('success','Category added successfuly');
        }
        return redirect()->back()->with('error','there is error');
    }


    public function show(string $id)
    {
        //
    }


    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        return view('dashboard.category.edit', compact('category','categories'));
    }

    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'is_parent' => 'sometimes|in:0,1',
            'parent_id' => 'exists:categories,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        $category = Category::where('slug', $slug)->firstOrFail(); // Find the category by its slug

        $data = $request->all();

        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug', $slug)->where('id', '!=', $category->id)->count();

        if ($slug_count > 0) {
            $slug .= time() . '-' . $slug;
        }
        $data['slug'] = $slug;

        $data['is_parent'] = $request->input('is_parent', 0);

        if (!$data['is_parent']) {
            $data['parent_id'] = $request->input('parent_id');
        } else {
            $data['parent_id'] = null; // Set parent_id to null if it's a parent category
        }

        $category->update($data); // Update the attributes of the category

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }


    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_parent', true)
            ->first(); // Use `first` to retrieve the record that matches the condition

        if (!$category) {
            return response()->json(['message' => 'Category Not Found or Not a Parent'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function categoryStatus(Request $request){
        if ($request->mode=='true')
        {

            DB::table('categories')->where('id',$request->id)->update(['status'=>'active']);
        }
        else
        {
            DB::table('categories')->where('id',$request->id)->update(['status'=>'inactive']);
        }
        return response()->json(['msg'=>'Successfuly updated','status'=>true]);
    }

}
