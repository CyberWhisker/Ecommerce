<div style="padding-bottom: 10px;">
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Add Unit</button>
</div>
<table class="table table-striped table-hover table-bordered" id="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Unit</th>
            <th>Created</th>
            <th style="width: 5%;">
                <i class="bi bi-gear"></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data_unit as $data)
            <tr>
                <td style="max-width: 20px">{{ $data->id }}</td>
                <td>{{ $data->unit }}</td>
                <td>{{ $data->created_at }}</td>
                <td>
                    <div class="dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="editBtn" data-id="{{$data->id}}">Edit</a></li>
                            <li><a class="dropdown-item" href="#" id="deleteBtn" data-id="{{$data->id}}">Delete</a></li>
                        </ul>
                    </div>                                
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center">
                    <span class="text-danger" style="font-weight: bold">No record Found</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

