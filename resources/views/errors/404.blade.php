@extends('layouts.app')

@section('title', 'Page Not Found - 404')
@section('meta_description', 'The page you are looking for does not exist.')

@section('content')
<section class="flex items-center justify-center py-24 sm:py-32 flex-grow bg-white">
    <div class="mx-auto max-w-md px-4 text-center">
        <!-- 404 Display -->
        <span class="text-8xl sm:text-9xl font-black tracking-widest text-slate-200 select-none">
            404
        </span>
        
        <!-- Error description -->
        <h1 class="mt-6 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Coordinates Unknown
        </h1>
        <p class="mt-4 text-sm text-slate-500 leading-relaxed">
            The route you have requested does not exist in our geospatial grid. Please verify the URL or return to home base.
        </p>
        
        <!-- Return Button -->
        <div class="mt-10">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-xl bg-[#0071e3] px-6 py-3 text-sm font-bold text-white hover:bg-blue-600 transition-colors duration-200">
                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
