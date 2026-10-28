<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Services\ArkanaApi;
use App\Support\PropertyPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LandingController extends Controller
{
    /** Monthly installment caps offered in the search bar. */
    public const CICILAN_OPTIONS = [1000000 => '≤ Rp 1 juta', 2000000 => '≤ Rp 2 juta', 3000000 => '≤ Rp 3 juta', 5000000 => '≤ Rp 5 juta'];

    /** Price ranges (min-max in rupiah, empty side = open) offered in the budget dropdown. */
    public const BUDGET_OPTIONS = [
        '0-200000000' => '≤ Rp 200 juta',
        '200000000-300000000' => 'Rp 200 - 300 juta',
        '300000000-500000000' => 'Rp 300 - 500 juta',
        '500000000-' => '≥ Rp 500 juta',
    ];

    public function __construct(private ArkanaApi $api) {}

    public function index(Request $request)
    {
        $filters = $request->only(['lokasi', 'jenis_rumah', 'budget', 'min_budget', 'max_budget', 'max_cicilan']);

        // The dropdown sends one range key; the API takes min/max budget.
        $query = Arr::except($filters, ['budget']);

        if (isset($filters['budget']) && isset(self::BUDGET_OPTIONS[$filters['budget']])) {
            [$min, $max] = explode('-', $filters['budget']);
            $query = array_merge($query, array_filter(['min_budget' => $min, 'max_budget' => $max], fn ($v) => $v !== '' && $v !== '0'));
        } else {
            unset($filters['budget']);
        }

        // The landing page stays up if the API is down; the catalog just
        // shows a notice instead of cards.
        try {
            $catalog = $this->api->get('public/perumahan', $query);
            $options = $this->api->get('public/filters');
            $catalogError = null;
        } catch (ApiException $e) {
            $catalog = [];
            $options = ['lokasi' => [], 'jenis_rumah' => []];
            $catalogError = $e->getMessage();
        }

        $properties = PropertyPresenter::cards($catalog);
        $submittedId = session('lead_success.id_tipe');

        return view('pages.landing', [
            'properties' => $properties,
            'filters' => $filters,
            'lokasiOptions' => $options['lokasi'] ?? [],
            'jenisOptions' => $options['jenis_rumah'] ?? [],
            'cicilanOptions' => self::CICILAN_OPTIONS,
            'budgetOptions' => self::BUDGET_OPTIONS,
            'catalogError' => $catalogError,
            'submittedProperty' => $submittedId ? collect($properties)->firstWhere('id', $submittedId) : null,
        ]);
    }
}
