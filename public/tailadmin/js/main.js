// main.js – gabungkan semua komponen TailAdmin

// Import semua script komponen
import './components/charts/calendar-init.js';
import './components/charts/map-01.js';
import './components/image-resize.js';
import './components/index.js';

// Jika template tidak pakai bundler, bisa juga langsung jalankan manual
document.addEventListener('DOMContentLoaded', function () {
    console.log('TailAdmin main.js loaded successfully');
});
