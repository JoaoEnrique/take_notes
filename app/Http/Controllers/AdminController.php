<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use App\Models\Team;
use App\Models\MessageTeam;
use App\Models\UserTeam;
use App\Models\Contact;
use App\Models\FileMessage;
use App\Models\Hospedagem;

class AdminController extends Controller
{
    //  Verifica se está na hospedagem para mudar caminhos das imagens no banco
    public $hospedagemModel;
    public $isHospedagem;

    public function __construct()
    {
        // Atribua os valores das propriedades no construtor da classe.
        $this->hospedagemModel = new Hospedagem();
        $this->isHospedagem = $this->hospedagemModel->isHospedagem();
    }

    // CRIA USUÁRIO - ADMIN
    public function createAdmin(Request $request){
        // validar dados
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img_account' => 'img/img_account/img_account.png',
            'active' => '1',
        ]);

        $admin = Admin::create([
            'id_user' => $user->id,
        ]);

        if($admin){
            return redirect()->route('admin.list_admins')->with('success', 'Administrador criado');
        }
    }

    // VERIFICA SE É ADMIN
    public function isAdmin($id_user){
        $admin = Admin::where('id_user', $id_user)->get()->count();
        return $admin;
    }

    public function view_users_teams($id_team){
        $teams = Team::join('users_teams', 'teams.id_teams', '=', 'users_teams.id_team')
            ->join('users', 'users_teams.id_user', '=', 'users.id')
            ->select('users.*', 'users_teams.*')
            ->where('id_team', $id_team)
            ->get();

        return $teams;
    }

    // LISTAR ADMINS
    public function listAdmins(){
        // $admins = User::select('users.id', 'users.name', 'users.username', 'users.email', 'users.img_account')
        //     ->join('admins', 'users.id', '=', 'admins.id_user')
        //     ->get();

            $admins = User::join('admins', 'users.id', '=', 'admins.id_user')
            ->select('users.*') // Seleciona todas as colunas da tabela 'users'
            ->get();
        return view('admin.list_admins', ['admins' => $admins]);
    }

    // LISTAR ALUNOS
    public function listStudents(){
        $students = User::select('users.id', 'users.name', 'users.username', 'users.email', 'users.img_account')
            ->join('students', 'users.id', '=', 'students.id_user')
            ->get();
        return view('admin.list_students', ['students' => $students]);
    }

    public function createTeam(Request $request){
        // validar dados
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $team_code = $this->generateRandomCode(6);// Gera código aleatorio com 6 digitos (A-Z - 0-9)
        $team = Team::where('team_code', $team_code)->get()->count();

        while($team){
            $team_code = $this->generateRandomCode(6);// Gera código aleatorio com 6 digitos (A-Z - 0-9)
        }

        $team = Team::create([
            'id_user' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'team_code' => $team_code,
            'closed' => $request->closed,
            'color' => $request->color,
        ]);

        return redirect()->route('teams')->with('success', 'Turma criada');
    }


    // Gera código aleatorio com 6 digitos (A-Z - 0-9)
    public function generateRandomCode($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $code;
    }
    
    

    public function deleteTeam($id_team){
        $team = Team::where('id_teams', $id_team)->get()->first();
        $messages = MessageTeam::where('id_team', $id_team)->get()->all();
        $users_team = UserTeam::where('id_team', $id_team)->get()->all();
        
        foreach($users_team as $user_team){
            $user_team->delete();
        }

        foreach($messages as $message){
            $files = FileMessage::where('id_message_team', $message->id_message_team)->get()->all();

            foreach($files as $file){
                $file->delete();

                if($this->isHospedagem){
                    $img_user_Path = public_path('../img/img_account/' . $id . '.png'); //pega caminho da imagem hospedagem (img/img_account)
                }else{
                    //pega caminho do arquivo
                    $path_file = public_path($file->path_file); //pega caminho da imagem localhost (public/img/img_account)
                }

                //verifica se tem imagem
                if (file_exists($path_file)) {
                    unlink($path_file); // Remove o arquivo
                }

            }

            $message->delete();

        }

        $team->delete();

        return redirect()->route('teams')->with('success', 'Turma excluida');
    }

    function edit_team($id_team){
        $team = Team::where('id_teams', $id_team)->get()->first();

        if($team){
            return view('admin.edit_teams', ['team' => $team]);
        }

        return view('errors.404');
    }

    public function editTeam(Request $request){
        // validar dados
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $team = Team::where('id_teams', $request->id_team)->get()->first();

        $team->update([
            'id_user' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'closed' => $request->closed,
            'color' => $request->color,
        ]);

        return redirect()->route('teams')->with('success', 'Turma atualizada');

    }

    public function count_users_teams($id_team){
        $count_users = UserTeam::where('id_team', $id_team)->get()->count();

        return $count_users;
    }

    public function switch_to_administrator($id){
        try{
            $user = User::where('id', $id)->get()->first();
            $student = Student::where('id_user', $id)->get()->first()->delete();
            $admin = Admin::create([
                'id_user' => $id
            ]);

            return redirect()->route('admin.list_admins')->with('success', $user->name . ' agora é administrador(a)');

        }catch(Exception $e){
            return redirect()->route('admin.list_admins')->with('danger', `Erro ao mudar $user->name para administrador(a). Tente novamente mais tarde`);
        }
    }

    public function switch_to_student($id){
        try{
            $user = User::where('id', $id)->get()->first();
            $admin = Admin::where('id_user', $id)->get()->first()->delete();
            $student = Student::create([
                'id_user' => $id
            ]);

            return redirect()->route('admin.list_students')->with('success', $user->name . ' agora é um usuário comum');

        }catch(Exception $e){
            return redirect()->route('admin.list_students')->with('danger', `Erro ao mudar $student->name para usuário comum. Tente novamente mais tarde`);
        }
    }

    public function searchAdmin(Request $request){
        $keyword = $request->input('query');

        $results = User::join('admins', 'users.id', '=', 'admins.id_user')
            ->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.username', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%');
            })
            ->select('users.*') // Seleciona todas as colunas da tabela 'users'
            ->get();
        return response()->json($results);

    }

    public function searchStudent(Request $request){
        $keyword = $request->input('query');

        $results = User::join('students', 'users.id', '=', 'students.id_user')
            ->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.username', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%');
            })
            ->select('users.*') // Seleciona todas as colunas da tabela 'users'
            ->get();
        return response()->json($results);

    }

    public function removeUserTeam(Request $request, $id){
        $user_team = UserTeam::where('id_user', $request->id_user)
        ->where('id_team', $request->id_team)->get()->first()->delete();

        return back()->with('success', 'O usuário foi removido da turma');
    }

    public function viewContact(){
        $contacts = Contact::all();
        return view('admin.contact', ['contacts' => $contacts]);
    }

    public function deleteContact($id_contact){
        $contact = Contact::where('id_contact', $id_contact)->first();


        if($contact){
            $contact->delete();
        }
        
        $contacts = Contact::all();
        return redirect()->route('admin.contact')->with('success', 'A mensagem foi apagada');
    }
}
