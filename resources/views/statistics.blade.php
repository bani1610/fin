<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Insights & Statistik Mingguan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Kita tidak lagi menggunakan max-w-7xl di sini karena sudah diatur oleh app.blade.php --}}
        <div class="layout-content-container flex flex-col w-full flex-1">
            <div class="flex flex-wrap justify-between items-center gap-3 px-4 sm:px-6 lg:px-8 mb-6">
                <h1 class="text-text-primary tracking-tight text-3xl font-bold leading-tight">Weekly Insights</h1>
            </div>

            {{-- Bagian Mood Overview --}}
            <section class="mb-10">
                <h2 class="text-text-primary text-xl font-semibold leading-tight tracking-[-0.01em] px-4 sm:px-6 lg:px-8 pb-4 pt-2">Mood Overview</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-6 lg:px-8">
                    {{-- Grafik Pie Mood --}}
                    <div class="lg:col-span-2 flex flex-col gap-4 rounded-xl border border-border-color bg-white p-6 shadow-sm">
                        <p class="text-text-primary text-base font-medium leading-normal">Distribusi Mood (7 Hari Terakhir)</p>
                        <div class="flex items-center justify-center min-h-[250px] text-gray-400">
                            {{-- Mengganti <img> dengan <canvas> untuk grafik dinamis --}}
                            <canvas id="moodPieChart"></canvas>
                        </div>
                    </div>
                    {{-- Daftar Rincian Mood --}}
                    <div class="flex flex-col gap-4 rounded-xl border border-border-color bg-white p-6 shadow-sm">
                        <p class="text-text-primary text-base font-medium leading-normal">Rincian Mood</p>
                        <ul class="space-y-3 mt-2">
                            @forelse ($moodBreakdown as $mood)
                                <li class="flex items-center justify-between text-sm">
                                    <span class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full {{ $mood['color'] }} mr-2"></span>
                                        {{ $mood['mood'] }} ({{ $mood['emoji'] }})
                                    </span>
                                    <span class="font-semibold">{{ $mood['percentage'] }}%</span>
                                </li>
                            @empty
                                <p class="text-gray-500 text-sm">Data mood belum tersedia.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </section>

            {{-- Bagian Produktivitas --}}
            <section class="mb-10">
                <h2 class="text-text-primary text-xl font-semibold leading-tight tracking-[-0.01em] px-4 sm:px-6 lg:px-8 pb-4 pt-2">Productivity</h2>
                <div class="flex flex-wrap gap-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex min-w-72 flex-1 flex-col gap-4 rounded-xl border border-border-color bg-white p-6 shadow-sm">
                        <p class="text-text-primary text-base font-medium leading-normal">Tugas Selesai (7 Hari Terakhir)</p>
                        <div class="flex min-h-[250px] flex-1 flex-col gap-8 py-4">
                            {{-- Mengganti <svg> dengan <canvas> untuk grafik dinamis --}}
                            <canvas id="tasksLineChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Bagian Analisis & Saran --}}
            <section>
                <h2 class="text-text-primary text-xl font-semibold leading-tight tracking-[-0.01em] px-4 sm:px-6 lg:px-8 pb-3 pt-5">Analisis & Saran</h2>
                <div class="bg-white rounded-xl border border-border-color p-6 mx-4 sm:mx-6 lg:mx-8 shadow-sm">
                    <p class="text-text-primary text-base font-normal leading-relaxed">
                        Berdasarkan tren mood dan produktivitas Anda, tampaknya Anda memiliki minggu yang seimbang. Tingkat penyelesaian tugas Anda konsisten, yang menandakan produktivitas yang baik. Pertimbangkan untuk menetapkan tugas yang lebih menantang dan jelajahi aktivitas baru untuk menjaga mood tetap positif.
                    </p>
                </div>
            </section>

            <footer class="text-center py-8 mt-10 text-sm text-gray-500">
                <p>© {{ date('Y') }} Mood Study. All rights reserved.</p>
            </footer>
        </div>
    </div>

    {{-- Script untuk Chart.js diletakkan di dalam @push agar dimuat di akhir body --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ======================
            // GRAFIK PIE UNTUK MOOD
            // ======================
            const moodPieCtx = document.getElementById('moodPieChart');
            if (moodPieCtx) {
                new Chart(moodPieCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($moodChartData['labels']),
                        datasets: [{
                            label: 'Distribusi Mood',
                            data: @json($moodChartData['data']),
                            backgroundColor: [ // Warna-warna yang menarik
                                'rgba(255, 205, 86, 0.8)', // Happy (Kuning)
                                'rgba(54, 162, 235, 0.8)', // Calm (Biru)
                                'rgba(75, 192, 192, 0.8)', // Productive (Hijau)
                                'rgba(255, 99, 132, 0.8)',  // Stressed (Merah)
                                'rgba(153, 102, 255, 0.8)'  // Sad (Ungu)
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }

            // =========================
            // GRAFIK GARIS UNTUK TUGAS
            // =========================
            const tasksLineCtx = document.getElementById('tasksLineChart');
            if(tasksLineCtx) {
                new Chart(tasksLineCtx, {
                    type: 'line',
                    data: {
                        labels: @json($taskChartData['labels']),
                        datasets: [{
                            label: 'Tugas Selesai',
                            data: @json($taskChartData['data']),
                            borderColor: '#007e9e', // Warna dari var(--primary-color)
                            backgroundColor: 'rgba(0, 126, 158, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#007e9e',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1 // Agar sumbu Y hanya menampilkan bilangan bulat
                                }
                            }
                        }
                    }
                });
            }

        });
    </script>
    @endpush

</x-app-layout>
