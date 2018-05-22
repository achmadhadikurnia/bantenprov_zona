<?php

namespace Bantenprov\Zona\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\Zona\Facades\ZonaFacade;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\MasterZona;
use App\User;

/* Etc */
use Validator;
use Auth;

/**
 * The MasterZonaController class.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class MasterZonaController extends Controller
{
    protected $master_zona;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->master_zona  = new MasterZona;
        $this->user         = new User;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->master_zona->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->master_zona->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";

                $q->where('tingkat', 'like', $value)
                    ->orWhere('kode', 'like', $value)
                    ->orWhere('label', 'like', $value);
            });
        }

        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;

        $response   = $query->with(['user'])->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $master_zonas = $this->master_zona->with(['user'])->get();

        $response['master_zonas']   = $master_zonas;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $master_zona    = $this->master_zona->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);

        if ($role_check) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['master_zona']    = $master_zona;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $master_zona = $this->master_zona;

        $validator = Validator::make($request->all(), [
            'tingkat'   => 'required|numeric',
            'kode'      => "required|numeric|unique:{$this->master_zona->getTable()},kode,NULL,id,deleted_at,NULL",
            'label'     => 'required|max:255',
            'user_id'   => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $master_zona->id        = $request->input('kode');
            $master_zona->tingkat   = $request->input('tingkat');
            $master_zona->kode      = $request->input('kode');
            $master_zona->label     = $request->input('label');
            $master_zona->user_id   = $request->input('user_id');
            $master_zona->save();

            $error      = false;
            $message    = 'Success';
        }

        $response['master_zona']    = $master_zona;
        $response['error']          = $error;
        $response['message']        = $message;
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterZona  $master-zona
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $master_zona = $this->master_zona->with(['user'])->findOrFail($id);

        $response['master_zona']    = $master_zona;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterZona  $master_zona
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $master_zona    = $this->master_zona->with(['user'])->findOrFail($id);
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);

        if ($master_zona->user !== null) {
            array_set($master_zona->user, 'label', $master_zona->user->name);
        }

        if ($role_check) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['master_zona']    = $master_zona;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterZona  $master_zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $master_zona = $this->master_zona->with(['user'])->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tingkat'   => 'required|numeric',
            'kode'      => "required|numeric|unique:{$this->master_zona->getTable()},kode,{$id},id,deleted_at,NULL",
            'label'     => 'required|max:255',
            'user_id'   => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $master_zona->id        = $request->input('kode');
            $master_zona->tingkat   = $request->input('tingkat');
            $master_zona->kode      = $request->input('kode');
            $master_zona->label     = $request->input('label');
            $master_zona->user_id   = $request->input('user_id');
            $master_zona->save();

            $error      = false;
            $message    = 'Success';
        }

        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterZona  $master_zona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $master_zona = $this->master_zona->findOrFail($id);

        if ($master_zona->delete()) {
            $response['message']    = 'Success';
            $response['success']    = true;
            $response['status']     = true;
        } else {
            $response['message']    = 'Failed';
            $response['success']    = false;
            $response['status']     = false;
        }

        return json_encode($response);
    }
}
