<?php
/**
 * Created by PhpStorm.
 * User: lehone
 * Date: 3/5/19
 * Time: 10:46 PM
 */

namespace App\Http\Controllers;


use App\Brand;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller {

    public $search;
    function __construct() {
        $this->search = [
            'budget_high' => null,
            'budget_low'  => null,
            'brand'       => [],
            'year'        => [],
            'driven_high'=> null,
            'driven_low' => null,
            'fuel'        => [],
            'transmission'=> [],
            'q'           => '',
            'color'       => '',
        ];
    }

    public function carListing(Request $request) {
        $search = $this->search;
        $vehicles = new Vehicle();

        if ($request->has('q')) {
            $q = $request->get('q');
            $vehicles = $vehicles->where('name', 'like', '%'.$q.'%')
                ->orWhere('model', 'like', '%'.$q.'%')
                ->orWhere('description', 'like', '%'.$q.'%');
            $search['q'] = $q;
        }

        if ($request->has('color')) {
            $color = $request->get('color');
            $vehicles = $vehicles->where('color', $color);
            $search['color'] = $color;
        }

        if ($request->has('budget')) {
            $budget = explode(',', $request->get('budget'));
            if (count($budget) == 2) {
                if ($budget[0] == 1 && $budget[1] == 1) {
                    $vehicles = $vehicles->where('price', '>=', 100000000);
                } else {
                    $vehicles = $vehicles->whereBetween('price', [$budget[0],$budget[1]]);
                }
                $search['budget_low'] = $budget[0];
                $search['budget_high'] = $budget[1];
            }
        }

        if ($request->has('brand')) {
            $brands = $request->get('brand');
            $vehicles = $vehicles->where(function ($query) use ($brands) {
                foreach ($brands as $index=>$item) {
                    $query->orWhere('brand_id', $item);
                }
            });
            $search['brand'] = $brands;
        }

        if ($request->has('year')) {
            $years = $request->get('year');
            $vehicles = $vehicles->where(function ($query) use ($years) {
                foreach ($years as $index=>$item) {
                    $query->orWhere('make_year', $item);
                }
            });
            $search['year'] = $years;
        }

        if ($request->has('driven')) {
            $driven = explode(',', $request->get('driven'));
            if (count($driven) == 2) {
                if ($driven[0] == 1 && $driven[1] == 1) {
                    $vehicles = $vehicles->where('driven', '>=', $driven[0]);
                } else {
                    $vehicles = $vehicles->whereBetween('driven', [$driven[0],$driven[1]]);
                }
                $search['driven_low'] = $driven[0];
                $search['driven_high'] = $driven[1];
            }
        }

        if ($request->has('fuel')) {
            $fuels = $request->get('fuel');
            $vehicles = $vehicles->where(function ($query) use ($fuels) {
                foreach ($fuels as $index=>$item) {
                    $query->orWhere('fuel_type_id', $item);
                }
            });
            $search['fuel'] = $fuels;
        }

        if ($request->has('transmission')) {
            $transmissions = $request->get('transmission');
            $vehicles = $vehicles->where(function ($query) use ($transmissions) {
                foreach ($transmissions as $index=>$item) {
                    $query->orWhere('transmission', $item);
                }
            });
            $search['transmission'] = $transmissions;
        }

        $vehicles = $vehicles->paginate(12);
        $colors = config('constants.colors');

        return view('listing', compact('vehicles', 'search', 'colors'));
    }
}
