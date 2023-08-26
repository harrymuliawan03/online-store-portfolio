<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = User::query();

            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    if($item->roles != "ADMIN") {
                        return '
                            <div class="btn-group">
                                <a href="'. route('user.edit', $item->id) .'" class="btn btn-primary border-0 mr-1">Edit</a>
                                <form action="'. route('user.destroy', $item->id) .'" method="POST" id="form'. $item->id .'">
                                            '. method_field('delete') . csrf_field() .'
                                            <button type="button" class="btn btn-danger border-0 modalDelete" data-id="'. $item->id .'">Delete</button>
                                </form>
                            </div>
                        ';
                    }
                })
                ->rawColumns(['action'])
                ->make();
        }
        
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($request->password);

        User::create($data);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = User::findOrFail($id);
        $data['item'] = $query;
        return view('pages.admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $request->all();
        $item = User::findOrFail($id);

        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }else
        {
            unset($data['password']);
        }
        
        $item->update($data);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return redirect()->route('user.index');
    }

    public function getUserName($id) {
        $item = User::findOrfail($id);
        $html = ' "'. $item->name .'" ? ';
        $form = 'form'. $item->id .'';

        $response['html'] = $html;
        $response['form'] = $form;
        return response()->json($response);
    }
}