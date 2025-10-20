<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Models\Area;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\View\View as ViewContract;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ViewContract
    {
        return View::make('area.index', [
            'areas' => Area::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): ViewContract
    {
        return View::make('area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        $newArea = Area::create($request->all());

        return Response::redirectTo('area/' . $newArea->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $areaID): ViewContract
    {
        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $users = User::whereNotIn('id', $area->users->pluck('id'))->get();

        return View::make('area.show', [
            'area' => $area,
            'allUsers' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $areaID): ViewContract
    {
        $area = Area::where([
            'id' => $areaID
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
            'id' => $areaID
        ])->firstOrFail();

        $area->update($request->all());

        return Response::redirectTo('area/' . $area->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $areaID)
    {
        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $area->delete();

        return redirect()->back();
    }

    public function unlinkDepartment(int $areaID) {
        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $area->unlinkDepartment();

        $area->saveOrFail();

        return redirect()->back();
    }

    public function linkUsers(Request $request, int $areaID) {
        //todo validate
        $userIDs = $request->users;

        $area = Area::where([
            'id' => $areaID
        ])->firstOrFail();

        $users = User::whereIn('id', $userIDs)->get();

        $area->users()->attach($users);

        return redirect()->back();
    }
}
