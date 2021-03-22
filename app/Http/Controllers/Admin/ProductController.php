<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use Validator;
class ProductController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            
                           $btn = '<a href="'.route('admin.products.show',$row->id).'" class="edit btn btn-primary btn-sm">View</a>';
                           $btn .= '<a href="'.route('admin.products.edit',$row->id).'" class="edit btn btn-success btn-sm">Edit</a>';
                           $btn .= '<form action="'.route('admin.products.destroy',$row->id).'" method="post" style="display:inline">
                           '.csrf_field().'<input type="hidden" name="_method" value="delete" />
                            <input class="btn btn-danger" type="submit" value="Delete">
                            </form>';

                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.products.index');
    }
    public function create()
    {
        return view('admin.products.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required',
            'price' => 'required',
            'is_stock' => 'required',
		]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());

			return redirect()->back()->with('error',$errorMessage);
		}


        $input = $request->all();
        $product = Product::create($input);

        return redirect()->route('admin.products.index')
                        ->with('success','Product created successfully');
    }
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.show',compact('product'));
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.edit',compact('product'));
    }
 	public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required',
            'price' => 'required',
            'is_stock' => 'required',
		]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
			return redirect()->back()->with('error',$errorMessage);
		}

        $input = $request->all();

        $user = Product::find($id);
        $user->update($input);
        return redirect()->route('admin.products.index')
                        ->with('success','Product updated successfully');
    }
  	public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('admin.products.index')
                        ->with('success','Product deleted successfully');
    }
}
