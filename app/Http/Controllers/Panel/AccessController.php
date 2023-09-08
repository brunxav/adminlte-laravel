<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccessController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(Access $access, Request $request)
    {
        $this->model = $access;
        $this->request = $request;
    }

    public function index()
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable()
    {
        $accesses = $this->model
            ->select([
                'accesses.id',
                'accesses.name',
                'accesses.created_at',
            ]);

        return DataTables::of($accesses)
            ->addColumn('checkbox', function ($item) {
                return view('panel.accesses.local.index.datatable.checkbox', compact('item'));
            })
            ->editColumn('id', function ($item) {
                return view('panel.accesses.local.index.datatable.id', compact('item'));
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at ? date('d/m/Y H:i:s', strtotime($item->created_at)) : 'Sem data';
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->addColumn('action', function ($item) {
                $loggedId = auth()->user()->id;

                return view('panel.accesses.local.index.datatable.action', compact('item', 'loggedId'));
            })
            ->make();
    }

    public function create()
    {
        $item = $this->model;

        return view('panel.accesses.local.index.modals.create', compact('item'));
    }

    public function store()
    {
        $data = $this->request->only([
            'name',
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }

        if ($this->request->hasFile('photo')) {
            $data["photo"] = $this->request->file('photo')->store('avatars');
        }

        $item = $this->model->create($data);

        if ($item) {
            return response()->json([
                'status' => '200',
                'message' => 'Ação executada com sucesso!'
            ]);
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Erro executar a ação, tente novamente!']
                ]
            ]);
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        return view('panel.accesses.local.index.modals.edit', compact("item"));
    }

    public function duplicate()
    {
        $item = $this->model->find($this->request->id);

        return view('panel.accesses.local.index.modals.duplicate', compact('item'));
    }

    public function update($id)
    {
        $item = $this->model->find($id);

        if ($item) {
            $data = $this->request->only([
                'name',
            ]);

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
            ]);

            if (count($validator->errors()) > 0) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]);
            }

            $item->update($data);

            if ($item) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Ação executada com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ]
                ]);
            }
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Os dados não foram encontrados!']
                ]
            ]);
        }
    }

    public function delete($id)
    {
        $item = $this->model->find($this->request->id);

        return view('panel.accesses.local.index.modals.delete', compact("item"));
    }

    public function destroy()
    {
        $item = $this->model->find($this->request->id);

        if ($item) {
            $delete = $item->delete();

            if ($delete) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Ação executada com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ],
                ]);
            }
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Os dados não foram encontrados!']
                ],
            ]);
        }
    }

    public function deleteAll()
    {
        $itens = $this->request->checkeds;

        session()->put('ids', $itens);

        return view('panel.accesses.local.index.modals.remove-all', compact("itens"));
    }

    public function destroyAll()
    {

        foreach (session()->get('ids') as $item) {
            $item = $this->model->find($item["id"]);

            if ($item) {
                $item->delete();

                if (!$item) {
                    return response()->json([
                        'status' => '400',
                        'errors' => [
                            'message' => ['Erro executar a ação, tente novamente!']
                        ],
                    ]);
                }
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Os dados não foram encontrados!']
                    ],
                ]);
            }
        }

        return response()->json([
            'status' => '200',
            'message' => 'Ação executada com sucesso!'
        ]);
    }
}
