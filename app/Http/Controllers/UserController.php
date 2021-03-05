<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\DataTables\CustomerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Role;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    public function indexCustomers(CustomerDataTable $customerDataTable)
    {
        return $customerDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->toarray();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        foreach($request->roles as $role){
            $user->assignRole($role);
        }

        Flash::success('Usuario guardado con éxito.');

        return redirect(route('users.index'));
    }

    public function storeCustomer(CreateUserRequest $request)
    {
        $input = $request->all();
        $user = $this->userRepository->create($input);
        $role = 'Cliente';
        $user->assignRole($role);

        Flash::success('Cliente guardado con éxito.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }
        $roles = Role::pluck('name','name')->toarray();

        return view('users.edit')->with(compact('user', 'roles'));
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }
        $input = $request->all();

        $user = $this->userRepository->update($input, $id);
        $user->roles()->detach();
        foreach($request->roles as $role){
            $user->assignRole($role);
        }

        Flash::success('Usuario actualizado con éxito.');

        return redirect(route('users.index'));
    }
    public function updateCustomer($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }
        $input = $request->all();

        $user = $this->userRepository->update($input, $id);
        $user->roles()->detach();
        $role = 'Cliente';
        $user->assignRole($role);

        Flash::success('Cliente actualizado con éxito.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuario eliminado con éxito.');

        return redirect(route('users.index'));
    }
}
