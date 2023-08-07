<?php

namespace App\Http\Livewire;

use App\Models\Budget;
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
    public $labors = [];
    public $products = [];
    public $placeRooms = [];
    public $rooms = [];
    public $discountTypes = [];
    public $status = [];
    public $dataBudget = [];
    public $dataProduct = [];
    public $dataRoom = [];
    public $dataLabor = [];
    public $dataFee = [];
    public $dataDiscount = [];
    public $feeDiscountTypes = [];
    public $dataStatus = [];
    public $listProducts = [];
    public $listLabors = [];
    public $canEdit = false;

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->prepend('Selecione', '');
        $this->labors = Labor::pluck('name', 'id')->prepend('Selecione', '');

        if (!empty($this->budget->place_id)) {
            $this->placeRooms = $this->budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');
        }

        $this->feeDiscountTypes = [
            '' => 'Selecione',
            'percent' => 'Porcentagem',
            'money' => 'Valor',
        ];
        $this->status = Status::pluck('name', 'id')->prepend('Selecione', '');

        if ($this->budget->status->slug == 'aberto' || $this->budget->status->slug == 'revisao' || $this->budget->status->slug == 'enviado') {
            $this->canEdit = true;
        }

        $this->mountBudget();
    }

    public function mountBudget()
    {
        $this->dataProduct = [];
        $this->dataLabor = [];

        $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $this->budget->id)->get();
        $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $this->budget->id)->get();

        $categories = Product::whereIn('id', $budgetRoomProducts->pluck('product_id')->toArray())->groupBy('category_id')->pluck('category_id')->toArray();

        $arCategories = [];

        foreach ($categories as $categoryId) {
            $category = Category::find($categoryId);
            $categoryProducts = [];

            foreach ($budgetRoomProducts as $product) {
                if ($product->product->category_id == $categoryId) {
                    array_push($categoryProducts, $product->toArray());
                }
            }

            $obCategory = [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $categoryProducts,
            ];

            array_push($arCategories, $obCategory);
        }

        $arLabors = [];

        foreach ($budgetRoomLabors as $labor) {
            $obLabor = [
                'id' => $labor->labor->id,
                'name' => $labor->labor->name,
                'quantity' => $labor->quantity,
                'days' => $labor->days,
                'price' => $labor->price,
            ];

            array_push($arLabors, $obLabor);
        }

        $budgetDays = explode('-', $this->budget->budget_days);
        $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
        $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

        if ($startDay == $endDay) {
            $days = [Carbon::parse($startDay)->format('d/m')];
        } else {
            $difDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

            $days = [];

            array_push($days, Carbon::parse($startDay)->format('d/m'));

            for ($i = 0; $i < $difDays; $i++) {
                $date = Carbon::parse($startDay)->addDays($i + 1);
                array_push($days, $date->format('d/m'));
            }

            array_push($days, Carbon::parse($endDay)->format('d/m'));
        }

        $this->listProducts = [
            'days' => $days,
            'categories' => $arCategories,
        ];

        $this->listLabors = [
            'days' => $days,
            'labors' => $arLabors,
        ];

        // dd($this->listProducts);
    }

    public function getRooms()
    {
        $budgetRoomProducts = BudgetRoomProduct::where('budget_id', $this->budget->id)->pluck('place_room_id')->toArray();
        $budgetRoomLabors = BudgetRoomLabor::where('budget_id', $this->budget->id)->pluck('place_room_id')->toArray();
        $placeRoomIds = array_unique(array_merge($budgetRoomProducts, $budgetRoomLabors));

        $arRoom = [];

        foreach ($placeRoomIds as $placeRoomId) {
            $placeRoom = PlaceRoom::find($placeRoomId);

            // $products = BudgetRoomProduct::where('budget_id', $this->budget->id)->where('place_room_id', $placeRoom->id);
            $products = BudgetRoomProduct::where('budget_id', $this->budget->id);
            $productsId = $products->pluck('product_id')->toArray();
            $productsList = $products->get();
            // $labors = BudgetRoomLabor::where('budget_id', $this->budget->id)->where('place_room_id', $placeRoom->id);
            $labors = BudgetRoomLabor::where('budget_id', $this->budget->id);
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

            if ($startDay == $endDay) {
                $days = [Carbon::parse($startDay)->format('d/m')];
            } else {
                $difDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

                $days = [];

                array_push($days, Carbon::parse($startDay)->format('d/m'));

                for ($i = 0; $i < $difDays; $i++) {
                    $date = Carbon::parse($startDay)->addDays($i + 1);
                    array_push($days, $date->format('d/m'));
                }

                array_push($days, Carbon::parse($endDay)->format('d/m'));
            }

            $arRoom[] = [
                // 'place_room_name' => $placeRoom->name,
                // 'place_room_id' => $placeRoom->id,
                'place_room_name' => 'xxx',
                'place_room_id' => 1,
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

    public function editStatus()
    {
        $this->emit('editStatus');
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
        $this->dataProduct['price'] = $product->price;

        $this->emit('updateProductPrice', $product->price);
    }

    public function onSelectLabor(Labor $labor)
    {
        $this->dataLabor['price'] = $labor->price;

        $this->emit('updateLaborPrice', $labor->price);
    }

    public function saveObservation()
    {
        $this->budget->update($this->dataBudget);
        $this->budget->refresh();

        $this->dataBudget = [];
        $this->emit('observationUpdated');
    }

    public function saveProduct()
    {
        $errors = [];

        if (empty($this->dataProduct['category_id'])) {
            $errors['category_id'] = 'o campo categoria é obrigatório';
        }

        if (empty($this->dataProduct['product_id'])) {
            $errors['product_id'] = 'o campo equipamento é obrigatório';
        }

        if (empty($this->dataProduct['price'])) {
            $errors['price'] = 'o campo preço é obrigatório';
        }

        if (empty($this->dataProduct['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('productError', $errors);
        } else {
            $this->emit('productError', null);
        }

        $budgetDays = explode('-', $this->budget->budget_days);
        $startDay = implode('-', array_reverse(explode('/', trim($budgetDays[0]))));
        $endDay = implode('-', array_reverse(explode('/', trim($budgetDays[1]))));

        if ($startDay == $endDay) {
            $days = [Carbon::parse($startDay)->format('d/m')];
        } else {
            $difDays = Carbon::parse($startDay)->diffInDays(Carbon::parse($endDay)) - 1;

            $days = [];

            array_push($days, Carbon::parse($startDay)->format('d/m'));

            for ($i = 0; $i < $difDays; $i++) {
                $date = Carbon::parse($startDay)->addDays($i + 1);
                array_push($days, $date->format('d/m'));
            }

            array_push($days, Carbon::parse($endDay)->format('d/m'));
        }

        BudgetRoomProduct::create([
            'budget_id' => $this->budget->id,
            'place_room_id' => !empty($this->dataProduct['place_room_id']) ? $this->dataProduct['place_room_id'] : null,
            'product_id' => $this->dataProduct['product_id'],
            'days' => implode(',', $days),
            'quantity' => $this->dataProduct['quantity'],
            'price' => $this->dataProduct['price'],
        ]);

        $this->dataProduct = [];
        $this->emit('productSaved');

        return $this->mountBudget();
    }

    public function saveLabor()
    {
        $errors = [];

        if (empty($this->dataLabor['labor_id'])) {
            $errors['labor_id'] = 'o campo mão de obra é obrigatório';
        }

        if (empty($this->dataLabor['price'])) {
            $errors['price'] = 'o campo preço é obrigatório';
        }

        if (empty($this->dataLabor['quantity'])) {
            $errors['quantity'] = 'o campo quantidade é obrigatório';
        }

        if (empty($this->dataLabor['days'])) {
            $errors['quantity'] = 'o campo dias é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('laborError', $errors);
        } else {
            $this->emit('laborError', null);
        }

        BudgetRoomLabor::create([
            'budget_id' => $this->budget->id,
            'place_room_id' => !empty($this->dataLabor['place_room_id']) ? $this->dataLabor['place_room_id'] : null,
            'labor_id' => $this->dataLabor['labor_id'],
            'days' => $this->dataLabor['days'],
            'quantity' => $this->dataLabor['quantity'],
            'price' => $this->dataLabor['price'],
        ]);

        $this->dataLabor = [];
        $this->emit('laborSaved');

        return $this->mountBudget();
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

        $fee = str_replace('.', '', $this->dataFee['fee']);
        $fee = str_replace(',', '.', $fee);

        $this->budget->update([
            'fee_type' => $this->dataFee['fee_type'],
            'fee' => $fee,
        ]);

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
        if (empty($this->dataStatus['status_id'])) {
            return $this->emit('statusError', true);
        }

        $this->emit('statusError', false);

        $this->budget->update([
            'status_id' => $this->dataStatus['status_id']
        ]);

        $this->dataStatus = [];
        $this->emit('statusUpdated');
    }

    public function confirmProductRemove(BudgetRoomProduct $budgetRoomProduct)
    {
        return $this->emit('confirmProductRemove', $budgetRoomProduct->id);
    }

    public function removeProduct(BudgetRoomProduct $budgetRoomProduct)
    {
        $budgetRoomProduct->delete();

        return $this->mountBudget();
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

    public function saveChangeRoom($products)
    {
        BudgetRoomProduct::whereIn('id', $products)->update([
            'place_room_id' => $this->dataRoom['place_room_id'],
        ]);

        $this->emit('roomChanged');

        return $this->mountBudget();
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

    public function onChangeRoom(BudgetRoomProduct $budgetRoomProduct, $placeRoomId)
    {
        $budgetRoomProduct->place_room_id = $placeRoomId;
        $budgetRoomProduct->save();

        return $this->mountBudget();
    }

    public function generateNewVersion()
    {
        $status = Status::where('slug', 'revisao')->first();

        $this->budget->update([
            'budget_version' => $this->budget->budget_version + 1,
            'status_id' => $status->id,
        ]);

        return $this->emit('saved');
    }
}
