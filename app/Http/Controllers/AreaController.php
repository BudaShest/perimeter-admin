<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Models\Area;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return View::make('area.index', [
            'areas' => Area::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        $newArea = Area::create($request->all());

        return Response::redirectTo('area/' . $newArea->area_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $areaID)
    {
        $area = Area::where([
            'area_id' => $areaID
        ])->firstOrFail();

        return View::make('area.show', [
            'area' => $area
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $areaID)
    {
        $area = Area::where([
            'area_id' => $areaID
        ])->firstOrFail();

        return View::make('area.edit', [
            'area' => $area
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, int $areaID)
    {
        $area = Area::where([
            'area_id' => $areaID
        ])->firstOrFail();

        $area->update($request->all());

        return Response::redirectTo('area/' . $area->area_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $areaID)
    {
        $area = Area::where([
            'area_id' => $areaID
        ])->firstOrFail();

        var_dump($area);die;

        $area->delete();

        return redirect()->back();
    }
}
