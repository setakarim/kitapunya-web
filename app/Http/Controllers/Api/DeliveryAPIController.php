<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DetailHistoryResource;
use App\Http\Resources\Driver\ListDeliveryResource;
use App\Http\Resources\Driver\ListHistoryResource;
use App\Model\Delivery;
use App\Model\Donasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery = Delivery::all();

        return response()->json($delivery, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user_id = auth('api')->user()->id;

        $donasi = Donasi::find($request->id);

        if ($donasi->status == 2) {
            Delivery::create([
                'no_transaksi' => $this->generateNoTrx(),
                'donasi_id' => $request->id,
                'users_id' => $user_id,
                'created_at' => Carbon::now(),
            ]);

            $donasi->status = 4;
        } else {
            $donasi->status = $donasi->status + 1;
        }

        $donasi->updated_at = Carbon::now();
        $donasi->save();

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelivery()
    {
        $query = Delivery::where('users_id', auth('api')->user()->id)->get();

        return ListDeliveryResource::collection($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory()
    {
        $query = Delivery::where('users_id', auth('api')->user()->id)->get();

        return ListHistoryResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Donasi::find($id);

        return new DetailHistoryResource($query);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * @return string
     */
    public function generateNoTrx()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_delivery = Delivery::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_delivery_no = isset($latest_delivery->no_transaksi) ? $latest_delivery->no_transaksi : 'DLV'.$year_month.'00000';
        $cut_string_delivery = str_replace('DLV', '', $get_last_delivery_no);

        return 'DLV'.($cut_string_delivery + 1);
    }
}
