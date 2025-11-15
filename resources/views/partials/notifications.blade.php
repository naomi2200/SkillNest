@if(session('status'))
    <div class="mb-6 rounded-lg border border-success/20 bg-success/10 px-4 py-3 text-sm text-success">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
        <ul class="list-disc space-y-1 pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
