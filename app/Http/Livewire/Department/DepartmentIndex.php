<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;

class DepartmentIndex extends Component
{
    public $search = '';
    public $name;
    public $editMode = false;
    public $departmentId;

    public $rules = [
        'name' => 'required',
    ];

    public function showEditModal($id){
        $this->reset();
        $this->departmentId = $id;
        $this->loadDepartments();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal',['modalId' => '#departmentModal','actionModal' => 'show']);
    }

    public function loadDepartments() {
        $department = Department::find($this->departmentId);
        $this->name = $department->name;
    }

    public function deleteDepartment($id){
        $department = Department::find($id);
        $department->delete();
        $this->reset();
        session()->flash('department-message','Department Deleted Successfully');
    }

    public function storeDepartment(){
        $this->validate();
        Department::create([
            'name' => $this->name,
        ]);
        $this->reset(); 
        $this->dispatchBrowserEvent('modal',['modalId' => '#departmentModal','actionModal' => 'hide']);
        session()->flash('department-message','Department Created Successfully');
    }

    public function updateDepartment(){
        $validated = $this->validate([
            'name' => 'required',
        ]);
        $department = Department::find($this->departmentId);
        $department->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#departmentModal','actionModal' => 'hide']);
        session()->flash('department-message','Department Updated Successfully');
    }

    public function showDepartmentModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#departmentModal','actionModal' => 'show']);
    }

    public function closeModal(){
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId' => '#departmentModal','actionModal' => 'hide']);
    }

    public function render()
    {
        $departments = Department::paginate(5);
        if(strlen($this->search) > 2 ){
            $departments = Department::where('name','like',"%{$this->search}%")->paginate(5);
        }
        return view('livewire.department.department-index',[
            'departments' => $departments,
        ])->layout('layouts.main');
    }
}
