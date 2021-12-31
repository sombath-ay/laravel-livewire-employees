<?php

namespace App\Http\Livewire\State;

use Livewire\Component;
use App\Models\State;

class StateIndex extends Component
{
    public $search = '';
    public $countryId, $name;
    public $editMode = false;
    public $stateId;

    public $rules = [
        'countryId' => 'required',
        'name' => 'required',
    ];

    public function showEditModal($id){
        $this->reset();
        $this->stateId = $id;
        $this->loadStates();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal',['modalId' => '#stateModal','actionModal' => 'show']);
    }

    public function loadStates() {
        $state = State::find($this->stateId);
        $this->countryId = $state->country_id;
        $this->name = $state->name;
    }

    public function deleteState($id){
        $state = State::find($id);
        $state->delete();
        $this->reset();
        session()->flash('state-message','State Deleted Successfully');
    }

    public function storeState(){
        $this->validate();
        State::create([
            'country_id' => $this->countryId,
            'name' => $this->name,
        ]);
        $this->reset(); 
        $this->dispatchBrowserEvent('modal',['modalId' => '#stateModal','actionModal' => 'hide']);
        session()->flash('state-message','State Created Successfully');
    }

    public function updateState(){
        $validated = $this->validate([
            'countryId' => 'required',
            'name' => 'required',
        ]);
        $state = State::find($this->stateId);
        $state->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#stateModal','actionModal' => 'hide']);
        session()->flash('state-message','State Updated Successfully');
    }

    public function showStateModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#stateModal','actionModal' => 'show']);
    }

    public function closeModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#stateModal','actionModal' => 'hide']);
    }

    public function render()
    {
        $states = State::paginate(5);
        if(strlen($this->search) > 2 ){
            $states = State::where('name','like',"%{$this->search}%")->paginate(5);
        }
        return view('livewire.state.state-index',[
            'states' => $states,
        ])->layout('layouts.main');
    }
}
