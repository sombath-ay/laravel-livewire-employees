<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>
    <div class="card">
        <div>
            @if (session()->has('user-message'))
                <div class="alert alert-success">{{ session('user-message') }}</div>
            @endif
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form class="row g-3" method="GET" action="{{route('users.index')}}" enctype="multipart/form-data">
                        <div class="col-auto">
                            <input type="search" wire:model="search" name="search" class="form-control"
                                id="inputPassword2" placeholder="Search...">
                        </div>
                        <div class="col-auto" wire:loading>
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">loading</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <button wire:click="showUserModal" class="btn bg-blue-700 text-white">
                        New User
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" wire:loading.remove>
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button wire:click="showEditModal({{$user->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteUser({{$user->id}})" class="btn btn-danger">Delete</button>
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
            {{$users->links('pagination::bootstrap-4')}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- username --}}
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
    
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" wire:model.defer="username">
    
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        {{-- first name --}}
                        <div class="row mb-3">
                            <label for="firstName" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>
    
                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" wire:model.defer="firstName">
    
                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        {{-- last name --}}
                        <div class="row mb-3">
                            <label for="lastName" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>
    
                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" wire:model.defer="lastName">
    
                                @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        {{-- email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
    
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        {{-- Password --}}
                        @if(!$editMode)
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
        
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model.defer="password" >
        
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
    
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gray-300" data-dismiss="modal" wire:click="closeModal">Close</button>
                            @if($editMode)
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="updateUser()">Update User</button>
                            @else
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="storeUser()">Store User</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
