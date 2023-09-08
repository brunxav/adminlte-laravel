<?php

use App\Http\Controllers\Site\MainController as SiteMain;
use App\Http\Controllers\System\MainController as SystemMain;
use App\Http\Controllers\Panel\MainController as PanelMain;
use App\Http\Controllers\Panel\AccessController;
use App\Http\Controllers\Panel\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

# Insert Global Variables
View::composer("*", function ($view) {
    $routeCurrent   =   Route::getCurrentRoute();
    $titleBreadCrumb =   isset($routeCurrent->wheres["titleBreadCrumb"]) ? $routeCurrent->wheres["titleBreadCrumb"] : 'Sem título BreadCrumb';
    $title =   isset($routeCurrent->wheres["title"]) ? $routeCurrent->wheres["title"] : 'Sem título';
    $routeActive    =   Route::currentRouteName();
    $route          =   explode('.', $routeActive);
    $routeAmbient   =   $route[0] ?? null;
    $routeCrud      =   $route[1] ?? null;
    $routeMethod    =   $route[2] ?? null;

    $view
        ->with('routeCurrent', $routeCurrent)
        ->with('routeActive', $routeActive)
        ->with('route', $route)
        ->with('routeAmbient', $routeAmbient)
        ->with('routeCrud', $routeCrud)
        ->with('routeMethod', $routeMethod)
        ->with('titleBreadCrumb', $titleBreadCrumb)
        ->with('title', $title);
});

Auth::routes();

Route::get('/teste', function () {
    return storage_path();
});

Route::name('site.')->group(function () {
    Route::name('main.')->group(function () {
        Route::get('/', [SiteMain::class, 'index'])->name('index');
    });
});

Route::name('system.')->group(function () {
    Route::name('main.')->group(function () {
        Route::get('/system', [SystemMain::class, 'index'])->name('index');
    });
});

Route::middleware('auth')->name('panel.')->group(function () {
    Route::name('main.')->group(function () {
        Route::get('/painel-de-controle', [PanelMain::class, 'index'])
            ->name('index')
            ->setWheres([
                'titleBreadCrumb'   => 'Dashboard',
                'title'   => 'Dashboard | Adminlte',
            ]);
    });

    Route::name('accesses.')->group(function () {
        Route::get('/accesses', [AccessController::class, 'index'])
            ->name('index')
            ->setWheres([
                'titleBreadCrumb'   => 'Lista de Acessos',
                'title'   => 'Lista de Acessos | Adminlte',
            ]);

        Route::get('/accesses/loadDatatable', [AccessController::class, 'loadDatatable'])->name('loadDatatable');

        Route::post('/accesses/store', [AccessController::class, 'store'])
            ->name('store')
            ->setWheres([
                'titleBreadCrumb'   => 'Cadastrar acesso'
            ]);

        // Post por causa do envio da imagem via ajax
        Route::put('/accesses/update/{id}', [AccessController::class, 'update'])
            ->name('update')
            ->setWheres([
                'titleBreadCrumb'   => 'Editar acesso'
            ]);

        Route::delete('/accesses/destroy/{id}', [AccessController::class, 'destroy'])
            ->name('destroy')
            ->setWheres([
                'titleBreadCrumb'   => 'Deletar acessos'
            ]);

        Route::delete('/accesses/destroyAll', [AccessController::class, 'destroyAll'])
            ->name('destroyAll');

        Route::post('/accesses/removeImage', [AccessController::class, 'removeImage'])
            ->name('removeImage');

        Route::get('/accesses/duplicate/{id}', [AccessController::class, 'duplicate'])
            ->name('duplicate');

        // Modais
        Route::get('/accesses/create', [AccessController::class, 'create'])
            ->name('create')
            ->setWheres([
                'titleBreadCrumb'   => 'Cadastrar acesso'
            ]);

        Route::get('/accesses/delete/{id}', [AccessController::class, 'delete'])
            ->name('delete')
            ->setWheres([
                'titleBreadCrumb'   => 'Deletar acesso'
            ]);

        Route::get('/accesses/edit/{id}', [AccessController::class, 'edit'])
            ->name('edit')
            ->setWheres([
                'titleBreadCrumb'   => 'Dados do acesso'
            ]);

        Route::post('/accesses/deleteAll', [AccessController::class, 'deleteAll'])
            ->name('deleteAll');
    });

    Route::name('users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->name('index')
            ->setWheres([
                'titleBreadCrumb'   => 'Lista de Usuários',
                'title'   => 'Lista de Usuários | Adminlte',
            ]);

        Route::get('/users/loadDatatable', [UserController::class, 'loadDatatable'])->name('loadDatatable');

        Route::post('/users/store', [UserController::class, 'store'])
            ->name('store')
            ->setWheres([
                'titleBreadCrumb'   => 'Cadastrar usuário'
            ]);

        // Post por causa do envio da imagem via ajax
        Route::post('/users/update/{id}', [UserController::class, 'update'])
            ->name('update')
            ->setWheres([
                'titleBreadCrumb'   => 'Editar usuário'
            ]);

        Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])
            ->name('destroy')
            ->setWheres([
                'titleBreadCrumb'   => 'Deletar usuários'
            ]);

        Route::delete('/users/destroyAll', [UserController::class, 'destroyAll'])
            ->name('destroyAll');

        Route::post('/users/removeImage', [UserController::class, 'removeImage'])
            ->name('removeImage');

        // Modais
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('create')
            ->setWheres([
                'titleBreadCrumb'   => 'Cadastrar usuário'
            ]);

        Route::get('/users/delete/{id}', [UserController::class, 'delete'])
            ->name('delete')
            ->setWheres([
                'titleBreadCrumb'   => 'Deletar usuário'
            ]);

        Route::get('/users/edit/{id}', [UserController::class, 'edit'])
            ->name('edit')
            ->setWheres([
                'titleBreadCrumb'   => 'Dados do usuário'
            ]);

        Route::post('/users/deleteAll', [UserController::class, 'deleteAll'])
            ->name('deleteAll');
    });
});
