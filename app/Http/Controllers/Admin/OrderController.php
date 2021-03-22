<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

use DataTables;
use Validator;
class OrderController extends Controller
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
            $data = Order::select('customers.name','orders.id','orders.total_amount','orders.status')
            ->leftJoin("customers", "customers.id", "=", "orders.customer_id")
            ;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            
                           $btn = '<a href="'.route('admin.orders.show',$row->id).'" class="edit btn btn-primary btn-sm">View</a>';
                           $btn .= '<a href="'.route('admin.orders.edit',$row->id).'" class="edit btn btn-success btn-sm">Edit</a>';
                           $btn .= '<form action="'.route('admin.orders.destroy',$row->id).'" method="post" style="display:inline">
                           '.csrf_field().'<input type="hidden" name="_method" value="delete" />
                            <input class="btn btn-danger" type="submit" value="Delete">
                            </form>';

                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.orders.index');
    }
    public function create()
    {
        return view('admin.orders.create');
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
        $order = Order::create($input);

        return redirect()->route('admin.orders.index')
                        ->with('success','Order created successfully');
    }
    public function show($id)
    {
        $order = Order::select('customers.name','orders.*')
        ->leftJoin("customers", "customers.id", "=", "orders.customer_id")->find($id);
        $item = OrderItem::select('products.name as product_name','products.price','products.is_stock','order_items.*')
        ->leftJoin("products", "products.id", "=", "order_items.product_id")
        ->where('order_id',$id)->get();
        return view('admin.orders.show',compact('order','item'));
    }
    public function edit($id)
    {
        $order = Order::find($id);
        return view('admin.orders.edit',compact('order'));
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

        $user = Order::find($id);
        $user->update($input);
        return redirect()->route('admin.orders.index')
                        ->with('success','Order updated successfully');
    }
  	public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect()->route('admin.orders.index')
                        ->with('success','Order deleted successfully');
    }
}
