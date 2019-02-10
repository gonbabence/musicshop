<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Ad as AdModel;

class Ads extends Controller {

    public function index() {
        return view(
            'ads.list',
            [
                'ads' => $this->getAds()
            ]
        );
    }

    public function details($id) {
        $ad = AdModel::find($id)->getAttributes();
        return view(
            'ads.details',
            [
                'ad' => $ad
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('ads.create');
    }

    public function save(Request $request) {
        $ad = new AdModel;
        $post = $request->post();
        $ad->fill($post);

        if (!$ad->save()) {
            $request->session()->flash('error', 'Save failed');
        }

        $request->session()->flash('success', 'Saved successfully');

        return view('pages.home');
    }

    public function getAds($limit = null, $offset = null) {
        $result = [];

        foreach (AdModel::all() as $ad) {
            array_push($result, $ad->getAttributes());
        }

        return $result;
    }

}
