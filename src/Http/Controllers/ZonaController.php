<?php

namespace Bantenprov\Zona\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\ZonaFacade;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\Zona;
use Bantenprov\Kegiatan\Models\Bantenprov\Kegiatan\Kegiatan;
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
    protected $kegiatanModel;
    protected $zona;
    protected $user;

    public function __construct(Zona $zona, Kegiatan $kegiatan, User $user)
    {
        $this->zona      = $zona;
        $this->kegiatanModel    = $kegiatan;
        $this->user             = $user;
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
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('kegiatan')->with('user')->paginate($perPage);

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
        $kegiatan = $this->kegiatanModel->all();
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['kegiatan'] = $kegiatan;
        $response['user'] = $users;
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
            'kegiatan_id' => 'required',
            'user_id' => 'required',
            'label' => 'required|max:16|unique:zonas,label',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            $check = $zona->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $zona->kegiatan_id = $request->input('kegiatan_id');
                $zona->user_id = $request->input('user_id');
                $zona->label = $request->input('label');
                $zona->description = $request->input('description');
                $zona->save();

                $response['message'] = 'success';
            }
        } else {
            $zona->kegiatan_id = $request->input('kegiatan_id');
            $zona->user_id = $request->input('user_id');
            $zona->label = $request->input('label');
            $zona->description = $request->input('description');
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
        $response['kegiatan'] = $zona->kegiatan;
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

        $response['zona'] = $zona;
        $response['kegiatan'] = $zona->kegiatan;
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
        $zona = $this->zona->findOrFail($id);

        if ($request->input('old_label') == $request->input('label'))
        {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16',
                'description' => 'max:255',
                'kegiatan_id' => 'required',
                'user_id' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16|unique:zonas,label',
                'description' => 'max:255',
                'kegiatan_id' => 'required',
                'user_id' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $zona->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $zona->label = $request->input('label');
                $zona->description = $request->input('description');
                $zona->kegiatan_id = $request->input('kegiatan_id');
                $zona->user_id = $request->input('user_id');
                $zona->save();

                $response['message'] = 'success';
            }
        } else {
            $zona->label = $request->input('label');
            $zona->description = $request->input('description');
            $zona->kegiatan_id = $request->input('kegiatan_id');
            $zona->user_id = $request->input('user_id');
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
