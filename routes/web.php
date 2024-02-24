<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// NAVEGAÇÃO
Route::get('/', [NavigationController::class, 'index'])->name('index'); //página Home

Route::get('/#about', function () {
    // Lógica de controle, se necessário
})->name('about'); //página Sobre

// Route::get('/#home', function () {
//     // Lógica de controle, se necessário
// })->name('home'); //página Sobre

Route::get('/#project', function () {
    // Lógica de controle, se necessário
})->name('project'); //página Sobre

Route::get('/#contact', function () {
    // Lógica de controle, se necessário
})->name('contact'); //página Sobre

Route::get('/#servicos', function () {
    // Lógica de controle, se necessário
})->name('services'); //página Sobre

Route::get('/pagina-nao-encontrada', [NavigationController::class, 'page_not_found'])->name('page_not_found'); //página Sobre
Route::post('/send-contact', [UserController::class, 'SendContact'])->name('user.send_contact');//Enviar mensagem


//USUARIO NÃO LOGADO
Route::group(['middleware' => 'guest'], function () {
    // Login
    Route::get('/login', [NavigationController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login');

    // Criar conta
    Route::get('/register', [NavigationController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'createAccount'])->name('register');
});



//USUARIO LOGADO
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');//sair da conta

    Route::post('/delete-account/{id}', [UserController::class, 'deleteAccount'])->name('user.delete');//deletar conta
    Route::get('/edit', [NavigationController::class, 'edit'])->name('account.edit');//usuário logado apaga sua conta
    Route::post('/update-account', [UserController::class, 'updateAccount'])->name('account.update');//usuário logado apaga sua conta
    Route::post('/update-img', [UserController::class, 'updateImgAccount'])->name('account.update_img');//usuário logado apaga sua conta


    // 
    Route::get('/team/{team_code}', [UserController::class, 'team'])->name('team');//turma especifica
    Route::get('/teams', [UserController::class, 'teams'])->name('teams');//todas as turmas
    Route::post('/team/send-message', [UserController::class, 'messageTeam'])->name('team.message');//envia mensagem na turma
    Route::post('/team/update-message', [UserController::class, 'updateMessage'])->name('message.update');//edita mensagem da turma
    Route::post('/team/enter', [UserController::class, 'enterTeam'])->name('team.enter');//entrar na turma
    Route::post('/delete-message/{id_message_team}', [UserController::class, 'deleteMessage'])->name('message.delete');//APAGAR MENSAGEM

    // SÓ ADMIN PODE ACESSAR
    Route::middleware('admin')->group(function () {
        //listagem de usuário
        Route::get('/list-admins', [AdminController::class, 'listAdmins'])->name('admin.list_admins');//LISTAR ADMINS
        Route::get('/list-students', [AdminController::class, 'listStudents'])->name('admin.list_students');//LISTAR ALUNOS
        Route::get('/create-admin', [NavigationController::class, 'create_admin'])->name('admin.create');//VIEW CRIAR ADMIN
        Route::post('/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create');//CRIAR ADMIN
       
        Route::get('/search-admin', [AdminController::class, 'searchAdmin'])->name('admin.search_admin'); //Pesquisa admin
        Route::get('/search-student', [AdminController::class, 'searchStudent'])->name('admin.search_student'); //Pesquisa admin

        // TURMA
        Route::get('/create-team', [NavigationController::class, 'create_team'])->name('admin.create_team');//VIEW CRIAR TURMA
        Route::post('/create-team', [AdminController::class, 'createTeam'])->name('admin.create_team');//CRIAR TURMA
        Route::post('/delete-team/{id_team}', [AdminController::class, 'deleteTeam'])->name('team.delete');//APAGAR TURMA
        Route::get('/edit-team/{id_team}', [AdminController::class, 'edit_team'])->name('team.edit');//VIEW EDITAR TURMA
        Route::post('/edit-team', [AdminController::class, 'editTeam'])->name('team.edit');//EDITAR TURMA

        
        Route::post('/switch-to-administrator/{id}', [AdminController::class, 'switch_to_administrator'])->name('admin.switch_to_administrator');//MUDAR CADASTRO PARA ADMIN
        Route::post('/switch-to-student/{id}', [AdminController::class, 'switch_to_student'])->name('admin.switch_to_student');//MUDAR CADASTRO PARA USUARIO COMUM

        // MENSAGEM
        
        Route::post('/remove-user/{id}', [AdminController::class, 'removeUserTeam'])->name('team.remove_user');//APAGAR MENSAGEM
        Route::get('/contact', [AdminController::class, 'viewContact'])->name('admin.contact');//APAGAR MENSAGEM
        Route::post('/contact-admin/delete-contact/{id_contact}', [AdminController::class, 'deleteContact'])->name('contact.delete');//apaga mensagem de contato
    });
});



Route::get('/{username}', [UserController::class, 'viewAccount'])->name('account');//visualizar da conta