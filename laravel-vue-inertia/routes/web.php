<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');

    Route::get('/users', function () {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where("name", "LIKE", "%{$search}%");
                })
                ->orderByDesc('id')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'editable' => Auth::user()->can('edit', $user),
                ]),
            'filters' => Request::only(['search']),
            'can' => [
                'canCreateUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    })->name('users.index');

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->name('users.create')->can('create', User::class);

    Route::post('/users/store', function () {
        $user = Request::validate([
            'name' => ['required', 'max:50', 'string'],
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'max:14', 'string'],
        ]);

        User::create($user);

        return to_route('users.index');
    });

    Route::get('/users/edit', function () {
        return Inertia::render('Users/Edit');
    })->name('users.edit');

    Route::put('/users/update', function () {
        $user = Request::validate([
            'name' => ['required', 'max:50', 'string'],
            'email' => ['required', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'max:14', 'string'],
        ]);

        User::create($user);

        return to_route('users.index');
    });

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
});
