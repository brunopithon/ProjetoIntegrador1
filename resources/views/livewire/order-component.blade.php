<div>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>                
                    @if (session()->has('success'))
                        <div class="relative flex flex-col sm:flex-row sm:items-center bg-gray-200 dark:bg-green-700 shadow rounded-md py-5 pl-6 pr-8 sm:pr-6 mb-3 mt-3">
                            <div class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0">
                                <div class="text-green-500" dark:text-gray-500>
                                    <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="text-sm font-medium ml-3">Sucesso!</div>
                            </div>
                            <div class="text-sm tracking-wide text-gray-500 dark:text-white mt-4 sm:mt-0 sm:ml-4"> {{ session('success') }}</div>
                            <div class="absolute sm:relative sm:top-auto sm:right-auto ml-auto right-4 top-4 text-gray-400 hover:text-gray-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                        </div>
                    @endif
                    
                    <div class="my-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="create">Adicionar pedido</button>
                    </div>
                    @if($isOpen)
                    <div class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="absolute inset-0 bg-black opacity-50"></div>
                        <div class="relative bg-gray-200 p-8 rounded shadow-lg w-1/2">
                            <!-- Modal content goes here -->
                            <svg wire:click.prevent="$set('isOpen', false)"
                            class="ml-auto w-6 h-6 text-gray-900 dark:text-gray-900 cursor-pointer fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                           <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                       </svg>
                       <h2 class="text-2xl font-bold mb-4">{{ $orderId ? 'Editar pedido' : 'Cria pedido' }}</h2>                            	
                            <form wire:submit.prevent="{{ $orderId ? 'update' : 'store' }}">

                            <div class="mb-4">
                                    <label for="table_id" class="block text-gray-700 font-bold mb-2">Mesa:</label>                                    
                                    <select wire:model="table_id" class="w-full border border-gray-300 px-4 py-2 rounded">
                                        <option value="">Selecione uma mesa</option> 
                                        @foreach (\App\Models\Table::all() as $table)
                                            <option value="{{ $table->id }}">{{ $table->number }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500">@error('table_id') {{ $message }} @enderror</span>
                                </div>

                                <div class="mb-4">
                                    <label for="product_id" class="block text-gray-700 font-bold mb-2">Produto:</label>                                    
                                    <select wire:model="product_id" class="w-full border border-gray-300 px-4 py-2 rounded">
                                        <option value="">Selecione um produto</option> 
                                        @foreach (\App\Models\Product::all() as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500">@error('product_id') {{ $message }} @enderror</span>
                                </div>

                                <div class="mb-4">
                                    <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantidade:</label>
                                    <input type="text" wire:model="quantity" id="quantity" class="w-full border border-gray-300 px-4 py-2 rounded">	
                                    <span class="text-red-500">@error('quantity') {{ $message }} @enderror</span>
                                </div>

                                <div class="mb-4">
                                <label for="status" class="block text-gray-700 font-bold mb-2">Status:</label>
                                <select wire:model="status" id="status" class="w-full border border-gray-300 px-4 py-2 rounded" selected="Pedido feito">
                                    <option value="Pedido feito">Pedido feito</option>
                                    <option value="Aguardando preparo">Aguardando preparo</option>
                                    <option value="Preparando">Preparando</option>                                    
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Pedido pago">Pedido pago</option>
                                </select>
                                <span class="text-red-500">@error('status') {{ $message }} @enderror</span>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mr-2">{{ $orderId ? 'Atualizar' : 'Criar' }}</button>
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" wire:click="closeModal">Cancelar</button>
                                </div>
                            </form>
 
                        </div>
                    </div>
                    @endif
                </section>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 w-full">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Mesa
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Produto
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantidade
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        @forelse ($orders as $order)
                        <tbody wire:key="{{ $order->id }}>
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @php
                                        $table = \App\Models\Table::where('id', $order->table_id)->first();
                                    @endphp
                                    {{ $table ? $table->number : 'Mesa não encontrada' }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @php
                                        $product = \App\Models\Product::where('id', $order->product_id)->first();
                                    @endphp
                                    {{$product ? $product->name : 'Produto não encontrado'}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$order->quantity}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$order->status}}
                                </td>
 
                                <td class="px-6 py-4 flex items-center justify-center space-x-0">
                                    <button class="" wire:click="edit({{ $order->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 mt-0 w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                          </svg>
                                    </button>
 
                                    <button class="" wire:click="delete({{ $order->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 mt-0 w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg> 
                                    </button>
                                </td>
                            </tr>
 
                        </tbody>
                        @empty
                    <p>Nenhum pedido encontrado</p>
                @endforelse
                    </table>                    	
                        {{ $orders->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
