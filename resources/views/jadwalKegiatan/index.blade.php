@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar/main.min.js"></script>

<style>
    #calendar-container {
        display: flex;
        gap: 1rem;
        margin: 1rem 3rem;
    }

    #calendar {
        flex: 2;
    }

    #event-detail {
        flex: 1;
        padding: 1rem;
        background-color: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-left: 5px solid rgb(190, 191, 191);
        border-radius: 5px;
    }

    .fc-event {
        cursor: pointer;
    }

    #event-detail h5 {
        color: #2654A1;
        font-weight: bold;
        margin-bottom : 1rem;
    }

    .fc-toolbar {
    background-color: #B8E8FF; /* Warna background toolbar */
    padding: 10px; /* Spasi di dalam toolbar */
    border-radius: 8px; /* Membuat sudut rounded */
    border: 1px solid #ddd; /* Tambahkan border */
}

.fc-toolbar-chunk {
    display: flex; /* Memastikan elemen diatur dalam satu baris */
    align-items: center; /* Tengah secara vertikal */
}

.fc-button {
    background-color: #2654A1; /* Warna biru pada tombol */
    color: white; /* Warna teks putih */
    border: none; /* Hilangkan border */
    border-radius: 4px; /* Sudut rounded */
    padding: 5px 10px; /* Ukuran tombol */
    margin: 0 5px; /* Jarak antar tombol */
    font-weight: bold;
}

.fc-button:hover {
    background-color: #0056b3; /* Warna tombol saat hover */
}

.fc-button.fc-button-active {
    background-color: #28a745; /* Warna tombol saat aktif */
}

</style>

<div style="display: flex; flex-direction: column; margin-top: 1rem; margin-bottom: 3rem; padding: 1rem;">
    <div style="padding: 20px; text-align: center;">
        <h2 style="color:#2654A1; font-size: 1.8rem; font-weight: 700; margin-bottom: 10px;">
            Jadwal Kegiatan <br /> Badan Penjamin Mutu (BPM)
        </h2>
    </div>

    @if(Cookie::has('username'))
    <div style="display: flex; justify-content: flex-end; margin-right: 3rem; margin-bottom: 1rem;">
        <a class="btn btn-primary" href="{{ route('jadwalKegiatan.read') }}">Kelola Jadwal Kegiatan</a>
    </div>
    @endif

    <div id="calendar-container">
        <div id="calendar"></div>
        <div id="event-detail">
           
            <h5><span id="event-title">Pilih acara untuk melihat detail</span></h5>
            <p><strong>Waktu:</strong> <span id="event-time"></span></p>
            <p><strong>Tempat:</strong> <span id="event-location"></span></p>
            <p><strong>Deskripsi:</strong> <span id="event-description"></span></p>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        function formatEventTime(start, end) {
            const daysFormatter = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            const timeFormatter = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', timeZoneName: 'short' });

            const startDay = daysFormatter.format(start);
            const endDay = daysFormatter.format(end);
            const startTime = timeFormatter.format(start);
            const endTime = timeFormatter.format(end);

            return `${startDay} ${startTime} - ${endDay} ${endTime}`;
        }

        const start = new Date(2025, 0, 5, 8, 0); // 5 Januari 2025, 08:00 WIB
        const end = new Date(2025, 0, 8, 16, 0); // 8 Januari 2025, 16:00 WIB

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {!! json_encode($jadwalKegiatan->map(function ($event) {
                return [
                    'title' => $event->keg_nama,
                    'start' => $event->keg_tgl_mulai . 'T' . $event->keg_jam_mulai,
                    'end' => $event->keg_tgl_selesai . 'T' . $event->keg_jam_selesai,
                    'description' => $event->keg_deskripsi,
                    'location' => $event->keg_tempat,
                    'category' => $event->keg_kategori, // Tambahkan kategori di sini
                ];
            })->toArray()) !!},
            eventClick: function (info) {
                document.getElementById('event-title').textContent = info.event.title;
                document.getElementById('event-description').innerHTML = info.event.extendedProps.description;
                document.getElementById('event-time').textContent = formatEventTime(start, end);
                document.getElementById('event-location').textContent = info.event.extendedProps.location;
            },
            eventDidMount: function (info) {
                // Tetapkan warna berdasarkan kategori
                if (info.event.extendedProps.category === 'Rencana') {
                    info.el.style.backgroundColor = 'rgba(119, 160, 255, 1)';
                    info.el.style.borderRadius = '5px'; // Styling sudut
                    info.el.style.padding = '5px'; // Tambahkan padding
                } else if (info.event.extendedProps.category === 'Terlaksana') {
                    info.el.style.backgroundColor = 'rgba(126, 255, 119, 1)';
                    info.el.style.borderRadius = '5px';
                    info.el.style.padding = '5px';
                } else if (info.event.extendedProps.category === 'Terlewat') {
                    info.el.style.backgroundColor = 'rgba(108, 117, 125, 0.5)';
                    info.el.style.borderRadius = '5px';
                    info.el.style.padding = '5px';
                }

                // Styling teks
                info.el.style.color = '#fff';
                info.el.style.fontWeight = 'bold';
                info.el.style.textAlign = 'center';
            }
        });

        calendar.render();
    });
</script>
@endsection

