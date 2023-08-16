<?php

namespace App\Http\Livewire;

use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Category;
use App\Models\Labor;
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
    public $dataRoomProduct = [];
    public $dataRoomLabor = [];
    public $dataBvProduct = [];
    public $dataBvLabor = [];
    public $dataLabor = [];
    public $dataFee = [];
    public $dataDiscount = [];
    public $feeDiscountTypes = [];
    public $dataStatus = [];
    public $listProducts = [];
    public $listLabors = [];
    public $total = 0;
    public $subtotal = 0;
    public $totalFee = 0;
    public $totalFeePercentage = 0;
    public $totalDiscount = 0;
    public $totalDiscountPercentage = 0;
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

        $total = 0;
        $arCategories = [];

        foreach ($categories as $categoryId) {
            $category = Category::find($categoryId);
            $categoryProducts = [];

            foreach ($budgetRoomProducts as $product) {
                if ($product->product->category_id == $categoryId) {
                    $bv = (int) $product->bv;

                    $obProduct = [
                        'id' => $product->id,
                        'name' => $product->product->name,
                        'quantity' => $product->quantity,
                        'days' => $product->days,
                        'price' => $bv > 0 ? $product->price + ($product->price * ($bv / 100)) : $product->price,
                        'bv' => $product->bv,
                        'place_room_id' => $product->place_room_id,
                    ];

                    $total += $obProduct['price'] * $obProduct['quantity'] * count(explode(',', $obProduct['days']));

                    array_push($categoryProducts, $obProduct);
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
            $bv = (int) $labor->bv;

            $obLabor = [
                'id' => $labor->id,
                'name' => $labor->labor->name,
                'quantity' => $labor->quantity,
                'days' => $labor->days,
                'price' => $bv > 0 ? $labor->price + ($labor->price * ($bv / 100)) : $labor->price,
                'bv' => $labor->bv,
                'place_room_id' => $labor->place_room_id,
            ];

            $total += $obLabor['price'] * $obLabor['quantity'] * $obLabor['days'];

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

        $this->listLabors = $arLabors;
        $this->subtotal = $total;
        $this->totalFee = 0;
        $this->totalFeePercentage = 0;
        $this->totalDiscount = 0;
        $this->totalDiscountPercentage = 0;
        $this->total = $total;

        if (!empty($this->budget->fee)) {
            if ($this->budget->fee_type == 'percent') {
                $feePercentage = $this->budget->fee;
                $this->totalFeePercentage = ($feePercentage / 100) * $total;
                $this->totalFee = $this->totalFeePercentage;
            } else {
                $this->totalFee = $this->budget->fee;
            }
        }

        if (!empty($this->budget->discount)) {
            if ($this->budget->discount_type == 'percent') {
                $discountPercentage = $this->budget->discount;
                $this->totalDiscountPercentage = ($discountPercentage / 100) * $total;
                $this->totalDiscount = $this->totalDiscountPercentage;
            } else {
                $this->totalDiscount = $this->budget->discount;
            }
        }

        $this->total = $this->subtotal - $this->totalDiscount + $this->totalFee;
    }

    public function render()
    {
        return view('budgets.livewire.mount');
    }

    public function addProduct()
    {
        $this->dataProduct = [];
        $this->emit('productError', null);
        return $this->emit('addProduct');
    }

    public function addLabor()
    {
        $this->dataLabor = [];
        $this->emit('laborError', null);
        return $this->emit('addLabor');
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
        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->observation = $this->dataBudget['observation'];
        $this->budget->saveQuietly();
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

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

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

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataLabor = [];
        $this->emit('laborSaved');

        return $this->mountBudget();
    }

    public function saveFee()
    {
        $errors = [];

        if (empty($this->dataFee['fee_type'])) {
            $errors['fee_type'] = 'o campo tipo de taxa do cartão é obrigatório';
        }

        if (empty($this->dataFee['fee'])) {
            $errors['fee'] = 'o campo taxa do cartão é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('feeError', $errors);
        } else {
            $this->emit('feeError', null);
        }

        $fee = str_replace('.', '', $this->dataFee['fee']);
        $fee = str_replace(',', '.', $fee);

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->fee_type = $this->dataFee['fee_type'];
        $this->budget->fee = $fee;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataFee = [];
        $this->emit('feeUpdated');

        return $this->mountBudget();
    }

    public function saveDiscount()
    {
        $errors = [];

        if (empty($this->dataDiscount['discount_type'])) {
            $errors['discount_type'] = 'o campo tipo de desconto é obrigatório';
        }

        if (empty($this->dataDiscount['discount'])) {
            $errors['discount'] = 'o campo desconto é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('discountError', $errors);
        } else {
            $this->emit('discountError', null);
        }

        if ($this->dataDiscount['discount_type'] == 'percent') {
            $this->budget->discount_type = $this->dataDiscount['discount_type'];
            $this->budget->discount = intval($this->dataDiscount['discount']);
        } else {
            $discount = str_replace('.', '', $this->dataDiscount['discount']);
            $discount = str_replace(',', '.', $discount);

            $this->budget->discount_type = $this->dataDiscount['discount_type'];
            $this->budget->discount = $discount;
        }

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataDiscount = [];
        $this->emit('discountUpdated');

        return $this->mountBudget();
    }

    public function saveStatus()
    {
        $errors = [];

        if (empty($this->dataStatus['status_id'])) {
            $errors['status_id'] = 'o campo status é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('statusError', $errors);
        } else {
            $this->emit('statusError', null);
        }

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->status_id = $this->dataStatus['status_id'];
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataStatus = [];
        $this->emit('statusUpdated');
    }

    public function updatePlaceRooms($type)
    {
        if (!empty($this->budget->place_id)) {
            $this->placeRooms = $this->budget->place->rooms->pluck('name', 'id')->prepend('Selecione', '');

            if ($type == 'product') {
                return $this->emit('openRoomProduct');
            }

            return $this->emit('openRoomLabor');
        }
    }

    public function confirmProductRemove(BudgetRoomProduct $budgetRoomProduct)
    {
        return $this->emit('confirmProductRemove', $budgetRoomProduct->id);
    }

    public function confirmLaborRemove(BudgetRoomLabor $budgetRoomLabor)
    {
        return $this->emit('confirmLaborRemove', $budgetRoomLabor->id);
    }

    public function removeProduct(BudgetRoomProduct $budgetRoomProduct)
    {
        $budgetRoomProduct->delete();

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function removeLabor(BudgetRoomLabor $budgetRoomLabor)
    {
        $budgetRoomLabor->delete();

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function removeFee()
    {
        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->fee_type = null;
        $this->budget->fee = null;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function removeDiscount()
    {
        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->discount_type = null;
        $this->budget->discount = null;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function saveChangeRoomProduct($products)
    {
        $errors = [];

        if (empty($this->dataRoomProduct['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('roomChangeProductError', $errors);
        } else {
            $this->emit('roomChangeProductError', null);
        }

        BudgetRoomProduct::whereIn('id', $products)->update([
            'place_room_id' => $this->dataRoomProduct['place_room_id'],
        ]);

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->emit('roomChangedProduct');

        return $this->mountBudget();
    }

    public function saveChangeRoomLabor($labors)
    {
        $errors = [];

        if (empty($this->dataRoomLabor['place_room_id'])) {
            $errors['place_room_id'] = 'o campo sala é obrigatório';
        }

        if (count($errors) > 0) {
            return $this->emit('roomChangeLaborError', $errors);
        } else {
            $this->emit('roomChangeLaborError', null);
        }

        BudgetRoomLabor::whereIn('id', $labors)->update([
            'place_room_id' => $this->dataRoomLabor['place_room_id'],
        ]);

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->emit('roomChangedLabor');

        return $this->mountBudget();
    }

    public function saveApplyBvProduct($products)
    {
        if (!empty($this->dataBvProduct['amount'])) {
            $bv = str_replace(',', '.', $this->dataBvProduct['amount']);
        } else {
            $bv = null;
        }

        BudgetRoomProduct::whereIn('id', $products)->update([
            'bv' => $bv,
        ]);

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataBvProduct = [];
        $this->emit('bvAppliedProduct');

        return $this->mountBudget();
    }

    public function saveApplyBvLabor($labors)
    {
        if (!empty($this->dataBvLabor['amount'])) {
            $bv = str_replace(',', '.', $this->dataBvLabor['amount']);
        } else {
            $bv = null;
        }

        BudgetRoomLabor::whereIn('id', $labors)->update([
            'bv' => $bv,
        ]);

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->dataBvLabor = [];
        $this->emit('bvAppliedLabor');

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

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function onChangeQuantity(BudgetRoomProduct $budgetRoomProduct, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomProduct->quantity = $quantity;
            $budgetRoomProduct->save();

            $this->budget->last_user_id = auth()->user()->id;
            $this->budget->saveQuietly();
            $this->budget->refresh();

            return $this->mountBudget();
        }
    }

    public function onChangeLaborQuantity(BudgetRoomLabor $budgetRoomLabor, $quantity)
    {
        if ($quantity > 0) {
            $budgetRoomLabor->quantity = $quantity;
            $budgetRoomLabor->save();

            $this->budget->last_user_id = auth()->user()->id;
            $this->budget->saveQuietly();
            $this->budget->refresh();

            return $this->mountBudget();
        }
    }

    public function onChangeLaborDays(BudgetRoomLabor $budgetRoomLabor, $days)
    {
        if ($days > 0) {
            $budgetRoomLabor->days = $days;
            $budgetRoomLabor->save();

            $this->budget->last_user_id = auth()->user()->id;
            $this->budget->saveQuietly();
            $this->budget->refresh();

            return $this->mountBudget();
        }
    }

    public function onChangeProductRoom(BudgetRoomProduct $budgetRoomProduct, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $budgetRoomProduct->place_room_id = $placeRoomId;
        } else {
            $budgetRoomProduct->place_room_id = null;
        }

        $budgetRoomProduct->save();

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function onChangeLaborRoom(BudgetRoomLabor $budgetRoomLabor, $placeRoomId)
    {
        if (!empty($placeRoomId)) {
            $budgetRoomLabor->place_room_id = $placeRoomId;
        } else {
            $budgetRoomLabor->place_room_id = null;
        }

        $budgetRoomLabor->save();

        $this->budget->last_user_id = auth()->user()->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        return $this->mountBudget();
    }

    public function generateNewVersion()
    {
        $status = Status::where('slug', 'revisao')->first();

        $this->budget->budget_version = $this->budget->budget_version + 1;
        $this->budget->status_id = $status->id;
        $this->budget->saveQuietly();
        $this->budget->refresh();

        $this->emit('newVersionGenerated');
    }
}
