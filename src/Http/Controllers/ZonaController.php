<?php

namespace Bantenprov\Zona\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\Zona\Facades\ZonaFacade;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\Zona;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use App\User;
use Bantenprov\Nilai\Models\Bantenprov\Nilai\Nilai;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;

/* Etc */
use Validator;
use Auth;

/**
 * The ZonaController class.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ZonaController extends Controller
{
    protected $zona;
    protected $siswa;
    protected $sekolah;
    protected $user;
    protected $nilai;
    protected $admin_sekolah;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->zona          = new Zona;
        $this->siswa         = new Siswa;
        $this->sekolah       = new Sekolah;
        $this->user          = new User;
        $this->nilai         = new Nilai;
        $this->admin_sekolah = new AdminSekolah;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();

        if(is_null($admin_sekolah) && $this->checkRole(['superadministrator']) === false){
            $response = [];
            return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        }
        
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            if($this->checkRole(['superadministrator'])){
                $query = $this->zona->orderBy($sortCol, $sortDir);
            }else{
                $query = $this->zona->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy($sortCol, $sortDir);
            }
        } else {
            if($this->checkRole(['superadministrator'])){
                $query = $this->zona->orderBy('id', 'asc');
            }else{
                $query = $this->zona->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy('id', 'asc');            
            }
        }

        if ($request->exists('filter')) {
            if($this->checkRole(['superadministrator'])){
                $query->where(function($q) use($request) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', 'like', $value)
                        ->orWhere('admin_sekolah_id', 'like', $value);
                });
            }else{
                $query->where(function($q) use($request, $admin_sekolah) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', $admin_sekolah->sekolah_id)->where('sekolah_id', 'like', $value);
                });
            }

        }

        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;

        $response   = $query->with(['siswa', 'sekolah', 'user'])->paginate($perPage);

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
        $zonas = $this->zona->with(['siswa', 'sekolah', 'user'])->get();

        $response['zonas']      = $zonas;
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
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $zona           = $this->zona->getAttributes();
        //$siswas         = $this->siswa->getAttributes();
        $sekolahs       = $this->sekolah->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();

        if($this->checkRole(['superadministrator'])){
            $siswas = $this->siswa->all();
        }else{
            $sekolah_id = $admin_sekolah->sekolah_id;
            $siswas     = $this->siswa->where('sekolah_id', $sekolah_id)->get();
        }

        foreach ($siswas as $siswa) {
            array_set($siswa, 'label', $siswa->nomor_un.' - '.$siswa->nama_siswa);
        }

        foreach ($sekolahs as $sekolah) {
            array_set($sekolah, 'label', $sekolah->nama);
        }

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

        $response['zona']           = $zona;
        $response['siswa']          = $siswas;
        $response['sekolahs']       = $sekolahs;
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
        $zona = $this->zona;

        $validator = Validator::make($request->all(), [
            'nomor_un'          => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->zona->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            // 'sekolah_id'        => "required|exists:{$this->sekolah->getTable()},id",
            // 'zona_siswa'     => "required|exists:{$this->city->getTable()},id",
            // 'zona_sekolah'   => "required|exists:{$this->village->getTable()},id",
            // 'lokasi_siswa'   => "required|exists:{$this->district->getTable()},id",
            // 'lokasi_sekolah' => "required|exists:{$this->village->getTable()},id",
            // 'nilai'             => 'required|numeric',
            'user_id'           => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $nomor_un       = $request->input('nomor_un');
            $siswa          = $this->siswa->where('nomor_un', $nomor_un)->with(['sekolah'])->first();
            $zona_siswa     = substr($siswa->village_id, 0, 6);
            $zona_sekolah   = substr($siswa->sekolah->village_id, 0, 6);
            $lokasi_siswa   = $siswa->village_id;
            $lokasi_sekolah = $siswa->sekolah->village_id;

            $zona->nomor_un         = $nomor_un;
            $zona->sekolah_id       = $siswa->sekolah->id;
            $zona->zona_siswa       = $zona_siswa;
            $zona->zona_sekolah     = $zona_sekolah;
            $zona->lokasi_siswa     = $lokasi_siswa;
            $zona->lokasi_sekolah   = $lokasi_sekolah;
            $zona->nilai            = $this->zona->nilai($lokasi_siswa, $lokasi_sekolah);
            $zona->user_id          = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $zona->nomor_un,
                ],
                [
                    'nomor_un'  => $zona->nomor_un,
                    'zona'      => $zona->nilai,
                    'total'     => null,
                    'user_id'   => $zona->user_id,
                ]
            );

            DB::beginTransaction();

            if ($zona->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $message    = 'Success';
            } else {
                DB::rollBack();

                $error      = true;
                $message    = 'Failed';
            }
        }

        $response['zona']       = $zona;
        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zona = $this->zona->with(['siswa', 'sekolah', 'user'])->findOrFail($id);

        $response['zona']       = $zona;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;

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
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $zona           = $this->zona->with(['siswa', 'sekolah', 'user'])->findOrFail($id);
        $siswas         = $this->siswa->getAttributes();
        $sekolahs       = $this->sekolah->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();

        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);

        if ($zona->user !== null) {
            array_set($zona->user, 'label', $zona->user->name);
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

        $response['zona']           = $zona;
        $response['siswas']         = $siswas;
        $response['sekolahs']       = $sekolahs;
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
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $zona = $this->zona->with(['siswa', 'sekolah', 'user'])->findOrFail($id);

        $validator = Validator::make($request->all(), [
            // 'nomor_un'          => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->zona->getTable()},nomor_un,{$id},id,deleted_at,NULL",
            // 'sekolah_id'        => "required|exists:{$this->sekolah->getTable()},id",
            // 'zona_siswa'     => "required|exists:{$this->city->getTable()},id",
            // 'zona_sekolah'   => "required|exists:{$this->village->getTable()},id",
            // 'lokasi_siswa'   => "required|exists:{$this->district->getTable()},id",
            // 'lokasi_sekolah' => "required|exists:{$this->village->getTable()},id",
            // 'nilai'             => 'required|numeric',
            'user_id'           => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $nomor_un       = $zona->nomor_un; // $request->input('nomor_un');
            $siswa          = $this->siswa->where('nomor_un', $nomor_un)->with(['sekolah'])->first();
            $zona_siswa     = substr($siswa->village_id, 0, 6);
            $zona_sekolah   = substr($siswa->sekolah->village_id, 0, 6);
            $lokasi_siswa   = $siswa->village_id;
            $lokasi_sekolah = $siswa->sekolah->village_id;

            $zona->nomor_un         = $nomor_un;
            $zona->sekolah_id       = $siswa->sekolah->id;
            $zona->zona_siswa       = $zona_siswa;
            $zona->zona_sekolah     = $zona_sekolah;
            $zona->lokasi_siswa     = $lokasi_siswa;
            $zona->lokasi_sekolah   = $lokasi_sekolah;
            $zona->nilai            = $this->zona->nilai($lokasi_siswa, $lokasi_sekolah);
            $zona->user_id          = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $zona->nomor_un,
                ],
                [
                    'nomor_un'  => $zona->nomor_un,
                    'zona'      => $zona->nilai,
                    'total'     => null,
                    'user_id'   => $zona->user_id,
                ]
            );

            DB::beginTransaction();

            if ($zona->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $message    = 'Success';
            } else {
                DB::rollBack();

                $error      = true;
                $message    = 'Failed';
            }
        }

        $response['zona']       = $zona;
        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

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

    protected function checkRole($role = array())
    {
        return Auth::user()->hasRole($role);
    }
}
