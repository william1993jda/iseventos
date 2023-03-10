<?php

namespace App\Http\Livewire;

use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Category;
use App\Models\Labor;
use App\Models\PlaceRoom;
use App\Models\Product;
use App\Models\Status;
use Carbon\Carbon;
use Livewire\Component;

class BudgetMountLivewire extends Component
{
    public $budget;
    public $categories = [];
    public $products = [];
    public $placeRooms = [];
    public $rooms = [];
    public $discountTypes = [];
    public $status = [];
    public $dataBudget = [];
    public $dataProduct = [];
    public $dataLabor = [];
    public $dataFee = [];
    public $dataDiscount = [];
    public $feeDiscountTypes = [];
    public $dataStatus = [];

    public function mount($budget)
    {
        $this->categories = Category::pluck('name', 'id')->prepend('Selecione', '');
        $this->placeRooms = $budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');
        $this->feeDiscountTypes = [
            '' => 'Selecione',
            'percent' => 'Porcentagem',
            'money' => 'Valor',
        ];
        $this->status = Status::pluck('name', 'id')->prepend('Selecione', '');

        $this->getRooms();
    }

    public function getRooms()
    {
        $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $this->budget->id)->pluck('place_room_id')->toArray();
        $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $this->budget->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($budgetRoomProducts, $budgetRoomLabors));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            $products = BudgetRoomProduct::where('budget_id', $this->budget->id)->where('place_room_id', $placeRoom->id);
            $productsId = $products->pluck('product_id')->toArray();
            $productsList = $products->get();
            $labors = BudgetRoomLabor::where('budget_id', $this->budget->id)->where('place_room_id', $placeRoom->id);
            $laborsId = $labors->pluck('labor_id')->toArray();
            $laborsList = $labors->get();
            $categoryProductsId = Product::whereIn('id', $productsId)->groupBy('category_id')->pluck('category_id')->toArray();
            $categoryLaborsId = Labor::whereIn('id', $laborsId)->groupBy('category_id')->pluck('category_id')->toArray();
            $categoriesId = array_unique(array_merge($categoryProductsId, $categoryLaborsId));

            $arCategories = [];

            foreach ($categoriesId as $categoryId) {
                $category = Category::find($categoryId);
                $categoryProducts = [];
                $categoryLabors = [];

                foreach ($productsList as $product) {
                    if ($product->product->category_id == $categoryId) {
                        array_push($categoryProducts, $product->toArray());
                    }
                }

                foreach ($laborsList as $labor) {
                    if ($labor->labor->category_id == $categoryId) {
                        array_push($categoryLabors, $labor->toArray());
                    }
                }

                // dd($categoryProducts);

                $obCategory = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'products' => $categoryProducts,
                    'labors' => $categoryLabors,
                ];

                array_push($arCategories, $obCategory);
            }

            $budgetDays = explode('-', $this->budget->budget_days);
            $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
            $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

            $diifDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

            $days = [];

            array_push($days, Carbon::parse($startDay)->format('d/m'));

            for ($i = 0; $i < $diifDays; $i++) {
                $date = Carbon::parse($startDay)->addDays($i + 1);
                array_push($days, $date->format('d/m'));
            }

            array_push($days, Carbon::parse($endDay)->format('d/m'));

            $arRoom[] = [
                'place_room_name' => $placeRoom->name,
                'place_room_id' => $placeRoom->id,
                'days' => $days,
                'categories' => $arCategories,
            ];
        }

        $this->rooms = $arRoom;

        // dd($this->rooms);
    }

    public function render()
    {
        return view('budgets.livewire.mount');
    }

    public function addProduct()
    {
        $this->emit('addProduct');
    }

    public function addLabor()
    {
        $this->emit('addLabor');
    }

    public function addFee()
    {
        $this->emit('addFee');
    }

    public function addDiscount()
    {
        $this->emit('addDiscount');
    }

    public function addStatus()
    {
        $this->emit('addStatus');
    }

    public function editObservation()
    {
        $this->dataBudget['observation'] = $this->budget->observation;
        $this->emit('editObservation');
    }

    public function onSelectCategory(Category $category)
    {
        $products = $category->products->pluck('name', 'id');

        $this->emit('updateProductList', $products);
    }

    public function onSelectCategoryLabor(Category $category)
    {
        $labors = $category->labors->pluck('name', 'id');

        $this->emit('updateLaborList', $labors);
    }

    public function onSelectProduct(Product $product)
    {
        $this->dataProduct['price'] = $product->getPriceFormated();

        $this->emit('updateProductPrice', $product->getPriceFormated());
    }

    public function onSelectLabor(Labor $labor)
    {
        $this->dataLabor['price'] = $labor->getPriceFormated();

        $this->emit('updateLaborPrice', $labor->getPriceFormated());
    }

    public function saveObservation()
    {
        $this->budget->update($this->dataBudget);

        return $this->emit('editObservation');
    }

    public function saveProduct()
    {
        // $this->validate([
        //     'dataProduct.category_id' => 'required',
        //     'dataProduct.product_id' => 'required',
        //     'dataProduct.place_room_id' => 'required',
        //     'dataProduct.price' => 'required',
        //     'dataProduct.quantity' => 'required',
        // ], [], [
        //     'dataProduct.category_id' => 'categoria',
        //     'dataProduct.product_id' => 'equipamento',
        //     'dataProduct.place_room_id' => 'sala',
        //     'dataProduct.price' => 'preço',
        //     'dataProduct.quantity' => 'quantidade',
        // ]);

        if (empty($this->dataProduct['category_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['product_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['place_room_id'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['price'])) {
            return $this->emit('productError', true);
        }

        if (empty($this->dataProduct['quantity'])) {
            return $this->emit('productError', true);
        }

        $this->emit('productError', false);

        $budgetDays = explode('-', $this->budget->budget_days);
        $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
        $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

        $diifDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

        $days = [];

        array_push($days, Carbon::parse($startDay)->format('d/m'));

        for ($i = 0; $i < $diifDays; $i++) {
            $date = Carbon::parse($startDay)->addDays($i + 1);
            array_push($days, $date->format('d/m'));
        }

        array_push($days, Carbon::parse($endDay)->format('d/m'));

        BudgetRoomProduct::create([
            'budget_id' => $this->budget->id,
            'place_room_id' => $this->dataProduct['place_room_id'],
            'product_id' => $this->dataProduct['product_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataProduct['quantity'],
            'price' => $this->dataProduct['price'],
        ]);

        $this->dataProduct = [];

        return $this->emit('saved');
    }

    public function saveLabor()
    {
        // $this->validate([
        //     'dataLabor.category_id' => 'required',
        //     'dataLabor.labor_id' => 'required',
        //     'dataLabor.place_room_id' => 'required',
        //     'dataLabor.price' => 'required',
        //     'dataLabor.quantity' => 'required',
        // ], [], [
        //     'dataLabor.category_id' => 'categoria',
        //     'dataLabor.labor_id' => 'equipamento',
        //     'dataLabor.place_room_id' => 'sala',
        //     'dataLabor.price' => 'preço',
        //     'dataLabor.quantity' => 'quantidade',
        // ]);

        if (empty($this->dataLabor['category_id'])) {
            return $this->emit('laborError', true);
        }

        if (empty($this->dataLabor['labor_id'])) {
            return $this->emit('laborError', true);
        }

        if (empty($this->dataLabor['place_room_id'])) {
            return $this->emit('laborError', true);
        }

        if (empty($this->dataLabor['price'])) {
            return $this->emit('laborError', true);
        }

        if (empty($this->dataLabor['quantity'])) {
            return $this->emit('laborError', true);
        }

        if (empty($this->dataLabor['days'])) {
            return $this->emit('laborError', true);
        }

        $this->emit('laborError', false);

        BudgetRoomLabor::create([
            'budget_id' => $this->budget->id,
            'place_room_id' => $this->dataLabor['place_room_id'],
            'labor_id' => $this->dataLabor['labor_id'],
            'days' => $this->dataLabor['days'],
            'quantity' => $this->dataLabor['quantity'],
            'price' => $this->dataLabor['price'],
        ]);

        $this->dataLabor = [];

        return $this->emit('saved');
    }

    public function saveFee()
    {
        // $this->validate([
        //     'dataFee.fee_type' => 'required',
        //     'dataFee.fee' => 'required',
        // ], [], [
        //     'dataFee.fee_type' => 'tipo de taxa',
        //     'dataFee.fee' => 'taxa',
        // ]);

        if (empty($this->dataFee['fee_type'])) {
            return $this->emit('feeError', true);
        }

        if (empty($this->dataFee['fee'])) {
            return $this->emit('feeError', true);
        }

        $this->emit('feeError', false);

        if ($this->dataFee['fee_type'] == 'percent') {
            $this->budget->update([
                'fee_type' => $this->dataFee['fee_type'],
                'fee' => intval($this->dataFee['fee']),
            ]);
        } else {
            $fee = str_replace('.', '', $this->dataFee['fee']);
            $fee = str_replace(',', '.', $fee);

            $this->budget->update([
                'fee_type' => $this->dataFee['fee_type'],
                'fee' => $fee,
            ]);
        }

        return $this->emit('saved');
    }

    public function saveDiscount()
    {
        // $this->validate([
        //     'dataDiscount.discount_type' => 'required',
        //     'dataDiscount.discount' => 'required',
        // ], [], [
        //     'dataDiscount.discount_type' => 'tipo de desconto',
        //     'dataDiscount.discount' => 'desconto',
        // ]);

        if (empty($this->dataDiscount['discount_type'])) {
            return $this->emit('discountError', true);
        }

        if (empty($this->dataDiscount['discount'])) {
            return $this->emit('discountError', true);
        }

        $this->emit('discountError', false);

        if ($this->dataDiscount['discount_type'] == 'percent') {
            $this->budget->update([
                'discount_type' => $this->dataDiscount['discount_type'],
                'discount' => intval($this->dataDiscount['discount']),
            ]);
        } else {
            $discount = str_replace('.', '', $this->dataDiscount['discount']);
            $discount = str_replace(',', '.', $discount);

            $this->budget->update([
                'discount_type' => $this->dataDiscount['discount_type'],
                'discount' => $discount,
            ]);
        }

        return $this->emit('saved');
    }

    public function saveStatus()
    {
        // $this->validate([
        //     'dataStatus.status_id' => 'required',
        // ], [], [
        //     'dataStatus.status_id' => 'status',
        // ]);

        if (empty($this->dataStatus['status_id'])) {
            return $this->emit('statusError', true);
        }

        $this->emit('statusError', false);

        $this->budget->update([
            'status_id' => $this->dataStatus['status_id']
        ]);

        return $this->emit('saved');
    }

    public function removeFee()
    {
        $this->budget->update([
            'fee_type' => null,
            'fee' => null,
        ]);

        return $this->emit('saved');
    }

    public function removeDiscount()
    {
        $this->budget->update([
            'discount_type' => null,
            'discount' => null,
        ]);

        return $this->emit('saved');
    }

    public function checkDayRoom(BudgetRoomProduct $budgetRoomProduct, $roomDate)
    {
        $days = explode(',', $budgetRoomProduct->days);

        if (in_array($roomDate, $days)) {
            unset($days[array_search($roomDate, $days)]);
        } else {
            $days[] = $roomDate;
        }

        $budgetRoomProduct->days = implode(',', $days);
        $budgetRoomProduct->save();

        // $this->getRooms();
        return $this->emit('saved');
    }

    public function onChangeQuantity(BudgetRoomProduct $budgetRoomProduct, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomProduct->quantity = $quantity;
            $budgetRoomProduct->save();

            // $this->dataProduct = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }

    public function onChangeLaborQuantity(BudgetRoomLabor $budgetRoomLabor, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomLabor->quantity = $quantity;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }

    public function onChangeLaborDays(BudgetRoomLabor $budgetRoomLabor, $days)
    {
        if ($days > 0) {
            $budgetRoomLabor->days = $days;
            $budgetRoomLabor->save();

            // $this->dataLabor = [];
            // $this->getRooms();
            return $this->emit('saved');
        }
    }
}
