<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePointRequest;
use App\Http\Requests\UpdatePointRequest;
use App\Models\Area;
use App\Models\Point;
use Illuminate\Support\Facades\Response;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointRequest $request)
    {
        $newPoint = new Point();
        $newPoint->fill($request->all());
        $newPoint->save();

        return Response::redirectTo('department/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointRequest $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Point $point)
    {
        //
    }

    public function unlinkArea(int $pointID, int $areaID) {
        /** @var Point $point */
        $point = Point::where([
            'id' => $pointID
        ])->firstOrFail();

        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $point->areas()->detach($area);

        return redirect()->back();
    }
}
