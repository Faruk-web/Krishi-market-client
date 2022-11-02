<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessSetting;
use App\ClubPointDetail;
use App\ClubPoint;
use App\Product;
use App\Wallet;
use App\Order;
use App\Models\Pointconfig;
use App\Models\Discountconfig;
use Auth;
use Illuminate\Support\Facades\DB;
class ClubPointController extends Controller
{
    public function configure_index()
    {
        return view('club_points.config');
    }
    public function pointconfigure_index()
    {
        return view('point.config');
    }
    public function discount_index($id)
    {    $pid=$id;
        $discountconfig=Discountconfig::where('product_id',$pid)->get();
        return view('discount.config',compact('discountconfig','pid'));
    }

    public function index()
    {
        $club_points = ClubPoint::latest()->paginate(15);
        return view('club_points.index', compact('club_points'));
    }

    public function userpoint_index()
    {
        $club_points = ClubPoint::where('user_id', Auth::user()->id)->latest()->paginate(15);
        return view('club_points.frontend.index', compact('club_points'));
    }

    public function set_point()
    {
        $products = Product::latest()->paginate(15);
        return view('club_points.set_point', compact('products'));
    }
    public function discount_edit($id)
    {
         $data = Discountconfig::find($id);
        return response()->json($data);
    }
  

    public function discountadd(Request $request)
    {   
        foreach($request->start_qty  as $key =>$quentity){
        $data = new Discountconfig;
        
         $data->product_id = $request->product_id;
         $data->start_qty = $request->start_qty[$key];
         $data->end_qty = $request->end_qty[$key];
         $data->discount = $request->discount[$key];
         $data->type = $request->type[$key];
         $data->save();
        }
         flash(translate(' inserted successfully'))->success();
        return back();
       
       
      
    }
    public function discount_update(Request $request)
    {   
           $id=$request->discount_id;
          $discount=Discountconfig::find($id);
          $discount->start_qty=$request->start_qty;
          $discount->end_qty=$request->end_qty;
          $discount->discount=$request->discount;
          $discount->save();
      
         flash(translate(' updated successfully'))->success();
        return back();
       
       
      
    }
    public function discount_delete(Request $request)
    {   
           $id=$request->delete_id;
       
           Discountconfig::destroy($id);
           
         flash(translate(' Delete successfully'))->success();
        return back();
       
       
      
    }
    public function set_products_point(Request $request)
    {
        $products = Product::whereBetween('unit_price', [$request->min_price, $request->max_price])->get();
        foreach ($products as $product) {
            $product->earn_point = $request->point;
            $product->save();
        }
        flash(translate('Point has been inserted successfully for ').count($products).translate(' products'))->success();
        return redirect()->route('set_product_points');
    }

    public function set_all_products_point(Request $request)
    {
        $products = Product::all();
        foreach ($products as $product) {;
            $product->earn_point = $product->unit_price * $request->point;
            $product->save();
        }
        flash(translate('Point has been inserted successfully for ').count($products).translate(' products'))->success();
        return redirect()->route('set_product_points');
    }

    public function set_point_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        return view('club_points.product_point_edit', compact('product'));
    }

    public function update_product_point(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->earn_point = $request->point;
        $product->save();
        flash(translate('Point has been updated successfully'))->success();
        return redirect()->route('set_product_points');
    }

    public function convert_rate_store(Request $request)
    {
        $club_point_convert_rate = BusinessSetting::where('type', $request->type)->first();
        if ($club_point_convert_rate != null) {
            $club_point_convert_rate->value = $request->value;
        }
        else {
            $club_point_convert_rate = new BusinessSetting;
            $club_point_convert_rate->type = $request->type;
            $club_point_convert_rate->value = $request->value;
        }
        $club_point_convert_rate->save();
        flash(translate('Point convert rate has been updated successfully'))->success();
        return redirect()->route('club_points.configs');
    }
    public function convert_rate(Request $request)
    {
         
        $club_point_convert_rate = Pointconfig::where('point', $request->oldpoint)->first();
      
        if ($club_point_convert_rate != null) {
      
           $club_point_convert_rate->point = $request->point;
         
        }
        else {
           
            $club_point_convert_rate = new Pointconfig;
            $club_point_convert_rate->point = $request->point;
        }
         $club_point_convert_rate->save();
       
        flash(translate('Point convert rate has been updated successfully'))->success();
        return redirect()->route('points.configs');
    }
    public function convert_tk(Request $request)
    {
         
        $club_point_convert_rate = Pointconfig::where('tk', $request->oldtk)->first();
      
        if ($club_point_convert_rate != null) {
      
           $club_point_convert_rate->tk = $request->tk;
         
        }
        else {
           
            $club_point_convert_rate = new Pointconfig;
            $club_point_convert_rate->tk = $request->tk;
        }
         $club_point_convert_rate->save();
       
        flash(translate('tk convert point has been updated successfully'))->success();
        return redirect()->route('points.configs');
    }

    public function processClubPoints(Order $order)
    {
        $club_point = new ClubPoint;
        $club_point->user_id = $order->user_id;
        $club_point->points = 0;
        foreach ($order->orderDetails as $key => $orderDetail) {
            $total_pts = ($orderDetail->product->earn_point) * $orderDetail->quantity;
            $club_point->points += $total_pts;
        }
        $club_point->convert_status = 0;
        $club_point->save();
        foreach ($order->orderDetails as $key => $orderDetail) {
            $club_point_detail = new ClubPointDetail;
            $club_point_detail->club_point_id = $club_point->id;
            $club_point_detail->product_id = $orderDetail->product_id;
            $club_point_detail->point = $total_pts;
            $club_point_detail->save();
        }
    }

    public function club_point_detail($id)
    {
        $club_point_details = ClubPointDetail::where('club_point_id', decrypt($id))->paginate(12);
        return view('club_points.club_point_details', compact('club_point_details'));
    }

    public function convert_point_into_wallet(Request $request)
    {
        $club_point_convert_rate = BusinessSetting::where('type', 'club_point_convert_rate')->first()->value;
        $club_point = ClubPoint::findOrFail($request->el);
        $wallet = new Wallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->amount = floatval($club_point->points / $club_point_convert_rate);
        $wallet->payment_method = 'Club Point Convert';
        $wallet->payment_details = 'Club Point Convert';
        $wallet->save();
        $user = Auth::user();
        $user->balance = $user->balance + floatval($club_point->points / $club_point_convert_rate);
        $user->save();
        $club_point->convert_status = 1;
        if ($club_point->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
