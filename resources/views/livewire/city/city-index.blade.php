<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cities</h1>
    </div>
    <div class="card">
        <div>
            @if (session()->has('city-message'))
                <div class="alert alert-success">{{ session('city-message') }}</div>
            @endif
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form class="row g-3" method="GET" action="{{route('cities.index')}}">
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
                    <button wire:click="showCityModal" class="btn bg-blue-700 text-white">
                        New City
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" wire:loading.remove>
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">State</th>
                        <th scope="col">Name</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cities as $city)
                        <tr>
                            <th scope="row">{{ $city->id }}</th>
                            <td>{{ $city->state->name }}</td>
                            <td>{{ $city->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$city->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteCity({{$city->id}})" class="btn btn-danger">Delete</button>
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
            {{$cities->links('pagination::bootstrap-4')}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($editMode)
                        <h5 class="modal-title" id="cityModalLabel">Edit City</h5>
                    @else
                        <h5 class="modal-title" id="cityModalLabel">Create City</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- countryId --}}
                        <div class="row mb-3">
                            <label for="stateId" class="col-md-4 col-form-label text-md-end">{{ __('State Name') }}</label>
    
                            <div class="col-md-6">
                                <select wire:model.defer="stateId" class="custom-select form-control">
                                    <option selected>Choose</option>
                                    @foreach (App\Models\State::all() as $state)
                                        <option value="{{ $state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
    
                                @error('countryCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
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
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="updateCity()">Update City</button>
                            @else
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="storeCity()">Store City</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
