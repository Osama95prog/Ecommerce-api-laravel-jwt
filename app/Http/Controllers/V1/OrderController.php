<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\orderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate();

    return OrderResource::collection($orders);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
        $products = collect($request->products);
        $order = Order::create([
            'user_id' => Auth::id(),
            'payment_method' => 'cod',
            'total' => 1000,
            'total' => Order::getCartTotal($products),
        ]);

        foreach ($products as $item) {
            orderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => 'name',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        foreach ($request->post('address') as $type => $address) {
            $address['type'] = $type;
            $order->addresses()->create($address);
        }

        DB::commit();

    } catch (Throwable $e) {
        DB::rollBack();
        throw $e;
        }

    return response()->json([
        'message' => 'The order created successfully',

    ],201);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
