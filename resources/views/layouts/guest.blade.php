@extends('layouts.app')

@section('content')
    <div class="flex min-h-[80vh] items-center justify-center py-12">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-secondary">@yield('title')</h1>
                <p class="mt-2 text-sm text-slate-500">@yield('subtitle')</p>
            </div>

            <div class="card">
                @yield('form')
            </div>
        </div>
    </div>
@endsection
