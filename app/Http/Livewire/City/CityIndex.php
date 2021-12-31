<?php

namespace App\Http\Livewire\City;

use Livewire\Component;
use App\Models\City;

class CityIndex extends Component
{
    public $search = '';
    public $stateId, $name;
    public $editMode = false;
    public $cityId;

    public $rules = [
        'stateId' => 'required',
        'name' => 'required',
    ];

    public function showEditModal($id){
        $this->reset();
        $this->cityId = $id;
        $this->loadStates();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal',['modalId' => '#cityModal','actionModal' => 'show']);
    }

    public function loadStates() {
        $city = City::find($this->cityId);
        $this->stateId = $city->state_id;
        $this->name = $city->name;
    }

    public function deleteCity($id){
        $city = City::find($id);
        $city->delete();
        $this->reset();
        session()->flash('city-message','City Deleted Successfully');
    }

    public function storeCity(){
        $this->validate();
        City::create([
            'state_id' => $this->stateId,
            'name' => $this->name,
        ]);
        $this->reset(); 
        $this->dispatchBrowserEvent('modal',['modalId' => '#cityModal','actionModal' => 'hide']);
        session()->flash('city-message','City Created Successfully');
    }

    public function updateCity(){
        $validated = $this->validate([
            'stateId' => 'required',
            'name' => 'required',
        ]);
        $city = City::find($this->cityId);
        $city->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#cityModal','actionModal' => 'hide']);
        session()->flash('city-message','City Updated Successfully');
    }

    public function showCityModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#cityModal','actionModal' => 'show']);
    }

    public function closeModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#cityModal','actionModal' => 'hide']);
    }

    public function render()
    {
        $cities = City::paginate(5);
        if(strlen($this->search) > 2 ){
            $cities = State::where('name','like',"%{$this->search}%")->paginate(5);
        }
        return view('livewire.city.city-index',[
            'cities' => $cities,
        ])->layout('layouts.main');
    }
}
