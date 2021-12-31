<?php

namespace App\Http\Livewire\Country;

use Livewire\Component;
use App\Models\Country;

class CountryIndex extends Component
{
    public $search = '';
    public $countryCode, $name;
    public $editMode = false;
    public $countryId;

    public $rules = [
        'countryCode' => 'required',
        'name' => 'required',
    ];

    public function showEditModal($id){
        $this->reset();
        $this->countryId = $id;
        $this->loadCountries();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal','actionModal' => 'show']);
    }

    public function loadCountries() {
        $country = Country::find($this->countryId);
        $this->countryCode = $country->country_code;
        $this->name = $country->name;
    }

    public function deleteCountry($id){
        $country = Country::find($id);
        $country->delete();
        $this->reset();
        session()->flash('country-message','Country Deleted Successfully');
    }

    public function storeCountry(){
        $this->validate();
        Country::create([
            'country_code' => $this->countryCode,
            'name' => $this->name,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal','actionModal' => 'hide']);
        session()->flash('country-message','Country Created Successfully');
    }

    public function updateCountry(){
        $validated = $this->validate([
            'countryCode' => 'required',
            'name' => 'required',
        ]);
        $country = Country::find($this->countryId);
        $country->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal','actionModal' => 'hide']);
        session()->flash('country-message','Country Updated Successfully');
    }

    public function showCountryModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal','actionModal' => 'show']);
    }

    public function closeModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#countryModal','actionModal' => 'hide']);
    }

    public function render()
    {
        $countries = Country::paginate(5);
        if(strlen($this->search) > 2 ){
            $countries = Country::where('name','like',"%{$this->search}%")->paginate(5);
        }
        return view('livewire.country.country-index',[
            'countries' => $countries,
        ])->layout('layouts.main');
    }
}
