@extends('layouts.app')

@section('title', 'Laravel Geospatial - Home')
@section('meta_description', 'A database-free Laravel geospatial web application for interactive point and line drawing on OpenStreetMap data.')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20 flex-grow flex flex-col justify-center">
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 items-start">
        
        <div class="lg:col-span-7 flex flex-col justify-center gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-[#0071e3] ring-1 ring-inset ring-blue-500/10">
                    Geospatial Visualization Engine
                </span>
            </div>

            <h2 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Laravel Geospatial Web App
            </h2>

            <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl">
                An interactive geographic information system (GIS) skeleton built to run completely serverless and database-free. The application fetches OpenStreetMap data layers dynamically over a client-side CDN using MapLibre GL JS, allowing seamless vector tile rendering. Users can toggle drawing modes to map coordinates, render lines, track current views, and manage geometry layers on the fly.
            </p>

            <div class="pt-2">
                <a href="{{ url('/map') }}" class="inline-flex items-center justify-center rounded-xl bg-[#0071e3] px-6 py-3.5 text-base font-bold text-white shadow-sm hover:bg-blue-600 transition-colors duration-200">
                    Launch Interactive Map
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            
            <div class="pt-4 border-t border-slate-100 mt-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Built With</span>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium">Laravel 11</span>
                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium">Tailwind CSS v4</span>
                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium">Vite v8</span>
                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium">MapLibre GL JS</span>
                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-xs font-medium">Vercel Serverless</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-4">Project Author</span>
            
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Created by:</h3>
            
            <div class="mt-2">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Aryo Wisanggeni
                </h1>
                <span class="block h-[3px] w-14 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full mt-2" />
            </div>

            <p class="mt-3 text-slate-800 text-lg font-semibold tracking-wide">
                Software Engineer
            </p>

            <p class="mt-3 text-slate-500 text-sm leading-relaxed">
                focused on building scalable systems, real-time applications, and AI-driven solutions.
            </p>

            <div class="grid grid-cols-3 gap-4 pt-5 mt-5 border-t border-slate-100">
                <div>
                    <span class="block text-xl font-bold text-slate-800 leading-none">3+</span>
                    <span class="block text-[10px] text-slate-400 mt-1 uppercase font-semibold">Years Exp</span>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800 leading-none">12+</span>
                    <span class="block text-[10px] text-slate-400 mt-1 uppercase font-semibold">Projects</span>
                </div>
                <div>
                    <span class="block text-xl font-bold text-slate-800 leading-none">GIS</span>
                    <span class="block text-[10px] text-slate-400 mt-1 uppercase font-semibold">Focus</span>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100 space-y-3.5">
                <div class="flex items-start gap-3">
                    <span class="text-slate-400 mt-0.5"><i class="fas fa-envelope text-sm"></i></span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Email</p>
                        <a href="mailto:arrrryow@gmail.com" class="text-xs text-slate-700 hover:text-[#0071e3] font-medium transition-colors">arrrryow@gmail.com</a>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-slate-400 mt-0.5"><i class="fas fa-map-marker-alt text-sm"></i></span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Location</p>
                        <p class="text-xs text-slate-700 font-medium">Jakarta, Indonesia | Bandung, Indonesia</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap gap-3">
                <a href="https://github.com/arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-white hover:bg-[#0071e3] transition-all duration-200 hover:scale-105 shadow-sm" title="GitHub">
                    <i class="fab fa-github text-sm"></i>
                </a>
                <a href="https://linkedin.com/in/arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0e76a8] text-white hover:bg-slate-900 transition-all duration-200 hover:scale-105 shadow-sm" title="LinkedIn">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
                <a href="mailto:arrrryow@gmail.com" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#ea4335] text-white hover:bg-slate-900 transition-all duration-200 hover:scale-105 shadow-sm" title="Email">
                    <i class="fas fa-envelope text-sm"></i>
                </a>
                <a href="https://instagram.com/arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#c13584] text-white hover:bg-slate-900 transition-all duration-200 hover:scale-105 shadow-sm" title="Instagram">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
                <a href="https://twitter.com/arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1da1f2] text-white hover:bg-slate-900 transition-all duration-200 hover:scale-105 shadow-sm" title="Twitter">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="https://medium.com/@arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-955 bg-slate-950 text-white hover:bg-[#0071e3] transition-all duration-200 hover:scale-105 shadow-sm" title="Medium">
                    <i class="fab fa-medium text-sm"></i>
                </a>
                <a href="https://kaggle.com/arrrryow" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#20beff] text-white hover:bg-slate-900 transition-all duration-200 hover:scale-105 shadow-sm" title="Kaggle">
                    <i class="fab fa-kaggle text-sm"></i>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
