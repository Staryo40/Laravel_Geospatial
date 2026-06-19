@extends('layouts.app')

@section('title', 'Laravel Geospatial - Live Map')

@section('head')
<link href="https://unpkg.com/maplibre-gl@4.3.0/dist/maplibre-gl.css" rel="stylesheet" />
<style>
    .maplibregl-ctrl-attrib {
        background-color: rgba(255, 255, 255, 0.8) !important;
        color: #475569 !important;
        font-family: ui-sans-serif, system-ui, sans-serif !important;
        font-size: 10px !important;
    }
    .maplibregl-ctrl-attrib a {
        color: #0071e3 !important;
    }
    .maplibregl-popup-content {
        font-family: ui-sans-serif, system-ui, sans-serif !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        border: 1px solid #e2e8f0 !important;
        padding: 12px !important;
    }
    #floating-finish-btn.hidden {
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="relative flex flex-col md:flex-row flex-grow h-[calc(100vh-65px)] w-full overflow-hidden bg-slate-50">
    
    <!-- Sidebar / Bottom Drawer Control Panel -->
    <aside id="map-sidebar" class="absolute md:relative z-10 bottom-0 left-0 right-0 md:top-0 md:left-0 md:right-0 w-full md:w-80 lg:w-96 flex flex-col h-[45vh] md:h-full bg-white border-t md:border-t-0 md:border-b-0 md:border-r border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] md:shadow-none p-4 sm:p-6 transition-all duration-350 ease-in-out rounded-t-2xl md:rounded-none">
        
        <!-- Mobile Drawer Tap Action Text -->
        <div id="drawer-action-text" class="text-[9px] font-bold text-center uppercase tracking-widest text-slate-400 hover:text-[#0071e3] transition-colors md:hidden cursor-pointer mb-2.5 py-1 select-none">
            Tap to Hide Menu
        </div>

        <!-- Header -->
        <div id="drawer-header" class="mb-4 cursor-pointer md:cursor-default flex items-center justify-between md:block">
            <div>
                <h1 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    Live Map View
                </h1>
                <p class="text-[10px] text-slate-500 mt-0.5 md:block hidden">Draw points, lines, and polygons on the map viewport.</p>
            </div>
            <!-- Mobile Expand/Collapse Indicator -->
            <span id="drawer-toggle-icon" class="text-slate-400 md:hidden transition-transform duration-300">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </div>
        
        <hr class="border-slate-100 my-1 hidden md:block" />

        <!-- Control Group Box -->
        <div class="space-y-5 py-2 flex-grow overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-slate-200">
            <!-- Center Display -->
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Map Center</span>
                <div class="mt-1.5 grid grid-cols-2 gap-2 text-xs font-mono text-slate-700">
                    <div class="bg-slate-50 p-2 rounded-lg border border-slate-100">
                        <div class="text-[9px] text-slate-400 uppercase font-semibold">Longitude</div>
                        <div id="lng-display" class="font-bold text-slate-800">107.61912</div>
                    </div>
                    <div class="bg-slate-50 p-2 rounded-lg border border-slate-100">
                        <div class="text-[9px] text-slate-400 uppercase font-semibold">Latitude</div>
                        <div id="lat-display" class="font-bold text-slate-800">-6.91746</div>
                    </div>
                </div>
            </div>

            <!-- Color Selection Dropdown -->
            <div>
                <label for="color-picker" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Drawing Color</label>
                <div class="relative">
                    <select id="color-picker" class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 cursor-pointer appearance-none">
                        <option value="#0071e3" data-name="Blue">🔵 Apple Blue</option>
                        <option value="#ff3b30" data-name="Red">🔴 Red</option>
                        <option value="#34c759" data-name="Green">🟢 Green</option>
                        <option value="#ff9500" data-name="Orange">🟠 Orange</option>
                        <option value="#af52de" data-name="Purple">🟣 Purple</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Draw Actions (Toggles) -->
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Draw Tools</span>
                <div class="grid grid-cols-3 gap-1.5">
                    <button id="btn-draw-point" class="inline-flex items-center justify-center gap-1 rounded-xl border border-slate-200 bg-white px-2 py-2 text-[10px] font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all duration-200 focus:outline-none">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Point
                    </button>
                    <button id="btn-draw-line" class="inline-flex items-center justify-center gap-1 rounded-xl border border-slate-200 bg-white px-2 py-2 text-[10px] font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all duration-200 focus:outline-none">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20L20 4" />
                        </svg>
                        Line
                    </button>
                    <button id="btn-draw-polygon" class="inline-flex items-center justify-center gap-1 rounded-xl border border-slate-200 bg-white px-2 py-2 text-[10px] font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all duration-200 focus:outline-none">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Polygon
                    </button>
                </div>
                <!-- Status Prompt when drawing is active -->
                <div id="draw-status-prompt" class="hidden mt-2 text-[10px] font-semibold text-center py-1.5 rounded-lg border"></div>
            </div>

            <!-- Points Display List -->
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Points Added</span>
                <div id="points-list" class="space-y-1.5 max-h-28 overflow-y-auto pr-1">
                    <p class="text-xs text-slate-400 italic">No points drawn yet.</p>
                </div>
            </div>

            <!-- Lines List -->
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Lines Added</span>
                <div id="lines-list" class="space-y-1.5 max-h-28 overflow-y-auto pr-1">
                    <p class="text-xs text-slate-400 italic">No lines drawn yet.</p>
                </div>
            </div>

            <!-- Polygons List -->
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Polygons Added</span>
                <div id="polygons-list" class="space-y-1.5 max-h-28 overflow-y-auto pr-1">
                    <p class="text-xs text-slate-400 italic">No polygons drawn yet.</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Map Container -->
    <div id="map" class="flex-grow h-full w-full bg-slate-100 relative">
        <button id="floating-finish-btn" class="hidden absolute top-4 left-1/2 -translate-x-1/2 z-20 inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0071e3] px-5 py-2.5 text-xs font-bold text-white shadow-xl hover:bg-blue-600 transition-all duration-200 hover:scale-105 active:scale-95 focus:outline-none">
            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Finish Polygon
        </button>

        <div id="map-loader" class="absolute inset-0 z-20 flex items-center justify-center bg-white transition-opacity duration-500">
            <div class="text-center">
                <svg class="animate-spin h-8 w-8 text-[#0071e3] mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-xs font-semibold text-slate-500">Loading MapLibre Interface...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/maplibre-gl@4.3.0/dist/maplibre-gl.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('map-sidebar');
        const drawerHeader = document.getElementById('drawer-header');
        const drawerActionText = document.getElementById('drawer-action-text');
        const toggleIcon = document.getElementById('drawer-toggle-icon');

        const lngDisplay = document.getElementById('lng-display');
        const latDisplay = document.getElementById('lat-display');
        const loader = document.getElementById('map-loader');
        const colorPicker = document.getElementById('color-picker');
        const btnPoint = document.getElementById('btn-draw-point');
        const btnLine = document.getElementById('btn-draw-line');
        const btnPolygon = document.getElementById('btn-draw-polygon');
        const statusPrompt = document.getElementById('draw-status-prompt');
        const floatingFinishBtn = document.getElementById('floating-finish-btn');

        let points = [];
        let lines = [];
        let polygons = [];

        let activeMode = null; 
        let lineStartCoordinate = null; 
        let tempMarker = null; 

        // Polygon drawing state variables
        let polygonCoordinates = []; 
        let polygonMarkers = []; 

        let map = null;

        // Mobile Drawer 
        function collapseDrawer() {
            if (window.innerWidth >= 768) return;
            sidebar.classList.remove('h-[45vh]', 'h-[50vh]');
            sidebar.classList.add('h-[70px]', 'overflow-hidden');
            if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
            if (drawerActionText) drawerActionText.textContent = 'Tap to Show Menu';
        }

        function expandDrawer() {
            if (window.innerWidth >= 768) return;
            sidebar.classList.remove('h-[70px]', 'overflow-hidden');
            sidebar.classList.add('h-[45vh]');
            if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
            if (drawerActionText) drawerActionText.textContent = 'Tap to Hide Menu';
        }

        function toggleDrawer() {
            if (window.innerWidth >= 768) return;
            const isCollapsed = sidebar.classList.contains('h-[70px]');
            if (isCollapsed) {
                expandDrawer();
            } else {
                collapseDrawer();
            }
        }

        // Add listeners for mobile drawer interaction
        if (drawerHeader) drawerHeader.addEventListener('click', toggleDrawer);
        if (drawerActionText) drawerActionText.addEventListener('click', toggleDrawer);

        try {
            // Initialize MapLibre GL Map
            map = new maplibregl.Map({
                container: 'map',
                style: 'https://basemaps.cartocdn.com/gl/positron-gl-style/style.json',
                center: [107.619123, -6.917464], // Bandung 
                zoom: 12,
                attributionControl: true
            });

            map.addControl(new maplibregl.NavigationControl({
                showCompass: true,
                showZoom: true
            }), 'bottom-right');

            map.on('load', function() {
                map.addSource('points-source', {
                    type: 'geojson',
                    data: { type: 'FeatureCollection', features: [] }
                });

                map.addSource('lines-source', {
                    type: 'geojson',
                    data: { type: 'FeatureCollection', features: [] }
                });

                map.addSource('polygons-source', {
                    type: 'geojson',
                    data: { type: 'FeatureCollection', features: [] }
                });

                map.addSource('polygon-preview-source', {
                    type: 'geojson',
                    data: { type: 'FeatureCollection', features: [] }
                });

                map.addLayer({
                    id: 'points-layer',
                    type: 'circle',
                    source: 'points-source',
                    paint: {
                        'circle-radius': 7,
                        'circle-color': ['get', 'color'],
                        'circle-stroke-width': 2,
                        'circle-stroke-color': '#ffffff'
                    }
                });

                map.addLayer({
                    id: 'lines-layer',
                    type: 'line',
                    source: 'lines-source',
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-width': 4,
                        'line-color': ['get', 'color']
                    }
                });

                map.addLayer({
                    id: 'polygons-layer',
                    type: 'fill',
                    source: 'polygons-source',
                    paint: {
                        'fill-color': ['get', 'color'],
                        'fill-opacity': 0.3
                    }
                });

                map.addLayer({
                    id: 'polygons-border-layer',
                    type: 'line',
                    source: 'polygons-source',
                    paint: {
                        'line-color': ['get', 'color'],
                        'line-width': 2
                    }
                });

                map.addLayer({
                    id: 'polygon-preview-fill',
                    type: 'fill',
                    source: 'polygon-preview-source',
                    paint: {
                        'fill-color': '#0071e3',
                        'fill-opacity': 0.15
                    }
                });
                map.addLayer({
                    id: 'polygon-preview-line',
                    type: 'line',
                    source: 'polygon-preview-source',
                    paint: {
                        'line-color': '#0071e3',
                        'line-width': 2,
                        'line-dasharray': [2, 2]
                    }
                });

                if (loader) {
                    loader.classList.add('opacity-0');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }
            });

            map.on('move', function() {
                const center = map.getCenter();
                if (lngDisplay && latDisplay) {
                    lngDisplay.textContent = center.lng.toFixed(5);
                    latDisplay.textContent = center.lat.toFixed(5);
                }
            });

            map.on('click', function(e) {
                if (!activeMode) return;

                const selectedColor = colorPicker.value;
                const coordinates = [e.lngLat.lng, e.lngLat.lat];

                if (activeMode === 'point') {
                    const newPoint = {
                        id: Date.now(),
                        coordinates: coordinates,
                        color: selectedColor
                    };
                    points.push(newPoint);
                    updatePointsOnMap();
                    renderPointsList();

                } else if (activeMode === 'line') {
                    if (!lineStartCoordinate) {
                        lineStartCoordinate = coordinates;
                        showTempMarker(coordinates, selectedColor);
                        updateStatusPrompt('Click another point on the map to complete the line.', 'bg-blue-50 text-blue-700 border-blue-200');
                    } else {
                        const newLine = {
                            id: Date.now(),
                            start: lineStartCoordinate,
                            end: coordinates,
                            coordinates: [lineStartCoordinate, coordinates],
                            color: selectedColor
                        };
                        lines.push(newLine);
                        
                        lineStartCoordinate = null;
                        clearTempMarker();
                        
                        updateLinesOnMap();
                        renderLinesList();
                        updateStatusPrompt('Line added! Draw another line or deactivate tool.', 'bg-emerald-50 text-emerald-700 border-emerald-200');
                    }
                } else if (activeMode === 'polygon') {
                    polygonCoordinates.push(coordinates);
                    
                    const el = document.createElement('div');
                    el.className = 'w-2.5 h-2.5 rounded-full border border-white shadow-sm transition-all duration-200';
                    el.style.backgroundColor = selectedColor;
                    const vertexMarker = new maplibregl.Marker(el)
                        .setLngLat(coordinates)
                        .addTo(map);
                    polygonMarkers.push(vertexMarker);
                    
                    updatePolygonPreview();
                    
                    if (polygonCoordinates.length === 1) {
                        updateStatusPrompt('Polygon: Click another coordinate (need at least 3).', 'bg-blue-50 text-blue-700 border-blue-200');
                    } else if (polygonCoordinates.length === 2) {
                        updateStatusPrompt('Polygon: Click a 3rd coordinate to form shape.', 'bg-blue-50 text-blue-700 border-blue-200');
                    } else {
                        updateStatusPrompt(`Polygon: ${polygonCoordinates.length} vertices. Use floating map button to finish.`, 'bg-blue-50 text-blue-700 border-blue-200');
                    }
                }
            });

        } catch (e) {
            console.error('Failed to initialize map:', e);
            if (loader) {
                loader.innerHTML = `
                    <div class="text-center p-6 border border-red-200 bg-red-50 rounded-2xl max-w-sm mx-4">
                        <span class="text-2xl">⚠️</span>
                        <p class="text-xs font-bold text-red-600 mt-2">Map Render Failed</p>
                        <p class="text-[10px] text-slate-500 mt-1">${e.message || 'Please reload page.'}</p>
                    </div>
                `;
            }
        }

        if (btnPoint) {
            btnPoint.addEventListener('click', function() {
                toggleDrawingMode('point');
            });
        }

        if (btnLine) {
            btnLine.addEventListener('click', function() {
                toggleDrawingMode('line');
            });
        }

        if (btnPolygon) {
            btnPolygon.addEventListener('click', function() {
                toggleDrawingMode('polygon');
            });
        }

        // Bind click handler to the floating Finish Polygon button
        if (floatingFinishBtn) {
            floatingFinishBtn.addEventListener('click', function(e) {
                e.stopPropagation(); 
                window.finishPolygon();
            });
        }

        // Handle color selection change
        if (colorPicker) {
            colorPicker.addEventListener('change', function() {
                const selectedColor = colorPicker.value;
                if (lineStartCoordinate && tempMarker) {
                    const markerElement = tempMarker.getElement();
                    if (markerElement) markerElement.style.backgroundColor = selectedColor;
                }
                polygonMarkers.forEach(m => {
                    const el = m.getElement();
                    if (el) el.style.backgroundColor = selectedColor;
                });
                updatePolygonPreview();
            });
        }

        function toggleDrawingMode(mode) {
            lineStartCoordinate = null;
            clearTempMarker();
            
            polygonCoordinates = [];
            clearPolygonMarkers();
            clearPolygonPreview();

            if (activeMode === mode) {
                activeMode = null;
            } else {
                activeMode = mode;
                collapseDrawer();
            }

            if (floatingFinishBtn) {
                if (activeMode === 'polygon') {
                    floatingFinishBtn.classList.remove('hidden');
                } else {
                    floatingFinishBtn.classList.add('hidden');
                }
            }

            updateButtonStates();
            updateCursor();
            updateStatusText();
        }

        function updateButtonStates() {
            const activeClass = ['bg-[#0071e3]', 'text-white', 'border-transparent'];
            const inactiveClass = ['bg-white', 'text-slate-700', 'border-slate-200', 'hover:bg-slate-50'];

            const buttons = {
                'point': btnPoint,
                'line': btnLine,
                'polygon': btnPolygon
            };

            Object.entries(buttons).forEach(([mode, btn]) => {
                if (btn) {
                    if (activeMode === mode) {
                        btn.classList.remove(...inactiveClass);
                        btn.classList.add(...activeClass);
                    } else {
                        btn.classList.remove(...activeClass);
                        btn.classList.add(...inactiveClass);
                    }
                }
            });
        }

        function updateCursor() {
            if (map) {
                const canvas = map.getCanvas();
                if (activeMode) {
                    canvas.style.cursor = 'crosshair';
                } else {
                    canvas.style.cursor = '';
                }
            }
        }

        function updateStatusText() {
            if (activeMode === 'point') {
                updateStatusPrompt('Editing Mode: Click on the map to add points.', 'bg-blue-50 text-blue-700 border-blue-200');
            } else if (activeMode === 'line') {
                updateStatusPrompt('Editing Mode: Click first point to start drawing line.', 'bg-blue-50 text-blue-700 border-blue-200');
            } else if (activeMode === 'polygon') {
                updateStatusPrompt('Editing Mode: Click on the map to add vertices.', 'bg-blue-50 text-blue-700 border-blue-200');
            } else {
                statusPrompt.classList.add('hidden');
            }
        }

        function updateStatusPrompt(text, classes) {
            statusPrompt.className = `mt-2 text-[10px] font-semibold text-center py-1.5 rounded-lg border ${classes}`;
            statusPrompt.innerHTML = text;
        }

        // Staging marker rendering
        function showTempMarker(coordinates, color) {
            if (tempMarker) tempMarker.remove();

            const el = document.createElement('div');
            el.className = 'w-3 h-3 rounded-full border-2 border-white shadow-md transition-all duration-200';
            el.style.backgroundColor = color;

            tempMarker = new maplibregl.Marker(el)
                .setLngLat(coordinates)
                .addTo(map);
        }

        function clearTempMarker() {
            if (tempMarker) {
                tempMarker.remove();
                tempMarker = null;
            }
        }

        function clearPolygonMarkers() {
            polygonMarkers.forEach(m => m.remove());
            polygonMarkers = [];
        }

        function updatePolygonPreview() {
            if (map && map.getSource('polygon-preview-source') && polygonCoordinates.length > 0) {
                const selectedColor = colorPicker.value;
                
                map.setPaintProperty('polygon-preview-fill', 'fill-color', selectedColor);
                map.setPaintProperty('polygon-preview-line', 'line-color', selectedColor);

                let previewCoords = [...polygonCoordinates];
                const isPolygon = polygonCoordinates.length >= 3;
                
                if (isPolygon) {
                    previewCoords.push(polygonCoordinates[0]); 
                }

                const geojson = {
                    type: 'Feature',
                    geometry: {
                        type: isPolygon ? 'Polygon' : 'LineString',
                        coordinates: isPolygon ? [previewCoords] : previewCoords
                    }
                };
                map.getSource('polygon-preview-source').setData(geojson);
            }
        }

        function clearPolygonPreview() {
            if (map && map.getSource('polygon-preview-source')) {
                map.getSource('polygon-preview-source').setData({
                    type: 'FeatureCollection',
                    features: []
                });
            }
        }

        // GeoJSON source update handlers
        function updatePointsOnMap() {
            if (map && map.getSource('points-source')) {
                const geojson = {
                    type: 'FeatureCollection',
                    features: points.map(p => ({
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: p.coordinates
                        },
                        properties: {
                            id: p.id,
                            color: p.color
                        }
                    }))
                };
                map.getSource('points-source').setData(geojson);
            }
        }

        // Line source update handler
        function updateLinesOnMap() {
            if (map && map.getSource('lines-source')) {
                const geojson = {
                    type: 'FeatureCollection',
                    features: lines.map(l => ({
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates: l.coordinates
                        },
                        properties: {
                            id: l.id,
                            color: l.color
                        }
                    }))
                };
                map.getSource('lines-source').setData(geojson);
            }
        }

        // Polygon source update handler
        function updatePolygonsOnMap() {
            if (map && map.getSource('polygons-source')) {
                const geojson = {
                    type: 'FeatureCollection',
                    features: polygons.map(poly => ({
                        type: 'Feature',
                        geometry: {
                            type: 'Polygon',
                            coordinates: poly.coordinates
                        },
                        properties: {
                            id: poly.id,
                            color: poly.color
                        }
                    }))
                };
                map.getSource('polygons-source').setData(geojson);
            }
        }

        // Render point geometries list in sidebar
        function renderPointsList() {
            const listContainer = document.getElementById('points-list');
            if (!listContainer) return;

            if (points.length === 0) {
                listContainer.innerHTML = '<p class="text-xs text-slate-400 italic">No points drawn yet.</p>';
                return;
            }

            listContainer.innerHTML = points.map((p, index) => `
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 p-2.5 rounded-xl text-xs shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-3 w-3 rounded-full border border-white shadow-sm" style="background-color: ${p.color}"></span>
                        <span class="font-bold text-slate-700">Point #${index + 1}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-slate-500 text-[10px]">${p.coordinates[0].toFixed(5)}, ${p.coordinates[1].toFixed(5)}</span>
                        <button onclick="deletePoint(${p.id})" class="text-red-500 hover:text-red-700 font-bold px-1.5 py-0.5 rounded-md hover:bg-slate-100 transition-colors duration-150" title="Delete Point">&times;</button>
                    </div>
                </div>
            `).join('');
        }

        // Render line geometries list in sidebar
        function renderLinesList() {
            const listContainer = document.getElementById('lines-list');
            if (!listContainer) return;

            if (lines.length === 0) {
                listContainer.innerHTML = '<p class="text-xs text-slate-400 italic">No lines drawn yet.</p>';
                return;
            }

            listContainer.innerHTML = lines.map((l, index) => `
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 p-2.5 rounded-xl text-xs shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-1 w-4 rounded-full" style="background-color: ${l.color}"></span>
                        <span class="font-bold text-slate-700">Line #${index + 1}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col text-[9px] font-mono text-slate-500 leading-tight">
                            <span>S: ${l.start[0].toFixed(4)}, ${l.start[1].toFixed(4)}</span>
                            <span>E: ${l.end[0].toFixed(4)}, ${l.end[1].toFixed(4)}</span>
                        </div>
                        <button onclick="deleteLine(${l.id})" class="text-red-500 hover:text-red-700 font-bold px-1.5 py-0.5 rounded-md hover:bg-slate-100 transition-colors duration-150" title="Delete Line">&times;</button>
                    </div>
                </div>
            `).join('');
        }

        // Render polygon geometries list in sidebar
        function renderPolygonsList() {
            const listContainer = document.getElementById('polygons-list');
            if (!listContainer) return;

            if (polygons.length === 0) {
                listContainer.innerHTML = '<p class="text-xs text-slate-400 italic">No polygons drawn yet.</p>';
                return;
            }

            listContainer.innerHTML = polygons.map((poly, index) => {
                const count = poly.coordinates[0].length - 1; 
                return `
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 p-2.5 rounded-xl text-xs shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-3.5 w-3.5 border border-white shadow-sm opacity-80" style="background-color: ${poly.color}; border-radius: 4px;"></span>
                            <span class="font-bold text-slate-700">Polygon #${index + 1}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-500 text-[10px]">${count} Vertices</span>
                            <button onclick="deletePolygon(${poly.id})" class="text-red-500 hover:text-red-700 font-bold px-1.5 py-0.5 rounded-md hover:bg-slate-100 transition-colors duration-150" title="Delete Polygon">&times;</button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Globally exposing action and delete functions triggered from HTML templates
        window.finishPolygon = function() {
            if (polygonCoordinates.length < 3) {
                alert('Please click at least 3 coordinates on the map to close a polygon.');
                return;
            }
            
            const selectedColor = colorPicker.value;
            const closedCoords = [...polygonCoordinates, polygonCoordinates[0]];
            const newPolygon = {
                id: Date.now(),
                coordinates: [closedCoords],
                color: selectedColor
            };
            
            polygons.push(newPolygon);
            
            polygonCoordinates = [];
            clearPolygonMarkers();
            clearPolygonPreview();
            
            updatePolygonsOnMap();
            renderPolygonsList();
            updateStatusPrompt('Polygon added! Draw another or deactivate tool.', 'bg-emerald-50 text-emerald-700 border-emerald-200');
        };

        window.deletePoint = function(id) {
            points = points.filter(p => p.id !== id);
            updatePointsOnMap();
            renderPointsList();
        };

        window.deleteLine = function(id) {
            lines = lines.filter(l => l.id !== id);
            updateLinesOnMap();
            renderLinesList();
        };

        window.deletePolygon = function(id) {
            polygons = polygons.filter(poly => poly.id !== id);
            updatePolygonsOnMap();
            renderPolygonsList();
        };
    });
</script>
@endsection
