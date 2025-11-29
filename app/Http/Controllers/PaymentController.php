<?php

namespace App\Http\Controllers;

use App\Models\Mentoria;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Muestra el formulario de pago para una mentoría aceptada del estudiante autenticado.
     */
    public function show(Mentoria $mentoria)
    {
        abort_unless(auth()->id() === $mentoria->estudiante_id, 403);

        if ($mentoria->payment_status === 'paid') {
            return redirect()
                ->route('student.mentorias')
                ->with('status', 'Esta mentoría ya fue pagada.');
        }

        if ($mentoria->estado === 'rechazada') {
            return redirect()
                ->route('student.mentorias')
                ->with('error', 'Esta mentoría fue rechazada por el mentor.');
        }

        if ($mentoria->estado !== 'aceptada') {
            return redirect()
                ->route('student.mentorias')
                ->with('status', 'La mentoría debe ser aceptada antes de pagar.');
        }

        $mentoria->loadMissing('mentor');
        $monto = $mentoria->monto ?? $mentoria->precio ?? 0;

        return view('payments.pay', compact('mentoria', 'monto'));
    }

    /**
     * Registra el pago simulado y marca la mentoría como pagada.
     */
    public function store(Request $request, Mentoria $mentoria)
    {
        abort_unless(auth()->id() === $mentoria->estudiante_id, 403);
        $mentoria->loadMissing('mentor');

        if ($mentoria->payment_status === 'paid') {
            return redirect()
                ->route('student.mentorias')
                ->with('status', 'Esta mentoría ya fue pagada anteriormente.');
        }

        if ($mentoria->estado === 'rechazada') {
            return redirect()
                ->route('student.mentorias')
                ->with('error', 'Esta mentoría fue rechazada por el mentor.');
        }

        if ($mentoria->estado !== 'aceptada') {
            return redirect()
                ->route('student.mentorias')
                ->with('status', 'Esta mentoría aún no está lista para el pago.');
        }

        $data = $request->validate([
            'metodo' => ['required', 'in:yape,plin,tarjeta'],
            'comprobante' => [
                Rule::requiredIf(in_array($request->metodo, ['yape', 'plin'], true)),
                'sometimes',
                'file',
                'image',
                'max:4096',
            ],
            'numero_tarjeta' => [
                Rule::requiredIf($request->metodo === 'tarjeta'),
                'nullable',
                'digits:16',
            ],
        ]);
        try {
            $receiptPath = null;
            if ($request->hasFile('comprobante') && in_array($data['metodo'], ['yape', 'plin'], true)) {
                $receiptPath = $request->file('comprobante')->store('payment_receipts', 'public');
            }

            $monto = $mentoria->monto ?? $mentoria->precio ?? 0;
            $mentorShare = round($monto * 0.95, 2);
            $platformShare = round($monto - $mentorShare, 2);

            $sessionLink = 'https://meet.jit.si/skillnest-mentoria-' . $mentoria->id;

            $mentoria->update([
                'estado' => 'pagada',
                'payment_status' => 'paid',
                'link_pago' => 'simulado-' . now()->timestamp,
                'jitsi_room' => $sessionLink,
                'link_sesion' => $sessionLink,
            ]);

            PaymentLog::create([
                'mentoria_id' => $mentoria->id,
                'estudiante_id' => $mentoria->estudiante_id,
                'mentor_id' => $mentoria->mentor_id,
                'monto_total' => $monto,
                'monto_mentor' => $mentorShare,
                'monto_plataforma' => $platformShare,
                'metodo' => $data['metodo'],
                'referencia' => $receiptPath
                    ? 'comprobante:' . $receiptPath
                    : ($data['metodo'] === 'tarjeta' ? 'tarjeta:' . substr($data['numero_tarjeta'], -4) : null),
            ]);

            return redirect()
                ->route('mentorias.payment.show', $mentoria->id)
                ->with('status', 'Pago registrado correctamente.');
        } catch (\Throwable $th) {
            report($th);

            return back()
                ->withInput()
                ->withErrors(['metodo' => 'Ocurrió un problema al registrar el pago. Inténtalo nuevamente.']);
        }
    }
}
