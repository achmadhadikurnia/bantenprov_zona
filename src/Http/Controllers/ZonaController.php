<?php

namespace Bantenprov\Zona\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\ZonaFacade;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\Zona;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use Bantenprov\Zona\Models\Bantenprov\Zona\MasterZona;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use App\User;

/* Etc */
use Validator;

/**
 * The ZonaController class.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ZonaController extends Controller
{  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $siswa;
    protected $zona;
    protected $master_zona;
    protected $sekolah;
    protected $user;

    public function __construct(Zona $zona, Siswa $siswa, User $user, MasterZona $master_zona, Sekolah $sekolah)
    {
        $this->zona             = $zona;
        $this->siswa            = $siswa;
        $this->user             = $user;
        $this->master_zona      = $master_zona;
        $this->sekolah          = $sekolah;
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

            $query = $this->zona->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->zona->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('id', 'like', $value)
                    ->orWhere('label', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('siswa')->with('master_zona')->with('sekolah')->with('user')->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $response = [];
        $siswas = $this->siswa->all();
        $master_zonas = $this->master_zona->all();
        $sekolahs = $this->sekolah->all();
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

        foreach($siswas as $siswa){
            array_set($siswa, 'label', $siswa->nama_siswa);
        }

        $response['siswa'] = $siswas;
        $response['current_user'] = $current_user;
        $response['master_zona'] = $master_zonas;
        $response['sekolah'] = $sekolahs;
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
        $zona = $this->zona;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:zonas,user_id',
            'master_zona_id' => 'required|unique:zonas,master_zona_id',
            'nomor_un' => 'required|unique:zonas,nomor_un',
            'sekolah_id' => 'required',
            'zona_siswa' => 'required',
            'zona_sekolah' => 'required',
            'lokasi_siswa' => 'required',
            'lokasi_sekolah' => 'required',
            'nilai_zona' => 'required',
        ]);

        if($validator->fails()){
            $check = $zona->where('user_id',$request->user_id)->orWhere('nomor_un',$request->nomor_un)->orWhere('master_zona_id',$request->master_zona_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, Master Zona, Nama Siswa already exists';
            } else {
                $zona->user_id = $request->input('user_id');
                $zona->master_zona_id = $request->input('master_zona_id');
                $zona->nomor_un = $request->input('nomor_un');
                $zona->sekolah_id = $request->input('sekolah_id');
                $zona->zona_siswa = $request->input('zona_siswa');
                $zona->zona_sekolah = $request->input('zona_sekolah');
                $zona->lokasi_siswa = $request->input('lokasi_siswa');
                $zona->lokasi_sekolah = $request->input('lokasi_sekolah');
                $zona->nilai_zona = $request->input('nilai_zona');
                $zona->save();

                $response['message'] = 'success';
            }
        } else {
            $zona->user_id = $request->input('user_id');
                $zona->master_zona_id = $request->input('master_zona_id');
                $zona->nomor_un = $request->input('nomor_un');
                $zona->sekolah_id = $request->input('sekolah_id');
                $zona->zona_siswa = $request->input('zona_siswa');
                $zona->zona_sekolah = $request->input('zona_sekolah');
                $zona->lokasi_siswa = $request->input('lokasi_siswa');
                $zona->lokasi_sekolah = $request->input('lokasi_sekolah');
                $zona->nilai_zona = $request->input('nilai_zona');
                $zona->save();

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
        $zona = $this->zona->findOrFail($id);

        $response['zona'] = $zona;
        $response['master_zona'] = $zona->master_zona;
        $response['sekolah'] = $zona->sekolah;
        $response['siswa'] = $zona->siswa;
        $response['user'] = $zona->user;
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
        $zona = $this->zona->findOrFail($id);

        array_set($zona->user, 'label', $zona->user->name);
        array_set($zona->siswa, 'label', $zona->siswa->nama_siswa);

        $response['zona'] = $zona;
        $response['master_zona'] = $zona->master_zona;
        $response['sekolah'] = $zona->sekolah;
        $response['siswa'] = $zona->siswa;
        $response['user'] = $zona->user;
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

        $zona = $this->zona->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:zonas,user_id,'.$id,
            'master_zona_id' => 'required|unique:zonas,master_zona_id,'.$id,
            'nomor_un' => 'required|unique:zonas,nomor_un,'.$id,
            'sekolah_id' => 'required',
            'zona_siswa' => 'required',
            'zona_sekolah' => 'required',
            'lokasi_siswa' => 'required',
            'lokasi_sekolah' => 'required',
            'nilai_zona' => 'required',
        ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }                
                    } 

             $check_user  = $this->zona->where('id','!=', $id)->where('user_id', $request->user_id);
             $check_siswa = $this->zona->where('id','!=', $id)->where('nomor_un', $request->nomor_un);
             $check_master_zona = $this->zona->where('id','!=', $id)->where('master_zona_id', $request->master_zona_id);
             $check_sekolah = $this->zona->where('id','!=', $id)->where('sekolah_id', $request->sekolah_id);

             if($check_user->count() > 0 || $check_siswa->count() > 0 || $check_master_zona->count() > 0 || $check_sekolah->count() > 0){
                  $response['message'] = implode("\n",$message);
        } else {
            $zona->user_id = $request->input('user_id');
                $zona->master_zona_id = $request->input('master_zona_id');
                $zona->nomor_un = $request->input('nomor_un');
                $zona->sekolah_id = $request->input('sekolah_id');
                $zona->zona_siswa = $request->input('zona_siswa');
                $zona->zona_sekolah = $request->input('zona_sekolah');
                $zona->lokasi_siswa = $request->input('lokasi_siswa');
                $zona->lokasi_sekolah = $request->input('lokasi_sekolah');
                $zona->nilai_zona = $request->input('nilai_zona');
                $zona->save();

            $response['message'] = 'success';
        }

        } else {
            $zona->user_id = $request->input('user_id');
                $zona->master_zona_id = $request->input('master_zona_id');
                $zona->nomor_un = $request->input('nomor_un');
                $zona->sekolah_id = $request->input('sekolah_id');
                $zona->zona_siswa = $request->input('zona_siswa');
                $zona->zona_sekolah = $request->input('zona_sekolah');
                $zona->lokasi_siswa = $request->input('lokasi_siswa');
                $zona->lokasi_sekolah = $request->input('lokasi_sekolah');
                $zona->nilai_zona = $request->input('nilai_zona');
                $zona->save();

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
        $zona = $this->zona->findOrFail($id);

        if ($zona->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
