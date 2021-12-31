<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="card">
        <div>
            @if (session()->has('employee-message'))
                <div class="alert alert-success">{{ session('employee-message') }}</div>
            @endif
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <form class="row g-3" method="GET" action="{{route('employees.index')}}">
                        <div class="col-md-4">
                            <input type="search" wire:model="search" name="search" class="form-control"
                                id="inputPassword2" placeholder="Search...">
                        </div>
                        <div class="col-md-4">
                            <select wire:model="selectedDepartmentId" class="custom-select form-control">
                                <option selected>Choose Department</option>
                                @foreach (App\Models\Department::all() as $department)
                                    <option value="{{ $department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto" wire:loading>
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 float-right">
                    <button wire:click="showEmployeeModal" class="btn bg-blue-700 text-white">
                        New Employee
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" wire:loading.remove>
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Country</th>
                        <th scope="col">Date Hired</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <th scope="row">{{ $employee->id }}</th>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td>{{ $employee->country->name }}</td>
                            <td>{{ $employee->date_hired }}</td>
                            <td>
                                <button wire:click="showEditModal({{$employee->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteEmployee({{$employee->id}})" class="btn btn-danger">Delete</button>
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
            {{$employees->links('pagination::bootstrap-4')}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($editMode)
                        <h5 class="modal-title" id="employeeModalLabel">Edit State</h5>
                    @else
                        <h5 class="modal-title" id="employeeModalLabel">Create State</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>

                        {{-- First Name --}}
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

                        {{-- Last Name --}}
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

                        {{-- Middle Name --}}
                        <div class="row mb-3">
                            <label for="middleName" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>
    
                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" wire:model.defer="middleName">
    
                                @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
    
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" wire:model.defer="address">
    
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Country Name --}}
                        <div class="row mb-3">
                            <label for="countryId" class="col-md-4 col-form-label text-md-end">{{ __('Country Name') }}</label>
    
                            <div class="col-md-6">
                                <select wire:model.defer="countryId" class="custom-select form-control">
                                    <option selected>Choose</option>
                                    @foreach (App\Models\Country::all() as $country)
                                        <option value="{{ $country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
    
                                @error('countryCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- State Name --}}
                        <div class="row mb-3">
                            <label for="stateId" class="col-md-4 col-form-label text-md-end">{{ __('State Name') }}</label>
    
                            <div class="col-md-6">
                                <select wire:model.defer="stateId" class="custom-select form-control">
                                    <option selected>Choose</option>
                                    @foreach (App\Models\State::all() as $state)
                                        <option value="{{ $state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
    
                                @error('stateId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- City Name --}}
                        <div class="row mb-3">
                            <label for="cityId" class="col-md-4 col-form-label text-md-end">{{ __('City Name') }}</label>
    
                            <div class="col-md-6">
                                <select wire:model.defer="cityId" class="custom-select form-control">
                                    <option selected>Choose</option>
                                    @foreach (App\Models\City::all() as $city)
                                        <option value="{{ $city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
    
                                @error('cityId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Department Name --}}
                        <div class="row mb-3">
                            <label for="departmentId" class="col-md-4 col-form-label text-md-end">{{ __('Department Name') }}</label>
    
                            <div class="col-md-6">
                                <select wire:model.defer="departmentId" class="custom-select form-control">
                                    <option selected>Choose</option>
                                    @foreach (App\Models\Department::all() as $department)
                                        <option value="{{ $department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
    
                                @error('departmentId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        {{-- Zip Code --}}
                        <div class="row mb-3">
                            <label for="zipCode" class="col-md-4 col-form-label text-md-end">{{ __('Zip Code') }}</label>
    
                            <div class="col-md-6">
                                <input id="zipCode" type="text" class="form-control @error('zipCode') is-invalid @enderror" wire:model.defer="zipCode">
    
                                @error('zipCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Birth Date --}}
                        <div class="row mb-3">
                            <label for="birthDate" class="col-md-4 col-form-label text-md-end">{{ __('Birthdate') }}</label>
    
                            <div class="col-md-6">
                                <input id="birthDate" type="text" class="form-control @error('birthDate') is-invalid @enderror" wire:model.defer="birthDate">
    
                                @error('birthDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Birth Date --}}
                        <div class="row mb-3">
                            <label for="dateHired" class="col-md-4 col-form-label text-md-end">{{ __('Date Hired') }}</label>
    
                            <div class="col-md-6">
                                <input id="dateHired" type="text" class="form-control @error('dateHired') is-invalid @enderror" wire:model.defer="dateHired">
    
                                @error('dateHired')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gray-300" data-dismiss="modal" wire:click="closeModal">Close</button>
                            @if($editMode)
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="updateEmployee()">Update Employee</button>
                            @else
                            <button type="submit" class="btn bg-blue-700 text-white" wire:click="storeEmployee()">Store Employee</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
