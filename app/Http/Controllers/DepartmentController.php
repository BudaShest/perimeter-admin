<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        return View::make('department.index', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        return View::make('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        /** @var Department $newDepartment */
        $newDepartment = Department::create($request->all());

        return Response::redirectTo('department/' . $newDepartment->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $departmentID)
    {
        $department = Department::where([
            'id' => $departmentID
        ])->firstOrFail();

        return View::make('department.show', [
            'department' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $departmentID)
    {
        $department = Department::where([
            'id' => $departmentID
        ])->firstOrFail();

        return View::make('department.edit', [
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, int $departmentID)
    {
        /** @var Department $department */
        $department = Department::where([
            'id' => $departmentID
        ])->firstOrFail();

        $department->update($request->all());

        return Response::redirectTo('department/' . $department->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $departmentID)
    {
        $department = Department::where([
            'id' => $departmentID
        ])->firstOrFail();

        $department->delete();

        return Response::redirectTo('department');
    }
}
