<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'SkillNest') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E293B',
                        success: '#10B981',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                    },
                    boxShadow: {
                        card: '0 10px 25px rgba(15, 23, 42, 0.08)',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                },
            },
        }
    </script>
    <style>
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.5rem;
            background-color: #3B82F6;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 4px 6px rgba(15, 23, 42, 0.12);
        }
        .btn-primary:hover { background-color: #2563eb; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.15);
            background-color: #fff;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1E293B;
        }
        .btn-secondary:hover { background-color: rgba(15, 23, 42, 0.05); }

        .btn-gradient {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 999px;
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            padding: 0.5rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.35);
        }
        .btn-gradient:hover { filter: brightness(1.05); }

        .card {
            border-radius: 2rem;
            background-color: #fff;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="min-h-full font-sans text-slate-700 antialiased">
    <div class="flex min-h-screen flex-col">
        @include('partials.header')

        <div class="flex flex-1">
            @auth
                @hasSection('app-sidebar')
                    @yield('app-sidebar')
                @else
                    @include('partials.sidebar')
                @endif
            @endauth

            <main class="w-full flex-1 bg-slate-50 px-4 py-8 sm:px-6 lg:px-10">
                @include('partials.notifications')

                @yield('content')
            </main>
        </div>

        @include('partials.footer')
    </div>

    @stack('scripts')
</body>
</html>
