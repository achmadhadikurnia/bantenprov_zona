<?php

namespace Bantenprov\Zona\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\MasterZona;
use App\User;

/* Etc */
use Validator;

/**
 * The ZonaController class.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class MasterZonaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $master_zona;
    protected $user;

    public function __construct(MasterZona $master_zona, User $user)
    {
        $this->master_zona = $master_zona;
        $this->user        = $user;
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
                $q->where('id', 'like', $value)
                    ->orWhere('label', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->paginate($perPage);

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

        foreach($master_zonas as $master_zona){
            array_set($master_zona, 'label', $master_zona->nama);
        }

        $response['master_zonas']   = $master_zonas;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $response = [];
        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();

        $role_check = \Auth::User()->hasRole(['superadministrator','administrator']);

        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user'] = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['current_user'] = $current_user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $master_zona = $this->master_zona;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:master_zonas,user_id',
            'tingkat' => 'required',
            'kode' => 'required',
            'label' => 'required'
        ]);

        if($validator->fails()){
            $check = $master_zona->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username already exists';
            } else {
                $master_zona->user_id = $request->input('user_id');
                $master_zona->tingkat = $request->input('tingkat');
                $master_zona->kode = $request->input('kode');
                $master_zona->label = $request->input('label');
                $master_zona->save();

                $response['message'] = 'success';
            }
        } else {
                $master_zona->user_id = $request->input('user_id');
                $master_zona->tingkat = $request->input('tingkat');
                $master_zona->kode = $request->input('kode');
                $master_zona->label = $request->input('label');
                $master_zona->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $master_zona = $this->master_zona->findOrFail($id);

        $response['master_zona'] = $master_zona;
        $response['user'] = $master_zona->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_zona = $this->master_zona->findOrFail($id);

        array_set($master_zona->user, 'label', $master_zona->user->name);

        $response['master_zona'] = $master_zona;
        $response['user'] = $master_zona->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = array();
        $message  = array();

        $master_zona = $this->master_zona->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:master_zonas,user_id,'.$id,
            'tingkat' => 'required',
            'kode' => 'required',
            'label' => 'required'
        ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }
                    }

             $check_user = $this->master_zona->where('id','!=', $id)->where('user_id', $request->user_id);

             if($check_user->count() > 0){
                  $response['message'] = implode("\n",$message);
        } else {
                $master_zona->user_id = $request->input('user_id');
                $master_zona->tingkat = $request->input('tingkat');
                $master_zona->kode = $request->input('kode');
                $master_zona->label = $request->input('label');
                $master_zona->save();


            $response['message'] = 'success';
        }

        } else {
                $master_zona->user_id = $request->input('user_id');
                $master_zona->tingkat = $request->input('tingkat');
                $master_zona->kode = $request->input('kode');
                $master_zona->label = $request->input('label');
                $master_zona->save();


                $response['message'] = 'success';
        }

                $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $master_zona = $this->master_zona->findOrFail($id);

        if ($master_zona->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
