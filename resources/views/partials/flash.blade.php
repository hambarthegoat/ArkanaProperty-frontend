@if (session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold flex items-start gap-3" role="status">
        <i data-lucide="check-circle-2" class="size-5 shrink-0"></i>
        <div>{!! nl2br(e(session('success'))) !!}</div>
    </div>
@endif
@if (session('error'))
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex items-start gap-3" role="alert">
        <i data-lucide="alert-circle" class="size-5 shrink-0"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold" role="alert">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
