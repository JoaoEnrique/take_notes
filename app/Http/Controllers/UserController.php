<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Team;
use App\Models\MessageTeam;
use App\Models\FileMessage;
use App\Models\UserTeam;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use App\Models\Hospedagem;



class UserController extends Controller
{
    //  Verifica se está na hospedagem para mudar caminhos das imagens no banco
    public $hospedagemModel;
    public $isHospedagem;

    public function __construct(){
        // Atribua os valores das propriedades no construtor da classe.
        $this->hospedagemModel = new Hospedagem();
        $this->isHospedagem = $this->hospedagemModel->isHospedagem();
    }

    // VERIFICA SE É ADMIN
    public function isAdmin($id_user){
        $admin = Admin::where('id_user', $id_user)->get()->count();
        return $admin;
    }

    // CRIA USUÁRIO - Aluno
    public function createAccount(Request $request){
        try{
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
            
            $student = Student::create([
                'id_user' => $user->id,
            ]);

            // Loga usuário
            if (Auth::attempt($dados, $request->filled('remember'))) {
                $request->session()->regenerate();
                return redirect()->route('teams')->with('success', 'Conta criada! Você está logado(a)');
            }

        }catch(Exception $e){
            return redirect()->route('login')->with('danger', 'Não foi possível criar sua conta. Tente novamente mais tarde');
        }
    }

    // ABRIR CONTA
    public function viewAccount($user_name){
        $user = User::where('username', $user_name)->get()->first();

        if($user){
            return view('user.account', compact('user'));
        }

        return redirect()->route('page_not_found');
    }
    
    // ATUALIZAR CONTA
    public function updateAccount(Request $request){
        try{
            // validar dados
            $dados = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(auth()->id())],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = User::where('username', $request->username)->get()->first();

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Se estiver hospedado
            if($this->isHospedagem){
                return redirect('/' . $user->username)->with('success', 'Conta atualizada com sucesso!');
            }else{// Se não estiver hospedado
                return redirect('/' . $user->username)->with('success', 'Conta atualizada com sucesso!');
            }
        }catch(Exception $e){
            return redirect('/' . $user->username)->with('danger', 'Não foi possivel atualizar conta! Tente novamente mais tarde');
        }
    }

    //APAGAR CONTA 
    public function deleteAccount($id){
        try{
            $id_user_logged =  auth()->user()->id; //id do usuario logado

            //Verifica se é admin ou student
            $student = Student::where('id_user', $id)->first();
            $cont_admins = Admin::get()->count();
            $admin = Admin::where('id_user', $id)->first();
            
            // verifica se é aluno ou admin e apaga
            if($admin){
                if($cont_admins >=2){
                    $admin->delete();
                }else{
                    return redirect()->route('admin.list_admins')->with('danger', 'Você precisa deixar no mínimo 1 administrador');
                }
                
            }else{
                if($student){
                    $student->delete();
                }
            }

            // remove usuario das turmas
            $users_teams = UserTeam::where('id_user', $id)->get();
            foreach($users_teams as $user_team){
                $user_team->delete();
            }

            $user = User::find($id); //APAGA USUÁRIO
            if($user){
                $user->delete();
            }

            //pega caminho da imagem do quiz
            if($this->isHospedagem){ //se estiver na hospedagem
                $img_user_Path = public_path('../img/img_account/' . $id . '.png'); //pega caminho da imagem hospedagem (img/img_account)
            }else{//se não estiver na hospedagem
                $img_user_Path = public_path('img/img_account/' . $id . '.png'); //pega caminho da imagem localhost (public/img/img_account)
            }

            //verifica se tem imagem
            if (file_exists($img_user_Path)) {
                unlink($img_user_Path); // Remove o arquivo
            }
    
            // Caso o usuário logado apague a propria conta
            if($id_user_logged == $id){
                return redirect()->route('login')->with('success', 'Sua conta foi excluida');
            }
            
            // Caso um Admin apague um aluno ou outro admin
            if($admin){ // se for admin
                return redirect()->route('admin.list_admins')->with('success', 'A conta do administrador foi deletada');
            }else{ //se for aluno
                return redirect()->route('admin.list_students')->with('success', 'A conta do usuário foi deletada');
            }

        }catch(Exception $e){
            return redirect()->route('admin.list_admins')->with('danger', 'Não foi possivel apagar conta');
        }
    }

    // FAZER LOGIN
    public function login(Request $request) {
        // validar dados
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Loga usuário
        if (Auth::attempt($dados, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('teams'))->with('success', 'Você está logado(a) e consegue ver todas as turmas abaixo');
        }
    
        //email ou senha errado
        return back()->withErrors(['password' => 'O email e/ou senha são inválidos'])->withInput();
    }

    // SAIR DA CONTA
    public function logout(Request $request){
        Auth::logout(); //sai da conta

        //remove sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Você saiu da sua conta');
    }

    // ATUALIZAR CONTA
    public function updateImgAccount(Request $request){

        $request->validate([
            'img' => ['required']
        ]);

        $user = User::find(auth()->user()->id); //usuario logado

        // CASO TENHA IMAGEM NO POST
        if($request->hasFile('img') ){
            if($request->file('img')->isValid()){
                $img = $request->img; //imagem do usuario
                $imgName = auth()->user()->id . ".png"; //nome da imagem (id_user.png)

                if($this->isHospedagem){ //se estiver na hospedagem
                    $path = public_path('../img/img_account'); //caminho para salvar imagem hospedagem (img/img_account)
                }else{//se não estiver na hospedagem
                    $path = public_path('img/img_account'); //caminho para salvar imagem localhost (public/img/img_account)
                }

                $request->img->move($path, $imgName); //salva imagem

                //atualiza caminho da imagem no banco
                $user->update([
                    'img' => "img/img_account/" . $imgName,
                ]);

                return redirect('/' . $user->username)->with('success', 'Imagem alterada com sucesso!');
            }else{
                return redirect('/' . $user->username)->with('danger', 'Erro ao alterar imagem! Tente novamente mais tarde');
            }
        }
            // return redirect()->route('account.edit')->with('danger-img', 'Clique na sua imagem abaixo para trocar a foto de perfil');
    }

    //todas as turmas
    public function teams(){
        if($this->isAdmin(auth()->user()->id)){
            $teams = Team::get()->all();
        }else{
            $teams = Team::select('teams.*', 'users_teams.*')
            ->where('users_teams.id_user', auth()->user()->id)
            ->join('users_teams', 'teams.id_teams', '=', 'users_teams.id_team')
            ->get();
        }
        return view('user.teams', ['teams' => $teams]);
    }

    //entrar na turma
    public function enterTeam(Request $request){
        try{
            $request->validate([
                'team_code' => ['required']
            ]);

            $team = Team::where('team_code', $request->team_code)->get()->first();


            // Código da turma invalido
            if(!$team){
                return back()->withErrors(['team_code' => 'O código da turma não é valido'])->withInput();
            }

            $user_team = UserTeam::where('id_user', auth()->user()->id)->where('id_team', $team->id_teams)->get()->first();

            if($user_team){
                return redirect()->intended(route('teams'))->with('warning', 'Você já está nessa turma');
            }

            $user_team = UserTeam::create([
                'id_user' => auth()->user()->id,
                'id_team' => $team->id_teams,
            ]);

            return redirect()->intended(route('teams'))->with('success', 'Você entrou na turma');
        }catch(Exception $e){
            return redirect()->intended(route('teams'))->with('danger', 'Não foi possível entrar na turma! Talvez ela tenha sido excluida');
        }
    }

    //abrir team
    public function team($team_code){
        $team = Team::where('team_code', $team_code)->get()->first();

        // 404
        if(!$team){
            return view('errors.404_team');
        }

        $messages = MessageTeam::
            join('users', 'messages_team.id_user', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.username', 'users.img_account', 'messages_team.*')
            ->where('messages_team.id_team', $team->id_teams)
            ->orderBy('messages_team.created_at', 'desc') // Adicione esta linha para ordenar por created_at em ordem decrescente
            ->get();
            

        return view('user.team', ['team' => $team, 'messages' => $messages]);
    }

    public function getFilesByIdMessage($id_message_team){
        return FileMessage::where('id_message_team', $id_message_team)->get();
    }

    //enviar mensagem para a turma
    public function messageTeam(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'img' => 'nullable|mimes:jpeg,png,gif,jpg', // Aceita somente JPEG, PNG e GIF se um arquivo for enviado
                'video' => 'nullable|mimes:mp4,webm',
                'file' => 'nullable|mimes:pdf,docx,doc,txt',
                'message' => 'required_if:file,NULL,video,NULL,img,NULL', // Img é obrigatório se ambos file e texto estiverem vazios
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $message = MessageTeam::create([
                'id_user' => auth()->user()->id,
                'id_team' => $request->id_team,
                'text' => $request->message,
            ]);

            // CASO TENHA IMAGEM 
            if($request->hasFile('img') ){
                if($request->file('img')->isValid()){
                    $img = $request->img; //pega imagem do campo
                    $imgName = $message->id_message_team . ".png"; //nome para salvar imagem (id_quiz.png)

                    if($this->isHospedagem){
                        $path = public_path('../img/file_messages'); //caminho para salvar imagem hospedagem (img/img_quiz)
                    }else{
                        $path = public_path('img/file_messages'); //caminho para salvar imagem localhost (public/img/img_quiz)
                    }

                    $request->img->move($path, $imgName);//salva imagem
                    $img_path =  "img/file_messages/" . $imgName;//caminho para salvar no banco

                    FileMessage::create([
                        'id_message_team' => $message->id_message_team,
                        'type_file' => 1,
                        'path_file' => $img_path,
                    ]);

                //erro na imagem
                }else{
                    return redirect('/' . auth()->user()->user_name)->with('danger', 'Não foi possível alterar imagem!');
                }
            }

            // CASO TENHA VIDEO 
            if($request->hasFile('video') ){
                if($request->file('video')->isValid()){
                    $video = $request->video; //pega imagem do campo
                    $videoName = $message->id_message_team . ".mp4"; //nome para salvar imagem (id_quiz.png)
                    
                    if($this->isHospedagem){
                        $path = public_path('../img/file_messages'); //caminho para salvar imagem hospedagem (img/img_quiz)
                    }else{
                        $path = public_path('img/file_messages'); //caminho para salvar imagem localhost (public/img/img_quiz)
                    }

                    $request->video->move($path, $videoName);//salva imagem
                    $video_path =  "img/file_messages/" . $videoName;//caminho para salvar no banco

                    FileMessage::create([
                        'id_message_team' => $message->id_message_team,
                        'type_file' => 2,
                        'path_file' => $video_path,
                    ]);

                //erro na imagem
                }else{
                    return redirect('/' . auth()->user()->user_name)->with('danger', 'Não foi possível alterar imagem!');
                }
            }

            // CASO TENHA VIDEO 
            if($request->hasFile('file') ){
                if($request->file('file')->isValid()){
                    $file = $request->file; //pega imagem do campo
                    $extensao = $file->extension(); //pega imagem do campo
                    $originalName = $file->getClientOriginalName(); // Pega o nome original do arquivo
                    $fileName = "$message->id_message_team.$extensao"; //nome para salvar imagem (id_quiz.png)
                    
                    if($this->isHospedagem){
                        $path = public_path('../img/file_messages'); //caminho para salvar imagem hospedagem (img/img_quiz)
                    }else{
                        $path = public_path('img/file_messages'); //caminho para salvar imagem localhost (public/img/img_quiz)
                    }

                    $request->file->move($path, $fileName);//salva imagem
                    $file_path =  "img/file_messages/" . $fileName;//caminho para salvar no banco

                    FileMessage::create([
                        'id_message_team' => $message->id_message_team,
                        'type_file' => 3,
                        'file_name' => $originalName,
                        'path_file' => $file_path,
                    ]);

                //erro na imagem
                }else{
                    return redirect('/' . auth()->user()->user_name)->with('danger', 'Não foi possível alterar imagem!');
                }
            }

            // return $request;

            return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('danger', 'Não foi possivel enviar mensagem. Tente novamente mais tarde');
        }
    }

    //atualizar mensagem da turma
    public function updateMessage(Request $request){
        try{
            $dados = $request->validate([
                'message' => ['required'],
            ]);

            $message = MessageTeam::where('id_message_team', $request->id_message_team)->get()->first();

            $message ->update([
                'text' => $request->message,
            ]);

            return redirect()->back()->with('success', 'Mensagem atualizada');
        }catch(Exception $e){
            return redirect()->back()->with('danger', 'Não foi possivel atualizar mensagem. Tente novamente mais tarde');
        }
    }

    //apagar mensagem da turma
    public function deleteMessage($id_message_team){
        try{
            $files = FileMessage::where('id_message_team', $id_message_team)->get()->all();

            foreach($files as $file){
                $file->delete();

                //pega caminho do arquivo
                $path_file = public_path($file->path_file); //pega caminho da imagem localhost (public/img/img_account)
                //$img_user_Path = public_path('../img/img_account/' . $id . '.png'); //pega caminho da imagem hospedagem (img/img_account)

                //verifica se tem imagem
                if (file_exists($path_file)) {
                    unlink($path_file); // Remove o arquivo
                }

            }

            $message = MessageTeam::where('id_message_team', $id_message_team)->get()->first()->delete();

            return redirect()->back()->with('success', 'Mensagem apagada');
        }catch(Exception $e){
            return redirect()->back()->with('danger', 'Não foi possivel apagar mensagem. Tente novamente mais tarde');
        }
    }

    // Enviar mensagem de contato
    public function SendContact(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:13',],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Mensagen enviada com sucesso');
    }
}
