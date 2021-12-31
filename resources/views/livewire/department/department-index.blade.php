<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Department</h1>
    </div>
    <div class="card">
        <div>
            @if (session()->has('department-message'))
                <div class="alert alert-success">{{ session('department-message') }}</div>
            @endif
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form class="row g-3" method="GET" action="{{route('departments.index')}}">
                        <div class="col-auto">
                            <input type="search" wire:model="search" name="search" class="form-control"
                                id="inputPassword2" placeholder="Search...">
                        </div>
                        <div class="col-auto" wire:loading>
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <button wire:click="showDepartmentModal" class="btn bg-blue-700 text-white">
                        New Department
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" wire:loading.remove>
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <th scope="row">{{ $department->id }}</th>
                            <td>{{ $department->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$department->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteDepartment({{$department->id}})" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th>No Results</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{$departments->links('pagination::bootstrap-4')}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($editMode)
                        <h5 class="modal-title" id="departmentModalLabel">Edit Department</h5>
                    @else
                        <h5 class="modal-title" id="departmentModalLabel">Create Department</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
    
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
    
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gray-300" data-dismiss="modal" wire:click="closeModal">Close</button>
                            @if($editMode)
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="updateDepartment()">Update Department</button>
                            @else
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="storeDepartment()">Store Department</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
