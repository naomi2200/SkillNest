@php
    /**
     * Vista legacy deshabilitada: siempre redirige al editor principal.
     * Mantiene compatibilidad si alguna ruta antigua llega aqui.
     */
    return redirect()->route('cursos.editor', $curso);
@endphp
