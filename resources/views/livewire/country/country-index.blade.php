<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Country</h1>
    </div>
    <div class="card">
        <div>
            @if (session()->has('country-message'))
                <div class="alert alert-success">{{ session('country-message') }}</div>
            @endif
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form class="row g-3" method="GET" action="{{route('countries.index')}}">
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
                    <button wire:click="showCountryModal" class="btn bg-blue-700 text-white">
                        New Country
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" wire:loading.remove>
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">Country Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($countries as $country)
                        <tr>
                            <th scope="row">{{ $country->id }}</th>
                            <td>{{ $country->country_code }}</td>
                            <td>{{ $country->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$country->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteCountry({{$country->id}})" class="btn btn-danger">Delete</button>
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
            {{$countries->links('pagination::bootstrap-4')}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($editMode)
                        <h5 class="modal-title" id="countryModalLabel">Edit Country</h5>
                    @else
                        <h5 class="modal-title" id="countryModalLabel">Create Country</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- countryCode --}}
                        <div class="row mb-3">
                            <label for="countryCode" class="col-md-4 col-form-label text-md-end">{{ __('Country Code') }}</label>
    
                            <div class="col-md-6">
                                <input id="countryCode" type="text" class="form-control @error('countryCode') is-invalid @enderror" wire:model.defer="countryCode">
    
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
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="updateCountry()">Update Country</button>
                            @else
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="storeCountry()">Store Country</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
