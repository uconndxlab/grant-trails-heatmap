<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GT_EXP;
use Illuminate\Support\Facades\DB;

class GrantTrailsController extends Controller
{
    public function index() {
        $totals = GT_EXP::select('zip', DB::raw('sum(amount) as total'))->whereNotNull('fund_type');

        if ( request()->input('fiscal_years') ) {
            $totals->whereIn('fiscal_year', request()->fiscal_years);
        } else {
            $totals->where('fiscal_year', '2024');
        }

        if ( request()->input('fund_types') ) {
            $totals->whereIn('fund_type', request()->fund_types);
        }

        $totals->where('state_abbr', 'CT');
        
        $totals = $totals->groupBy('zip')->get();

        $zips = $totals->pluck('zip')->toArray();
        $metadata = GT_EXP::whereIn('zip', $zips)
            ->select('zip', 'name', 'latitude', 'longitude', 'state_abbr')
            ->get()
            ->keyBy('zip');

        foreach ($totals as $total) {
            $total->name = $metadata->get($total->zip)->name;
            $total->latitude = $metadata->get($total->zip)->latitude;
            $total->longitude = $metadata->get($total->zip)->longitude;
            $total->state_abbr = $metadata->get($total->zip)->state_abbr;
        }

        $totals = $totals->sortBy('name')->values();


        $years = [2024, 2023, 2022, 2021, 2020];
        $fundTypes = GT_EXP::select('fund_type')->whereNotNull('fund_type')->distinct()->get()->pluck('fund_type');
        return view('index', compact('totals', 'years', 'fundTypes'));
    }


    // Primary API response for GT front-end
    public function totals() {
        $totals = GT_EXP::select('zip', DB::raw('sum(amount) as total'))->whereNotNull('fund_type');

        if ( request()->input('fiscal_years') ) {
            $totals->whereIn('fiscal_year', request()->fiscal_years);
        }

        if ( request()->input('fund_types') ) {
            $totals->whereIn('fund_type', request()->fund_types);
        }

        $totals->where('state_abbr', 'CT');
        
        $totals = $totals->groupBy('zip')->get();

        $zips = $totals->pluck('zip')->toArray();
        $metadata = GT_EXP::whereIn('zip', $zips)
            ->select('zip', 'name', 'latitude', 'longitude', 'state_abbr')
            ->get()
            ->keyBy('zip');

        foreach ($totals as $total) {
            $total->name = $metadata->get($total->zip)->name;
            $total->latitude = $metadata->get($total->zip)->latitude;
            $total->longitude = $metadata->get($total->zip)->longitude;
            $total->state_abbr = $metadata->get($total->zip)->state_abbr;
        }

        $totals = $totals->sortBy('name')->values();

        return response()->json($totals);
    }
}
