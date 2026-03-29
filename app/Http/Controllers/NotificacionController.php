<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $notificacion = Notificacion::where('user_id', Auth::id())
            ->findOrFail($id);

        $notificacion->leida = true;
        $notificacion->save();

        // Si tiene URL, redirigir allí; si no, volver atrás
        if ($notificacion->url) {
            return redirect($notificacion->url);
        }

        return redirect()->back();
    }

    public function marcarTodasLeidas()
    {
        Notificacion::where('user_id', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
