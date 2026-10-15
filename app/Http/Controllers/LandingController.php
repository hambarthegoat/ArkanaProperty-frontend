<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Services\ArkanaApi;
use App\Support\PropertyPresenter;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /** Monthly installment caps offered in the search bar. */
    public const CICILAN_OPTIONS = [1000000 => '≤ Rp 1 juta', 2000000 => '≤ Rp 2 juta', 3000000 => '≤ Rp 3 juta', 5000000 => '≤ Rp 5 juta'];

    public function __construct(private ArkanaApi $api) {}

    public function index(Request $request)
    {
        $filters = $request->only(['lokasi', 'jenis_rumah', 'min_budget', 'max_budget', 'max_cicilan']);

        // The landing page stays up if the API is down; the catalog just
        // shows a notice instead of cards.
        try {
            $catalog = $this->api->get('public/perumahan', $filters);
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
            'catalogError' => $catalogError,
            'submittedProperty' => $submittedId ? collect($properties)->firstWhere('id', $submittedId) : null,
        ]);
    }
}
