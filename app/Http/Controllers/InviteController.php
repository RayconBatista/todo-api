<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('acceptInvite');
    }

    public function index()
    {
        return Invite::paginate(15);
    }

    public function generateInvite(Request $request)
    {
        $user = auth()->user(); // Obtém o usuário autenticado que está enviando o convite

        $invite = Invite::create([
            'user_id'       => $user->id,
            'token'         => Str::uuid(), // Gera um token único usando o helper Str::uuid()
            'email'         => $request->input('email'),
            'expires_at'    => Carbon::now()->addDays(7), // Define a expiração para 7 dias a partir de agora (ajuste conforme necessário)
            // 'expires_at'    => now()->addDays(7), // Define a expiração para 7 dias a partir de agora (ajuste conforme necessário)
        ]);

        // Chame uma função para enviar o e-mail com o link do convite
        // $this->sendInviteEmail($invite);
        Mail::to($request->user())->send(new InviteMail($invite));

        return response()->json([
            'success' => 'Convite enviado com sucesso!'
        ], 200);
        // return redirect()->back()->with('success', 'Convite enviado com sucesso!');
    }

    public function acceptInvite($token)
    {
        $invite = Invite::where('token', $token)
            ->where('expires_at', '>', Carbon::now()) // Certifique-se de que o convite ainda é válido
            ->where('is_used', false) // Certifique-se de que o convite não foi usado ainda
            ->first();

        if (!$invite) {
            return response()->json(['error' => 'Convite inválido'], 404);
        }
        $this->middleware('auth:api')->except('acceptInvite');
        $redirectUrl = 'http://localhost:5173/registro?invite_email=' . $invite->email;

        return redirect($redirectUrl);
    }
}
