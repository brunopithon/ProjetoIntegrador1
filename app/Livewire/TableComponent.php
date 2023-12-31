<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\Table;	
use Livewire\WithPagination;

class TableComponent extends Component
{

    	
    public $tableId;

    use WithPagination;

    public $isOpen = 0;

    #[Rule('required|min:1')]
    public $number;

    #[Rule('required|min:5')]
    public $description;
 
    public function create()
    {
        
        $this->reset('number','description','tableId');
        $this->openModal();
    }

    public function store()
    {
        $this->validate();
        Table::create([
            'number' => $this->number,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Produto criado com sucesso!');
        
        $this->reset('number','description');
        $this->closeModal();
    }

    public function edit($id)
    {
        $table = table::findOrFail($id);
        $this->tableId = $id;
        $this->number = $table->number;
        $this->description = $table->description;
 
        $this->openModal();
    }

    public function update()
    {
        if ($this->tableId) {
            $table = Table::findOrFail($this->tableId);
            $table->update([
                'number' => $this->number,
                'description' => $this->description,
            ]);
            session()->flash('success', 'Produto atualizado com sucesso!');
            $this->closeModal();
            $this->reset('number', 'description', 'tableId');
        }
    }

    public function delete($id)
    {
        Table::find($id)->delete();
        session()->flash('success', 'Produto deletado com sucesso!');
        $this->reset('number', 'description');
    }

    public function openModal()
    {
        $this->isOpen = true;        	
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.table-component',[
            'tables' => Table::paginate(5)
        ]);
    }
}
