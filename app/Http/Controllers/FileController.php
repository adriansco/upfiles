<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\File;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function fetchFile($id)
    {
        /* variants */
        $query = DB::table('files')
            ->select('id', 'name', 'path', 'employee_payroll', 'created_at')
            ->where('employee_payroll', $id)
            ->get();
        for ($i = 0; $i < count($query); $i++) {
            $created_at = Carbon::parse($query[$i]->created_at);
            $query[$i]->created_at = $created_at->diffForHumans();;
        }
        return DataTables::of($query)
            ->addColumn('btn', 'files/actions')
            ->rawColumns(['btn'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * https://www.youtube.com/watch?v=2ktQ_nQyJZY
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /* 'path' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip|max:2048', */
            'title' => 'string|required|min:2|max:75',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {

            DB::beginTransaction();

            $id = $request->input('employee_payroll');
            $file = $request->file('file');
            try {
                if ($file) {
                    $filename = $file->getClientOriginalName();
                    $foo = \File::extension($filename);
                    if ($foo == 'pdf') {
                        /* date('Ymdhmi') sustituir con el nombre del documento */
                        $route_file = $id . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
                        Storage::disk('public')->put($route_file, \File::get($file));
                        File::create([
                            'name' => $request->input('title'),
                            'path' => $route_file,
                            'employee_payroll' => $id
                        ]);
                        DB::commit();
                        return response()->json([
                            'response' => [
                                'status' => 201,
                                'msg' => 'Su archivo ha sido guardado',
                            ]
                        ], 201);
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'response' => [
                                'status' => 400,
                                'msg' => 'Solo Archivos PDF',
                            ]
                        ], 201);
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                return $e;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);
        /* Storage::disk('public')->delete('/storage/'.$file->path); */
        Storage::disk('public')->delete($file->path);

        if ($file) {
            $file->delete();
            return response()->json([
                'response' => [
                    'status' => 201,
                    'msg' => 'Su archivo ha sido eliminado.',
                ]
            ], 201);
        } else {
            return response()->json([
                'response' => [
                    'status' => 400,
                    'msg' => 'No existe el archivo',
                ]
            ], 201);
        }
    }
}
