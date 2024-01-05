<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\Order;	
use App\Models\Product;
use App\Models\Table;
use Livewire\WithPagination;

class OrderComponent extends Component
{

    	
    public $orderId;

    use WithPagination;

    public $isOpen = 0;

    #[Rule('required')]
    public $table_id;

    #[Rule('required')]
    public $product_id;
 
    #[Rule('required|min:1')]
    public $quantity;

    #[Rule('required')]
    public $status;
 
    public function create()
    {
        
        $this->reset('table_id','product_id', 'quantity','status', 'orderId');
        $this->openModal();
    }

    public function store()
    {
        $this->validate();
        Order::create([
            'table_id' => $this->table_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'status' => $this->status
        ]);
        session()->flash('success', 'Pedido criado com sucesso!');
        
        $this->reset('table_id','product_id', 'quantity','status', 'orderId');
        $this->closeModal();
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $this->orderId = $id;
        $this->table_id = $order->table_id;
        $this->product_id = $order->product_id;
        $this->quantity = $order->quantity;
        $this->status = $order->status;
        
 
        $this->openModal();
    }

    public function update()
    {
        if ($this->orderId) {
            $order = Order::findOrFail($this->orderId);
            $order->update([
                'table_id' => $this->table_id,
                'product_id' =>$this->product_id,
                'quantity' => $this->quantity,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Pedido atualizado com sucesso!');
            $this->closeModal();
            $this->reset('table_id','product_id', 'quantity','status', 'orderId');
        }
    }

    public function delete($id)
    {
        Order::find($id)->delete();
        session()->flash('success', 'Pedido deletado com sucesso!');
        $this->reset('table_id','product_id', 'quantity','status', 'orderId');
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
        return view('livewire.order-component',[
            'orders' => Order::paginate(5)
        ]);
    }
}
