<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\user;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    protected array $models = ['admins', 'categories', 'products', 'clients', 'orders'];
    protected array $permissions = ['create', 'read', 'update', 'delete'];

    public function __construct()
    {

        $this->middleware('permission:admins-create')->only(['create', 'store']);
        $this->middleware('permission:admins-read|admins-update|admins-delete')->only(['index']);
        $this->middleware('permission:admins-update')->only(['update', 'edit']);
        $this->middleware('permission:admins-update')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $users = User::whereRoleIs('admin')
            ->when($SearchText = request('search'), fn($query) => $query->filterByName($SearchText))
            ->latest()
            ->paginate();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('dashboard.users.create', ['models' => $this->models, 'permissions' => $this->permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        //initialize User
        $user = new User($request->safe()->except(['permissions', 'image']));
        //Image saving and setting value for User
        if ($request->has('image')) {
            Image::make($request->image)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/uploads/user-images/' . $ImageName = $request->file('image')->hashName()));
            $user->image = $ImageName;
        }

        //$user->image =
        $user->save();
        //Attaching Role
        $user->attachRole('admin');
        //Syncing permissions array
        $user->syncPermissions($request->validated('permissions'));
        session()->flash('success', __('messages.added_successfully'));
        return redirect(status: 200)->route('dashboard.users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param user $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param user $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(user $user)
    {
        $user->append('permissions');
        return view('dashboard.users.edit', [
            'user' => $user,
            'models' => $this->models,
            'permissions' => $this->permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param user $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, user $user)
    {
        // prepare data
        $updatedData = $request->safe()->except(['permissions', 'image']);
        // if image has been uploaded replace the old one or save it with hashed name
        if ($request->has('image')) {
            // save image
            Image::make($request->image)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/uploads/user-images/' . $updatedData['image'] = $request->file('image')->hashName()));
        }
        $user->update($updatedData);
        $user->syncPermissions($request->validated('permissions'));
        session()->flash('success', __('messages.updated_successfully'));

        return redirect(status: 200)->route('dashboard.users.index');
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param user $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(user $user)
    {
        $user->delete();
        $user->image ?? Storage::delete(storage_path('uploads/user-images/' . $user->image));

        session()->flash('success', __('messages.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }


}
