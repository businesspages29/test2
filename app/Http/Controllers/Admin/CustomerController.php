<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use DataTables;
use Validator;

class CustomerController extends Controller
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
            $data = Customer::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            
                           $btn = '<a href="'.route('admin.customers.show',$row->id).'" class="edit btn btn-primary btn-sm">View</a>';
                           $btn .= '<a href="'.route('admin.customers.edit',$row->id).'" class="edit btn btn-success btn-sm">Edit</a>';
                           $btn .= '<form action="'.route('admin.customers.destroy',$row->id).'" method="post" style="display:inline">
                           '.csrf_field().'<input type="hidden" name="_method" value="delete" />
                            <input class="btn btn-danger" type="submit" value="Delete">
                            </form>';

                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.customers.index');
    }
    public function create()
    {
        return view('admin.customers.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required',
            'email' => 'required|email|unique:customers,email',
		]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());

			return redirect()->back()->with('error',$errorMessage);
		}


        $input = $request->all();
        $customer = Customer::create($input);

        return redirect()->route('admin.customers.index')
                        ->with('success','Customer created successfully');
    }
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.show',compact('customer'));
    }
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.edit',compact('customer'));
    }
 	public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required',
            'email' => 'required',
		]);

        if ($validator->fails()) {
            $errorMessage = implode(',', $validator->errors()->all());
			return redirect()->back()->with('error',$errorMessage);
		}

        $input = $request->all();

        $user = Customer::find($id);
        $user->update($input);
        return redirect()->route('admin.customers.index')
                        ->with('success','Customers updated successfully');
    }
  	public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('admin.customers.index')
                        ->with('success','Customer deleted successfully');
    }
}
