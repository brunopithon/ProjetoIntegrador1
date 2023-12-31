<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\Product;	
use Livewire\WithPagination;

class ProductComponent extends Component
{

    	
    public $productId;

    use WithPagination;

    public $isOpen = 0;

    #[Rule('required|min:3')]
    public $name;

    #[Rule('required|min:10')]
    public $description;
 
    #[Rule('required|min:2')]
    public $price;
 
    public function create()
    {
        
        $this->reset('name','description', 'price','productId');
        $this->openModal();
    }

    public function store()
    {
        $this->validate();
        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price
        ]);
        session()->flash('success', 'Produto criado com sucesso!');
        
        $this->reset('name','description','price');
        $this->closeModal();
    }

    public function edit($id)
    {
        $product = product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
 
        $this->openModal();
    }

    public function update()
    {
        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
            ]);
            session()->flash('success', 'Produto atualizado com sucesso!');
            $this->closeModal();
            $this->reset('name', 'description','price', 'productId');
        }
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('success', 'Produto deletado com sucesso!');
        $this->reset('name', 'description','price');
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
        return view('livewire.product-component',[
            'products' => Product::paginate(5)
        ]);
    }
}
