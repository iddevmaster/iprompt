@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="container">
        <div class="text-center mb-4"><h2>Calendar</h2></div>

        <div class="bg-white p-4">
            <div id='calendar'></div>
        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
          const calendarEl = document.getElementById('calendar')
          const calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay'
              }
          })
          calendar.setOption('locale', 'th');
          calendar.render()
        })

    </script>
</body>
@endsection
