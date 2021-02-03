<?php

namespace App\Http\Controllers;
use App\Models\Categories;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusChanged;

class ItemsController extends Controller
{
    public function inputFilter($input_field){
        $input = htmlspecialchars(stripcslashes(strip_tags($input_field)));
        return $input;
    }

    public function addItem(){
        if(session()->has('seller')){
            $categories = DB::table('categories')->get();
            return view('add-item',compact('categories'));
        }else{
            return redirect('/');
        }
    }

    public function addItemPost(Request $request){
        if(session()->has('seller')){
            $request->validate([
                'name' => 'required|string|min:3',
                'description' => 'required|string|min:4',
                'categories' => 'required|int',
                'status' => 'required|string|min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'price' => 'required|int',
            ]);
            $image = time() .'_'. rand(1,1000) .'.'.$request->image->extension();  
            $insertItem = Items::insert([
                'user_id' => session()->get('seller')->id,
                'cat_id' => $this->inputFilter($request->categories),
                'name' => $this->inputFilter($request->name),
                'description' => $this->inputFilter($request->description),
                'status' => $this->inputFilter($request->status),
                'image' => $image,
                'price' => $this->inputFilter($request->price),
                'created_at' => date('Y-m-d h:m:s')
            ]);
            if($insertItem){
                $request->image->move(public_path('uploads/images'),$image);
                return back()->with('success','Product added successfully');
            }
        }else{
            return redirect('/');
        }
    }

    public function myItems(){
        if(session()->has('seller')){
            $items = DB::table('items')->where('user_id','=',session()->get('seller')->id)->get();
            return view('items',compact('items'));
        }else{
            return redirect('/');
        }
    }
    public function sellerPage($id){
        $items = DB::table('items')->where(['user_id' => $id])->get();
        return view('items',compact('items'));
    }

    public function addToCart(Request $request){
        if(session()->has('seller')){
            return back()->with('warning','This feature for customers only');
        }else{
            if(isset($_COOKIE['item_id']) && isset($_COOKIE['number'])){
                setcookie('number',intval($_COOKIE['number']+1),time()+(60*60*24*30));
                setcookie('item_id['.$_COOKIE['number'].']',$this->inputFilter($request->item_id),time()+(60*60*24*30));

            }else{
                setcookie('number',1,time()+(60*60*24*30));
                setcookie('item_id[0]',$this->inputFilter($request->item_id),time()+(60*60*24*30));
            }
            return back()->with('warning','It has been added to the cart');
        }
        
    }

    public function viewCart(){
        $allCart = isset($_COOKIE['item_id']) ? array_unique($_COOKIE['item_id']) : NULL;
        $countCart = isset($_COOKIE['item_id']) ? $_COOKIE['item_id'] : NULL;
        return view('view-cart',compact('allCart','countCart'));
    }

    public function viewItem($id){
        if(session()->has('customer')){
            
            if(isset($_COOKIE['item_id']) && in_array($id,$_COOKIE['item_id'])){
                $item = DB::table('items')->Where('id','=',$id)->first();

                $order = DB::table('orders')->Where([
                    'item_id' => $id,
                    'customer_id' => session()->get('customer')->id
                ])->first();
                if($item){
                    return view('view-item',compact('item','order'));
                }else{
                    return redirect('/')->with('warning','This product is not available');
                }
            }else{
                return redirect('/');
            }
           
        }else{
            return redirect('/login');
        } 
 
    }

    public function insertOrder(Request $request){
        if(session()->has('customer')){

            $order = DB::table('orders')->Where([
                'item_id' => $request->item_id,
                'customer_id' => session()->get('customer')->id
            ])->first();

            if($order){
                return back();
            }else{

                $request->validate([
                    'seller_id'=> 'required|int',
                    'item_id'=> 'required|int',
                    'address' => 'required|string',
                    'received_data' => 'required',
                ]);

                $insertOrder = DB::table('orders')->insert([
                    'seller_id' => $this->inputFilter($request->seller_id),
                    'customer_id' => session()->get('customer')->id,
                    'item_id' => $this->inputFilter($request->item_id),
                    'count' => isset($_COOKIE['item_id']) && in_array($request->item_id,$_COOKIE['item_id']) ?   array_count_values($_COOKIE['item_id'])[$request->item_id] : 1,
                    'address' => $this->inputFilter($request->address),
                    'mobile_number' => session()->get('customer')->personal_mobile,
                    'received_date' => $this->inputFilter($request->received_data),
                    'created_at' => date('Y-m-d h:m:s'),
                ]);
                if($insertOrder){
                    return back()->with('success','The request has been sent successfully');
                }else{
                    return back()->with('fail','Something went wrong, please try again');
                }
            }

        }else{
            return redirect('/')->with('warning','This feature for customers only');;
        }
    }

    public function viewOrder(){
        if(session()->has('seller')){
            $getOrders = DB::table('orders')->where(['seller_id'=>session()->get('seller')->id])->get();
            $getItem = function ($table,$item_id){
                $item = DB::table($table)->where(['id'=> $item_id])->first();
                return $item;
            };
            return view('view-orders',compact('getOrders','getItem'));
        }else{
            return redirect('/');
        }
    }
    public function updateOrder(Request $request){
        if(session()->has('seller')){
            $request->validate([
                'customer_id' => 'required|int',
                'item_id'     => 'required|int',
                'status'     =>  'required|string',
            ]);
            $order = DB::table('orders')->where([
                'seller_id'   => session()->get('seller')->id,
                'customer_id' => $this->inputFilter($request->customer_id),
                'item_id'     => $this->inputFilter($request->item_id),
            ])->first();

            if($order->status == $this->inputFilter($request->status)){
                return back();
            }else{
                $updateOrder = DB::table('orders')->where([
                    'seller_id'   => session()->get('seller')->id,
                    'customer_id' => $this->inputFilter($request->customer_id),
                    'item_id'     => $this->inputFilter($request->item_id),
                ])->update([
                    'status' => $this->inputFilter($request->status),
                ]);
                if($updateOrder){

                    $user = DB::table('users')->where('id','=',$request->customer_id)->first();
                    if($user){
                        $details = [
                            'title' => 'Awamer | The status of your order has changed ',
                            'body'  => $_SERVER['HTTP_HOST'].'/view-item/'. $this->inputFilter($request->item_id),
                        ];
    
                        Mail::to($user->email)->send(new StatusChanged($details));
                        return back();
                    }else{
                        return back();
                    }


                }else{
                    return back();
                }
            }
            
        }else{
            return redirect('/');
        }
    }
}
