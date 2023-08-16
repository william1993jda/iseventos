<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use App\Models\Budget;
use App\Models\BudgetRoomLabor;
use App\Models\BudgetRoomProduct;
use App\Models\Customer;
use App\Models\Freelancer;
use App\Models\OrderService;
use App\Models\OrderServiceRoomFreelancer;
use App\Models\OrderServiceRoomGroup;
use App\Models\OrderServiceRoomProduct;
use App\Models\OrderServiceRoomProvider;
use App\Models\OsProduct;
use App\Models\OsStatus;
use App\Models\Place;
use App\Models\Provider;
use App\Models\Status;
use App\Models\SubleaseItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function events(Request $request)
    {
        $places = Place::pluck('name', 'id')->prepend('Selecione', '');
        $customers = Customer::pluck('fantasy_name', 'id')->prepend('Selecione', '');
        $statusApproved = Status::where('slug', 'aprovado')->first();

        $params = $request->all();
        $query = [
            'name' => '',
            'budget_days' => '',
            'place_id' => '',
            'customer_id' => '',
            'status_id' => '',
        ];

        $budgets = Budget::where('status_id', $statusApproved->id)->orderBy('name', 'ASC');

        if (!empty($params)) {
            if (!empty($params['name'])) {
                $query['name'] = $params['name'];
                $budgets->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (!empty($params['budget_days'])) {
                $query['budget_days'] = $params['budget_days'];

                $budgetDays = explode('-', $params['budget_days']);
                $start = explode('/', trim($budgetDays[0]));
                $startDay = $start[2] . '-' . $start[1] . '-' . $start[0];
                $end = explode('/', trim($budgetDays[1]));
                $endDay = $end[2] . '-' . $end[1] . '-' . $end[0];

                $budgets->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budget_days, ' - ', 1), '%d/%m/%Y') >= '" . $startDay . "'");
                $budgets->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(budget_days, ' - ', 1), '%d/%m/%Y') <= '" . $endDay . "'");
            }

            if (!empty($params['place_id'])) {
                $query['place_id'] = $params['place_id'];
                $budgets->where('place_id', $params['place_id']);
            }

            if (!empty($params['customer_id'])) {
                $query['customer_id'] = $params['customer_id'];
                $budgets->where('customer_id', $params['customer_id']);
            }
        }

        $budgets = $budgets->paginate(30);

        $budgets->getCollection()->transform(function ($budget) {
            $total = 0;
            $subtotal = 0;
            $totalDiscount = 0;
            $totalDiscountPercentage = 0;
            $totalFee = 0;
            $totalFeePercentage = 0;

            $products = BudgetRoomProduct::where('budget_id', $budget->id)->get();

            foreach ($products as $product) {
                $bv = (int) $product->bv;
                $price = $bv > 0 ? $product->price + ($product->price * ($bv / 100)) : $product->price;

                $total += $price * $product->quantity * count(explode(',', $product->days));
            }

            $labors = BudgetRoomLabor::where('budget_id', $budget->id)->get();

            foreach ($labors as $labor) {
                $bv = (int) $labor->bv;
                $price = $bv > 0 ? $labor->price + ($labor->price * ($bv / 100)) : $labor->price;

                $total += $price * $labor->quantity * $labor->days;
            }

            $subtotal = $total;

            if (!empty($budget->fee)) {
                if ($budget->fee_type == 'percent') {
                    $feePercentage = $budget->fee;
                    $totalFeePercentage = ($feePercentage / 100) * $total;
                    $totalFee = $totalFeePercentage;
                } else {
                    $totalFee = $budget->fee;
                }
            }

            if (!empty($budget->discount)) {
                if ($budget->discount_type == 'percent') {
                    $discountPercentage = $budget->discount;
                    $totalDiscountPercentage = ($discountPercentage / 100) * $total;
                    $totalDiscount = $totalDiscountPercentage;
                } else {
                    $totalDiscount = $budget->discount;
                }
            }

            $total = $subtotal - $totalDiscount + $totalFee;

            $budget->total = $total;
            return $budget;
        });

        return view('reports.events', compact('budgets', 'places', 'customers', 'query'));
    }

    public function products()
    {
        $arProducts = [];

        $orderServiceRoomGroups = OrderServiceRoomGroup::get();

        foreach ($orderServiceRoomGroups as $orderServiceRoomGroup) {
            foreach ($orderServiceRoomGroup->group->products as $product) {
                if (!isset($arProducts[$product->os_product_id]))
                    $arProducts[$product->os_product_id] = [
                        'id' => $product->os_product_id,
                        'name' => $product->product->name,
                        'total' => 0,
                    ];

                $arProducts[$product->os_product_id]['total'] += $orderServiceRoomGroup->quantity;
            }
        }

        $orderServiceRoomProducts = OrderServiceRoomProduct::get();

        foreach ($orderServiceRoomProducts as $orderServiceRoomProduct) {
            if (!isset($arProducts[$orderServiceRoomProduct->os_product_id]))
                $arProducts[$orderServiceRoomProduct->os_product_id] = [
                    'id' => $orderServiceRoomProduct->os_product_id,
                    'name' => $orderServiceRoomProduct->osProduct->name,
                    'total' => 0,
                ];

            $arProducts[$orderServiceRoomProduct->os_product_id]['total'] += $orderServiceRoomProduct->quantity;
        }

        $orderServiceRoomProviders = OrderServiceRoomProvider::get();

        foreach ($orderServiceRoomProviders as $orderServiceRoomProvider) {
            if (!isset($arProducts[$orderServiceRoomProvider->os_product_id]))
                $arProducts[$orderServiceRoomProvider->os_product_id] = [
                    'id' => $orderServiceRoomProvider->os_product_id,
                    'name' => $orderServiceRoomProvider->osProduct->name,
                    'total' => 0,
                ];

            $arProducts[$orderServiceRoomProvider->os_product_id]['total'] += $orderServiceRoomProvider->quantity;
        }

        $products = collect($arProducts)->sortByDesc('total')->values()->all();

        return view('reports.products', compact('products'));
    }

    public function providers(Request $request)
    {
        $providers = [];

        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $osProductIds = OrderServiceRoomProvider::with('orderService')
            ->whereHas('orderService', function ($query) use ($statusReproved) {
                $query->where('os_status_id', '!=', $statusReproved->id);
            })
            ->pluck('os_product_id')->unique()->toArray();

        if (count($osProductIds) == 0) {
            return view('reports.providers', compact('providers'));
        }

        $providerIds = OsProduct::whereIn('id', $osProductIds)->pluck('provider_id')->unique()->toArray();

        if (count($providerIds) == 0) {
            return view('reports.providers', compact('providers'));
        }

        $params = $request->all();
        $query = [
            'name' => '',
        ];

        $providers = Provider::whereIn('id', $providerIds);

        if (!empty($params)) {
            if (!empty($params['name'])) {
                $query['name'] = $params['name'];
                $providers->where('fantasy_name', 'like', '%' . $params['name'] . '%');
            }
        }

        $providers = $providers->paginate(30);

        $providers->getCollection()->transform(function ($provider) use ($statusReproved) {
            $providerProductIds = OsProduct::where('provider_id', $provider->id)->pluck('id')->toArray();

            $events = OrderServiceRoomProvider::with('orderService')
                ->whereIn('os_product_id', $providerProductIds)
                ->whereHas('orderService', function ($query) use ($statusReproved) {
                    $query->where('os_status_id', '!=', $statusReproved->id);
                })
                ->pluck('order_service_id')->unique()->count();

            $provider->events = $events;
            return $provider;
        });

        return view('reports.providers', compact('providers', 'query'));
    }

    public function providerDetail(Provider $provider)
    {
        $statusReproved = OsStatus::where('slug', 'reprovado')->first();
        $providerProductIds = OsProduct::where('provider_id', $provider->id)->pluck('id')->toArray();

        $orderServiceIds = OrderServiceRoomProvider::with('orderService')
            ->whereIn('os_product_id', $providerProductIds)
            ->whereHas('orderService', function ($query) use ($statusReproved) {
                $query->where('os_status_id', '!=', $statusReproved->id);
            })
            ->pluck('order_service_id')->unique()->toArray();

        $orderServices = OrderService::whereIn('id', $orderServiceIds);

        $orderServices = $orderServices->paginate(30);

        $orderServices->getCollection()->transform(function ($orderService) use ($providerProductIds) {
            $total = 0;

            $products = OrderServiceRoomProvider::where('order_service_id', $orderService->id)
                ->whereIn('os_product_id', $providerProductIds)->get();

            foreach ($products as $product) {
                if (!empty($product->osProduct->price)) {
                    $price = str_replace('.', '', $product->osProduct->price);
                    $price = (float) str_replace(',', '.', $price);

                    $total += $price * $product->quantity * count(explode(',', $product->days));
                }
            }

            $orderService->products = count($products);
            $orderService->total = $total;
            return $orderService;
        });

        return view('reports.providers-details', compact('provider', 'orderServices'));
    }

    public function freelancers(Request $request)
    {
        $freelancers = [];

        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $freelancerIds = OrderServiceRoomFreelancer::with('orderService')
            ->whereHas('orderService', function ($query) use ($statusReproved) {
                $query->where('os_status_id', '!=', $statusReproved->id);
            })
            ->pluck('freelancer_id')->unique()->toArray();

        if (count($freelancerIds) == 0) {
            return view('reports.freelancers', compact('freelancers'));
        }

        $params = $request->all();
        $query = [
            'name' => '',
        ];

        $freelancers = Freelancer::whereIn('id', $freelancerIds);

        if (!empty($params)) {
            if (!empty($params['name'])) {
                $query['name'] = $params['name'];
                $freelancers->where('name', 'like', '%' . $params['name'] . '%');
            }
        }

        $freelancers = $freelancers->paginate(30);

        $freelancers->getCollection()->transform(function ($freelancer) use ($statusReproved) {
            $events = OrderServiceRoomFreelancer::with('orderService')
                ->where('freelancer_id', $freelancer->id)
                ->whereHas('orderService', function ($query) use ($statusReproved) {
                    $query->where('os_status_id', '!=', $statusReproved->id);
                })
                ->pluck('order_service_id')->unique()->count();

            $freelancer->events = $events;
            return $freelancer;
        });

        return view('reports.freelancers', compact('freelancers', 'query'));
    }

    public function freelancerDetail(Freelancer $freelancer)
    {
        $statusReproved = OsStatus::where('slug', 'reprovado')->first();

        $orderServiceIds = OrderServiceRoomFreelancer::with('orderService')
            ->where('freelancer_id', $freelancer->id)
            ->whereHas('orderService', function ($query) use ($statusReproved) {
                $query->where('os_status_id', '!=', $statusReproved->id);
            })
            ->pluck('order_service_id')->unique()->toArray();

        $orderServices = OrderService::whereIn('id', $orderServiceIds);

        $orderServices = $orderServices->paginate(30);

        $orderServices->getCollection()->transform(function ($orderService) use ($freelancer) {
            $total = 0;

            $events = OrderServiceRoomFreelancer::where('order_service_id', $orderService->id)
                ->where('freelancer_id', $freelancer->id)->get();

            foreach ($events as $event) {
                if (!empty($event->price)) {
                    $price = str_replace('.', '', $event->price);
                    $price = (float) str_replace(',', '.', $price);

                    $total += $price * $event->quantity * $event->days;
                }
            }

            $orderService->events = count($events);
            $orderService->total = $total;
            return $orderService;
        });

        return view('reports.freelancers-details', compact('freelancer', 'orderServices'));
    }
}
