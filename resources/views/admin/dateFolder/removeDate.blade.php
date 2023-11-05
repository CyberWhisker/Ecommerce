<form action="{{route('deleteCalendar')}}" method="POST" id="deleteForm">
    @csrf
    <input type="hidden" name="id" id="id">
</form>
<table class="table table-striped table-hover table-bordered" id="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th style="width: 5%;">
                <i class="bi bi-gear"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data_calendar as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ \Carbon\Carbon::parse($data->start_date)->format('M-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($data->end_date)->format('M-m-Y') }}</td>
                <td>
                    <button type="button" class="btn btn-outline-danger" id="deleteBtn" data-id="{{$data->id}}"><i class="bi bi-trash3"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">
                    <span class="text-danger" style="font-weight: bold">No record Found</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>