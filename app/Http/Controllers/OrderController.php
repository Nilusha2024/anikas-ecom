<?php
namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Notifications\SendOrderStatus;
use App\User;
use App\Address;
use App\Invoice;
use App\InvoiceDownload;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\CanceledOrders;
use App\FullOrderCancelLog;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use View;
use DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');

        $all_orders = Order::with(['user' => function($q){
            return $q->select('id','name');
        }])->whereHas('user')->where('orders.status','=',1);

        $inv_cus = Invoice::first();

        if($request->ajax()){
            return DataTables::of($all_orders)
                        ->editColumn('checkbox', function ($row) {

                            $chk = "<div class='inline'>
                                <input type='checkbox' form='bulk_delete_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                                <label for='checkbox$row->id' class='material-checkbox'></label>
                                </div>";

                            return $chk;
                        })
                        ->addIndexColumn()
                        ->addColumn('order_type',function($row){
                            if($row->payment_method != 'COD' && $row->payment_method != 'BankTransfer'){
                                return '<label class="label label-success">PREPAID</label>';
                            }elseif ($row->payment_method == 'BankTransfer') {
                                return '<label class="label label-info">PREPAID</label>';
                            }else{
                                return '<label class="label label-primary">COD</label>';
                            }
                        })
                        ->addColumn('order_id',function($row) {

                            $html = '#<b>'.$row->order_id.'</b>';
                            $html .= "<p></p>";
                            $html .= '<small><a title="View Order" href="'.route('show.order',$row->order_id).'">View Order</a></small> | <small><a title="Edit Order" href="'.route('admin.order.edit',$row->order_id).'">Edit Order</a></small>';

                            return $html;

                        })
                        ->addColumn('customer_dtl',function($row){
                            return $row->user->name;
                        })
                        ->addColumn('total_qty',function($row){
                            return $row->qty_total;
                        })
                        ->editColumn('total_amount',function($row){
                            return '<b>'.$row->paid_in_currency.' '.($row->order_total + $row->handlingcharge).'</b>';
                        })
                        ->addColumn('order_date',function($row){
                            return date('d-m-Y @ h:i A',strtotime($row->created_at));
                        })
                        ->editColumn('action','admin.order.dbTableColumn.action')
                        ->rawColumns(['checkbox','order_type','order_id','customer_dtl','total_amount','order_date','action'])
                        ->make(true);
        }

        return view("admin.order.index", compact("all_orders", 'inv_cus'));
    }

    public function bulkdelete(Request $request)
    {
        abort_if(!auth()->user()->can('order.delete'),403,'User does not have the right permissions.');


        $validator = Validator::make($request->all() , ['checked' => 'required', ]);

        if ($validator->fails())
        {

            return back()->with('warning', 'Please select one of them to delete');
        }

        $orders = Order::whereIn('id',$request->checked)->with('invoices')->get();

        $orders->each(function($item){

            $item->invoices()->delete();

            $item->delete();

        });

        notify()->success('Selected Orders Deleted Successfully !','Success');

        return redirect()
            ->route('order.index');

    }

    public function viewUserOrder($orderid)
    {

       
        require_once ('price.php');
        
         $order = Order::where('order_id', $orderid)->with(['shippingaddress','invoices','invoices.simple_product'])->whereHas('invoices')->with('invoices.variant')->whereHas('invoices.variant')->with('invoices.variant.variantimages')->with('invoices.variant.products')->whereHas('invoices.variant.products',function($query){
            return $query->where('status','1');
        })->orWhereHas('invoices.simple_product')->with('user')->whereHas('user')->with('cancellog')->with('fullordercancellog')
        ->with('invoices.refundlog')->orderBy('id', 'desc')->where('user_id', auth()->user()->id)->where('status','1')->first();

        if (!isset($order))
        {
            notify()->error('Order not found or has been deleted !');
            return redirect('/');
        }

        $inv_cus = Invoice::first();
        $address = $order->shippingaddress;

        if (Auth::check())
        {

            
            $user = Auth::user();
            return view('user.viewfullorder', compact('conversion_rate', 'order', 'user', 'address', 'inv_cus'));
            

        }
        else
        {
            notify()->error('Unauthorized','401');
            return redirect('/');
        }

    }

    public function getUserInvoice($invid)
    {
        
        $inv_cus = Invoice::first();
        $getInvoice = InvoiceDownload::findOrFail($invid);
        $address = Address::findOrFail($getInvoice->order->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)->first();

        if (Auth::check())
        {

            if(Auth::user()->role_id == "a" || Auth::user()->id == $getInvoice->order->user_id)
            {
                if ($getInvoice->status == 'delivered' || $getInvoice->status == 'return_request')
                {
                    $user = Auth::user();
                    return view('user.userinvoice', compact('invSetting', 'getInvoice', 'inv_cus', 'address'));
                }
                else
                {
                    notify()->error('Invoice not available yet !');
                    return back();
                }
            }
            else
            {
                return abort(404);
            }

        }
        else
        {
            return abort(404);
        }

    }

    public function getCancelOrders()
    {
        abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');

        $inv_cus = Invoice::first();
        
        $cOrders = CanceledOrders::with(['singleOrder.order','singleOrder.order.user','singleOrder','singleOrder.variant','singleOrder.variant.products','singleOrder.variant.variantimages'])->whereHas('singleOrder.order')->whereHas('singleOrder.variant.products')->whereHas('singleOrder.order.user')->whereHas('singleOrder.variant')->whereHas('singleOrder')->latest()->get();

        $comOrder = FullOrderCancelLog::with(['getorderinfo','user','getorderinfo.invoices','getorderinfo.invoices.variant'])->whereHas('getorderinfo.invoices.variant')->whereHas('user')->whereHas('getorderinfo')->latest()->get();

        $partialcount = CanceledOrders::where('read_at', '=', NULL)->count();
        $fullcount = FullOrderCancelLog::where('read_at', '=', NULL)->count();
        return view('admin.order.canorderindex', compact('cOrders', 'comOrder', 'inv_cus', 'partialcount', 'fullcount'));
    }

    public function pendingorder(){

        abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');


        $inv_cus = Invoice::first();

        $pendingorders = Order::join('invoice_downloads','orders.id','=','invoice_downloads.order_id')->join('users','users.id','=','orders.user_id')->where('invoice_downloads.status','=','pending')->where('orders.status','=','1')->select('orders.id as id','orders.order_id as orderid','orders.paid_in as paid_in','order_total as total','users.name as customername','users.id as userid','orders.payment_method as payment_method','orders.created_at as orderdate','orders.handlingcharge as handlingcharge')->latest('orders.id')->get();

        $orders = $pendingorders->unique('id');

        return view('admin.order.pendingorder',compact('orders','inv_cus'));

    }

    public function QuickOrderDetails(Request $request){

            abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');

           

            $order = Order::where('id',$request->orderid)->whereHas('invoices.variant')->whereHas('invoices.variant.products')->whereHas('invoices')->orWhereHas('invoices.simple_product')->whereHas('user')->first();

            $inv_cus = Invoice::first();

            if(isset($order)){

                return response()->json(['orderview' => View::make('admin.order.quickorder',compact('order','inv_cus'))->render()]);

            }else{
                return response()->json(['code' => 404, 'msg' => 'No Orders Found !']);
            }

    }

    

    public function show($id)
    {
        abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');

        $order = Order::where('order_id', $id)->whereHas('invoices')->whereHas('user')->where('status','=','1')->first();

        $inv_cus = Invoice::first();

        return view('admin.order.show', compact('order', 'inv_cus'));
    }

    public function editOrder($orderid)
    {

        abort_if(!auth()->user()->can('order.edit'),403,'User does not have the right permissions.');

        $order = Order::where('order_id', $orderid)->whereHas('invoices')->whereHas('user')->where('status','=','1')->first();

        $inv_cus = Invoice::first();

        return view('admin.order.edit', compact('order', 'inv_cus'));
    }

    public function printOrder($id)
    {
        abort_if(!auth()->user()->can('order.view'),403,'User does not have the right permissions.');

        $order =  Order::find($id);

        $inv_cus = Invoice::first();

        return view('admin.order.printorder', compact('inv_cus', 'order'));
    }

    public function printInvoice($orderID, $id)
    {
        $getInvoice = InvoiceDownload::where('id', $id)->first();
        $inv_cus = Invoice::first();
        $address = Address::findOrFail($getInvoice
            ->order
            ->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)
            ->first();



        return view('admin.order.printinvoices', compact('invSetting', 'address', 'getInvoice', 'inv_cus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $data = Order::create($input);
        $data->save();
        return back()
            ->with('updated', 'Order has been updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('order.edit'),403,'User does not have the right permissions.');

        $order = Order::findOrFail($id);
        $order_status = order::all();
        return view("admin.order.edit", compact("order", "order_status"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('order.edit'),403,'User does not have the right permissions.');

        $order = Order::findOrFail($id);
        $input = $request->all();
        $order->update($input);

        $sub = new Order;
        $obj = $sub->find($id);
        $obj->updated_at = date("Y-m-d h:i:s");
        $value = $obj->save();

        if ($request->order_status == "pending")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        if ($request->order_status == "processed")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        if ($request->order_status == "dispatched")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        if ($request->order_status == "shipped")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        if ($request->order_status == "delivered")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        if ($request->order_status == "cancelled")
        {

            /*Sending to user*/
            User::find($order->user_id)
                ->notify(new SendOrderStatus($order));
            /*END*/
        }

        return redirect('admin/order')->with('updated', 'Order Status has been updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        abort_if(!auth()->user()->can('order.delete'),403,'User does not have the right permissions.');

        $order = Order::findorFail($id);

        $order->status = 0;

        $order->save();

        session()
            ->flash("deleted", "Order Has Been deleted");
        return redirect("admin/order");

    }

    public function pending()
    {
        $orders = Order::where('order_status', 'pending')->get();
        return view("admin.order.index", compact("orders"));
    }

    public function deliverd()
    {
        $orders = Order::where('order_status', 'delivered')->get();
        return view("admin.order.index", compact("orders"));
    }

    public function downloadDigitalProduct(Request $request,$id){

        abort_if(!auth()->check(),403,'Download permission denied !');

        $order = InvoiceDownload::findorfail($id);

        if($order->status != 'delivered'){
            notify()->error("Download permission denied !");
            return back();
        }

        $product = $order->simple_product;
        $filename = $product->product_file;

        if (env('DEMO_LOCK') == 1) {
            notify()->error("This action is disabled in demo !");
            return back();
        }

        if (!$request->hasValidSignature()) {
            notify()->error('Download Link is invalid or expired !');
            return back();
        }

        $filePath = storage_path() . '/digitalproducts/files/' . $filename;

        $fileContent = @file_get_contents($filePath);

        if(!$fileContent){
            notify()->error("File not found contact your seller with order id !");
            return back();
        }

        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);

        return $response;


    }

}

