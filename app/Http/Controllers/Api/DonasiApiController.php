<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DonaturHistory\DetailHistoryResource;
use App\Http\Resources\DonaturHistory\HistoryResource;
use App\Http\Resources\Driver\ListDonasiResource;
use App\Model\BarangCampaign;
use App\Model\DetailDonasi;
use App\Model\Donasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DonasiApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donasi = Donasi::all();

        return response()->json($donasi, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory()
    {
        $query = Donasi::where('users_id', auth('api')->user()->id)->get();

        return HistoryResource::collection($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDonation(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $query = Donasi::where('status', $request->status)->get();

        return ListDonasiResource::collection($query);
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
            'location' => 'required',
            'anonim' => 'required',
            'items' => 'required',
            'items.*.id' => 'required',
            'items.*.file' => 'required',
            'items.*.qty' => 'required|not_in:0',
        ]);

        $user_id = auth('api')->user()->id;

        foreach ($request->items as $item) {
            $barangCampaign = BarangCampaign::find($item['id']);
            $sisa = $barangCampaign->max_qty - $barangCampaign->real_qty;

            if ($item['qty'] > $sisa) {
                return response()->json(['error' => 'Barang yang disumbangkan tidak boleh melebihi kapasitas'], 401);
            }
        }

        $donasi = Donasi::create([
            'no_transaksi' => $this->generateNoTrx(),
            'status' => 1,
            'location' => $request->location,
            'long' => $request->long,
            'lat' => $request->lat,
            'anonim' => $request->anonim,
            'users_id' => $user_id,
            'campaign_id' => $request->id,
            'created_at' => Carbon::now(),
        ]);

        foreach ($request->items as $item) {
            if ($item['file']) {
                $file = $item['file'];
                @list($type, $file_data) = explode(';', $file);
                @list(, $file_data) = explode(',', $file_data);
                $file_name = $this->generateFileName($item['id']).'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                Storage::disk('public')->put('detail_donasi/'.$file_name, base64_decode($file_data), 'public');
            } else {
                $file_name = '';
            }

            $detailDonasi[] = [
                'qty' => $item['qty'],
                'file_name' => $file_name,
                'donasi_id' => $donasi->id,
                'barang_campaign_id' => $item['id'],
                'created_at' => Carbon::now(),
            ];

            $barangCampaign = BarangCampaign::find($item['id']);
            $barangCampaign->real_qty = $barangCampaign->real_qty + $item['qty'];
            $barangCampaign->updated_at = Carbon::now();
            $barangCampaign->save();
        }
        DetailDonasi::insert($detailDonasi);

        return response()->json(['message' => 'Success'], 200);
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
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Donasi::find($request->id)->update(['status' => 2]);

        $donasi = Donasi::find($request->id);

        return response()->json(['message' => 'Success', 'donasi' => $donasi], 200);
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
        $latest_donasi = Donasi::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_donasi_no = isset($latest_donasi->no_transaksi) ? $latest_donasi->no_transaksi : 'DON'.$year_month.'00000';
        $cut_string_donasi = str_replace('DON', '', $get_last_donasi_no);

        return 'DON'.($cut_string_donasi + 1);
    }

    /**
     * @return string
     */
    public function generateFileName($id)
    {
        $date = Carbon::now()->toDateString();
        $clock = Carbon::now()->toTimeString();

        return 'detail_donasi_id_'.$id.'_'.$date.'_'.$clock;
    }
}
