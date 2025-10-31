<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GT_EXP;
use Illuminate\Support\Facades\DB;

class GrantTrailsController extends Controller
{
    public function index() {
        // DB::enableQueryLog();

        $totals = GT_EXP::select('zip', 'name', 'latitude', 'longitude', 'state_abbr', DB::raw('sum(amount) as total'))->whereNotNull('fund_type');

        if ( request()->input('fiscal_years') ) {
            $totals->whereIn('fiscal_year', request()->fiscal_years);
        } else {
            $totals->where('fiscal_year', '2024');
        }

        if ( request()->input('fund_types') ) {
            $totals->whereIn('fund_type', request()->fund_types);
        }

        $totals->where('state_abbr', 'CT');
        
        $totals = $totals->groupBy('zip', 'name', 'latitude', 'longitude', 'state_abbr')->get();

        $totals = $totals->sortBy('name')->values();

        $years = [2024, 2023, 2022, 2021, 2020];
        $fundTypes = collect([
            'Corporate',
            'State of CT',
            'Other State and Local Government',
            'Federal',
            'Foreign',
            'College/University',
            'Non-Profit'
        ]);

        // $queries = DB::getQueryLog();
        // \Log::info($queries);

        return view('index', compact('totals', 'years', 'fundTypes'));
    }


    // Primary API response for GT front-end
    public function totals() {
        $totals = GT_EXP::select('zip', 'name', 'latitude', 'longitude', 'state_abbr', DB::raw('sum(amount) as total'))->whereNotNull('fund_type');

        if ( request()->input('fiscal_years') ) {
            $totals->whereIn('fiscal_year', request()->fiscal_years);
        } else {
            $totals->where('fiscal_year', '2024');
        }

        if ( request()->input('fund_types') ) {
            $totals->whereIn('fund_type', request()->fund_types);
        }

        $totals->where('state_abbr', 'CT');
        
        $totals = $totals->groupBy('zip', 'name', 'latitude', 'longitude', 'state_abbr')->get();

        $totals = $totals->sortBy('name')->values();

        return response()->json($totals);
    }
}
