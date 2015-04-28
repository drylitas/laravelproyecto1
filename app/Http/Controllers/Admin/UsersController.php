<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;


class UsersController extends Controller
{
    public function __construct() {
        $this->beforeFilter('@findUser', ['only' => ['show', 'edit', 'update', 'destroy']]);
    }

    public function findUser(Route $route) {
        //$this->user = User::where('username', $route->getParameter('users'))->firstOrFail();
        //dd($route->getParameter('users'));
        $this->user = User::findOrFail($route->getParameter('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::filterAndPaginate($request->get('name'), $request->get('type'));
        // dd($users);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        //dd($request->all());
        $user = $request->all(); //Para cargar todos los objetos
        $user['full_name'] = $request->get('first_name') . ' ' . $request->get('last_name');
        User::create($user);
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.users.edit')->with('user', $this->user);
//        $user = User::findOrFail($id);
//        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $this->user->fill($request->all());
        $this->user['full_name'] = $request->get('first_name') . ' ' . $request->get('last_name');
        $this->user->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        //dd("Eliminado: ".$id);
        //User::destroy($id);
        //$user = User::findOrFail($id);
        //return $id;
        //abort(500);
        $this->user->delete();
        $message = $this->user->full_name . ' fue eliminado de nuestros registros';
        if ($request->ajax()) {
            return $message;

        }
        Session::flash('message', $message);
        return redirect()->route('admin.users.index');
    }

}