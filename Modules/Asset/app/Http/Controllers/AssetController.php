<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Asset\app\Repositories\AssetRepository;
use Modules\Asset\app\Repositories\HallRepository;
use Modules\Asset\app\Services\AssetService;
use Modules\Asset\app\Services\HallService;
use Modules\Asset\Http\Requests\AddAssetRequest;
use Modules\Asset\Http\Requests\AssetPhotosRequest;
use Modules\Asset\Http\Requests\AssetRateRequest;
use Modules\Asset\Http\Requests\GetAssetRequest;
use Modules\Asset\Transformers\AssetResource;
use Modules\Event\app\Repositories\ServiceRepository;
use Modules\Event\app\Services\ServiceService;
use Modules\Event\Http\Controllers\ServiceController;
use Modules\User\Http\Requests\GetInvestorsRequest;

class AssetController extends Controller
{
    use ApiResponse;
    
    public function add(AddAssetRequest $request) {

        (new AssetService(new AssetRepository()))->addCompleteAsset($request->all());

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function addPhotos(AssetPhotosRequest $request) {
        return $this->sendResponse(200,
        __('messages.create_asset'),
        (new AssetService(new AssetRepository()))->addPhotos($request->photos));
    }

    public function get(GetAssetRequest $request) {

        return $this->sendResponse(200,
        __('messages.retrieve_asset'),
        (new AssetService(new AssetRepository()))->get($request->id));
    }

    public function rate(AssetRateRequest $request) {
        (new AssetService(new AssetRepository()))->claculateRate($request->all());
        return $this->sendResponse(200,
        __('messages.rate'));
    }

    public function list() {
        return $this->sendResponse(200,
        __('messages.rate'),
        AssetResource::collection((new AssetRepository)->topRate())
    );
    }

    public function recentlyAdded(GetInvestorsRequest $request) {
        //return (new AssetRepository)->recentlyAdded($request->role);
        return $this->sendResponse(200,
        __('messages.rate'),
        (new AssetService(new AssetRepository()))->recentlyAdded($request->role)
    );
    }
}
