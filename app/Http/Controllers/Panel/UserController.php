<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(User $user, Request $request)
    {
        $this->model = $user;
        $this->request = $request;
    }

    public function index()
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable()
    {
        $users = $this->model->with(['access'])
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.access_id',
            ]);

        return DataTables::of($users)
            ->addColumn('checkbox', function ($item) {
                return view('panel.users.local.index.datatable.checkbox', compact('item'));
            })
            ->editColumn('id', function ($item) {
                return view('panel.users.local.index.datatable.id', compact('item'));
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at ? date('d/m/Y H:i:s', strtotime($item->created_at)) : 'Sem data';
            })
            ->editColumn('access.name', function ($item) {
                return view('panel.users.local.index.datatable.access', compact('item'));
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->addColumn('action', function ($item) {
                $loggedId = auth()->user()->id;

                return view('panel.users.local.index.datatable.action', compact('item', 'loggedId'));
            })
            ->make();
    }

    public function create()
    {
        $item = $this->model;

        return view('panel.users.local.index.modals.create', compact('item'));
    }

    public function store()
    {
        $data = $this->request->only([
            'photo',
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = Validator::make($data, [
            'photo' => 'image|mimes:jpeg,jpg,png|max:500|dimensions:max_width=250,max_height=250',
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
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

        return view('panel.users.local.index.modals.edit', compact("item"));
    }

    public function update($id)
    {
        $item = $this->model->find($id);

        if ($item) {
            $data = $this->request->only([
                'photo',
                'name',
                'email',
                'password',
                'password_confirmation',
            ]);

            $validator = Validator::make($data, [
                'photo' => 'image|mimes:jpeg,jpg,png|max:500|dimensions:max_width=220,max_height=220',
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:200'],
            ]);

            if ($item->email != $this->request->email) {
                $hasEmail = $this->model->where('email', $this->request->email)->get();

                if (count($hasEmail) == 0) {
                    $item->email = $this->request->email;
                } else {
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email',
                    ]));
                }
            }

            if (!empty($this->request->password)) {
                if (strlen($this->request->password) >= 4) {
                    if ($this->request->password === $this->request->password_confirmation) {
                        $data['password'] = Hash::make($this->request->password);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password',
                        ]));
                    }
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            } else {
                $data['password'] = $item->password;
            }

            if (count($validator->errors()) > 0) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]);
            }

            if ($this->request->hasFile('photo')) {
                if ($item->photo) {
                    $file_path_photo = public_path('storage\\') . $item->photo;

                    if (file_exists($file_path_photo) && $item->photo != "avatars/default.png") {
                        unlink($file_path_photo);
                    }
                }

                $data["photo"] = $this->request->file('photo')->store('avatars');
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

        return view('panel.users.local.index.modals.delete', compact("item"));
    }

    public function destroy()
    {
        $item = $this->model->find($this->request->id);

        if ($item) {
            $file_path_photo = public_path('storage/') . $item->photo;

            if (file_exists($file_path_photo)) {
                unlink($file_path_photo);
            }

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

        return view('panel.users.local.index.modals.remove-all', compact("itens"));
    }

    public function destroyAll()
    {

        foreach (session()->get('ids') as $item) {
            $item = $this->model->find($item["id"]);

            if ($item) {
                $file_path_photo = public_path('storage/') . $item->photo;

                if (file_exists($file_path_photo)) {
                    unlink($file_path_photo);
                }

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

    public function removeImage()
    {
        $item = $this->model->find($this->request->id);

        if ($item) {
            if ($item->photo && $item->photo != 'avatars/default.png') {

                $file_path_photo = public_path('storage/') . $item->photo;

                if (file_exists($file_path_photo)) {
                    unlink($file_path_photo);
                    $item->photo = 'avatars/default.png';
                    $item->save();

                    echo json_encode(true);
                }
            } else {
                echo json_encode('Os dados não foram encontrados!');
            }
        } else {
            echo json_encode('Os dados não foram encontrados!');
        }
    }
}
