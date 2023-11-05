@extends('layouts.master')

@section('title')
  Calendar
@endsection

@section('navigation')
    
@endsection

@section('content') 

  <div class="content">
    <div class="card">
      <div class="card-header">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Event</button>
      <button class="btn btn-danger" id="removeEventToggle">Remove Event</button>
      <button class="btn btn-warning" id="return" style="height: 40px"><i class="bi bi-arrow-return-left"></i></button>
      </div>
      <div class="card-body">
        <div id='calendar'></div>
        <div id="calendarTable" style="display: none">
          @include('admin.dateFolder.removeDate')
        </div>
      </div>
    </div>
  </div>
@endsection

<!-- Modal for Adding -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header bg-primary">
              <h1 class="modal-title fs-5 text-white" id="addModalLabel">Add Event</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('storeCalendar') }}" method="POST">
              @csrf
              <div class="modal-body">
                  <span>Title:</span>
                  <input type="text" class="form-control" name="title">
                  <div class="row">
                    <div class="col">
                      <span>Start Date:</span>
                      <input type="text" class="form-control datepicker" name="start_date" autocomplete="off">
                    </div>
                    <div class="col">
                      <span>End Date:</span>
                      <input type="text" class="form-control datepicker" name="end_date" autocomplete="off">
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
              </div>
          </form>
      </div>
  </div>
</div>

@section('script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var events = @json($events);
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth'
        },
        events
      });
      calendar.render();
      $('#searchBar').addClass('d-none');
      $('#search').addClass('d-none');
      $('#searchBtn').addClass('d-none');
    });
    
    $( function() {
      $( "#addModal .datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd', // Set the desired format
        timeFormat: 'hh:mm:ss', // Optional, set the time format
        showTime: true,        // Optional, show the time
      });
    });
    $('#removeEventToggle').click(function (e) { 
      e.preventDefault();
      $('#calendar').hide();
      $('#calendarTable').show();
    });
    $('#return').click(function (e) { 
      e.preventDefault();
      $('#calendar').toggle();
      $('#calendarTable').toggle();
    });
    $('#deleteBtn').click(function (e) { 
      e.preventDefault();
      let id = $(this).data('id');
      $('#id').val(id);
      $('#deleteForm').submit();
    });
  </script>
@endsection
