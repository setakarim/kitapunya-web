<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Campaign\CampaignResource;
use App\Http\Resources\Campaign\DetailCampaignResource;
use App\Model\BarangCampaign;
use App\Model\Campaign;
use App\Model\Rilis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CampaignAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign = Campaign::all();

        return response()->json($campaign, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrent()
    {
        $query = Campaign::where('status', '<', 2)->where('time_limit', '>=', Carbon::now()->toDateString())->get();
        $query = $query->sortByDesc('id')->take(5);

        return CampaignResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategory($id)
    {
        if ($id == 0) {
            $query = Campaign::where('status', '<', 2)->where('time_limit', '>=', Carbon::now()->toDateString())->get();
        } else {
            $query = Campaign::where('status', '<', 2)->where('time_limit', '>=', Carbon::now()->toDateString())->where('category_id', $id)->get();
        }

        return CampaignResource::collection($query);
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
            'title' => 'required',
            'time_limit' => 'required',
            'location' => 'required',
            'category_id' => 'required',
            'items' => 'required',
            'items.*.max_qty' => 'required|not_in:0',
            'items.*.barang_id' => 'required',
        ]);

        $user_id = auth('api')->user()->id;

        $campaign = Campaign::create([
            'no_transaksi' => $this->generateNoTrx(),
            'title' => $request->title,
            'description' => $request->description,
            'time_limit' => $request->time_limit,
            'location' => $request->location,
            'long' => $request->long,
            'lat' => $request->lat,
            'status' => 1,
            'category_id' => $request->category_id,
            'users_id' => $user_id,
            'created_at' => Carbon::now(),
        ]);

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateFileName($campaign->id).'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('public')->put('campaign/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $campaign->file_name = $file_name;
        $campaign->save();

        foreach ($request->items as $item) {
            $barang_campaign[] = [
                'max_qty' => $item['max_qty'],
                'barang_id' => $item['barang_id'],
                'campaign_id' => $campaign->id,
                'created_at' => Carbon::now(),
            ];
        }
        BarangCampaign::insert($barang_campaign);

        return response()->json(['message' => 'Success', 'campaign' => $campaign, 'barang_campaign' => $barang_campaign], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeRelease(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'campaign_id' => 'required',
        ]);

        $rilis = Rilis::where('campaign_id', $request->campaign_id)->get();

        if ($rilis->isEmpty()) {
            Rilis::create([
                'title' => $request->title,
                'description' => $request->description,
                'campaign_id' => $request->campaign_id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Rilis Sudah Ada'], 409);
        }
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
        $query = Campaign::find($id);

        return new DetailCampaignResource($query);
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
        $latest_campaign = Campaign::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_campaign_no = isset($latest_campaign->no_transaksi) ? $latest_campaign->no_transaksi : 'CAMP'.$year_month.'00000';
        $cut_string_campaign = str_replace('CAMP', '', $get_last_campaign_no);

        return 'CAMP'.($cut_string_campaign + 1);
    }

    /**
     * @return string
     */
    public function generateFileName($id)
    {
        $date = Carbon::now()->toDateString();
        $clock = Carbon::now()->toTimeString();

        return 'campaign_id_'.$id.'_'.$date.'_'.$clock;
    }
}
