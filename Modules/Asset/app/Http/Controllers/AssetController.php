<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Modules\Asset\app\Repositories\AssetRepository;
use Modules\Asset\app\Services\AssetService;
use Modules\Asset\Http\Requests\AddAssetRequest;
use Modules\Asset\Http\Requests\AddServiceForOrganizerRequest;
use Modules\Asset\Http\Requests\AddServicesForOrganizerRequest;
use Modules\Asset\Http\Requests\AssetFiltersRequest;
use Modules\Asset\Http\Requests\AssetPhotosRequest;
use Modules\Asset\Http\Requests\AssetRateRequest;
use Modules\Asset\Http\Requests\DeleteAttachedServiceRequest;
use Modules\Asset\Http\Requests\GetAssetRequest;
use Modules\Asset\Http\Requests\UpdateHallInformationRequest;
use Modules\Asset\Http\Requests\UpdateServiceOrgeanizerRequest;
use Modules\Asset\Transformers\AssetResource;
use Modules\Favorite\Http\Requests\GetFavoriteWithIdRequest;
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

    public function list(Request $request) {
        return $this->sendResponse(200,
        __('messages.rate'),
        AssetResource::collection((new AssetRepository)->list($request->identifier, $request->role, $request->service_id??1))
    );
    }

    public function recentlyAdded(GetInvestorsRequest $request) {
        return $this->sendResponse(200,
        __('messages.rate'),
        (new AssetService(new AssetRepository()))->recentlyAdded($request->role)
    );
    }

    public function addToFavorite(GetAssetRequest $request) {
        
        (new AssetService(new AssetRepository()))->addToFavorite($request->id);
        return $this->sendResponse(200,
        __('messages.rate'),
        );
    }

    public function getFavorites() {
        
        return $this->sendResponse(200,
        __('messages.rate'),
        (new AssetService(new AssetRepository()))->getFavorites()
        );
    }

    public function deleteFavorite(GetFavoriteWithIdRequest $request) {
        (new AssetService(new AssetRepository()))->deleteFavorite($request->id);
        return $this->sendResponse(200,
        __('messages.rate'),
        );
    }

    public function listForInvestor() {
        return $this->sendResponse(200,
        __('messages.rate'),
        (new AssetService(new AssetRepository()))->listForInvestor()
        );
    }

    public function update(UpdateHallInformationRequest $request) {

        (new AssetService(new AssetRepository()))->updateCompleteAsset($request->all());

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function updateSereviceForOrganizer(UpdateServiceOrgeanizerRequest $request) {
        (new AssetService(new AssetRepository()))->updateAttachedService($request->all());

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function addSereviceForOrganizer(AddServiceForOrganizerRequest $request) {
        (new AssetService(new AssetRepository()))->updateAttachedService($request->all());

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function getFilters(AssetFiltersRequest $request) {
        
        return $this->sendResponse(200,
        __('messages.create_asset'),
        (new AssetService(new AssetRepository()))->filterForReservation($request->all())
    );
    }

    public function addServicesForOrganizer(AddServicesForOrganizerRequest $request) {
        (new AssetService(new AssetRepository()))->attachMultipleServices(auth()->user()->assets()->first(),$request->services);

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function deleteService(DeleteAttachedServiceRequest $request) {
        (new AssetService(new AssetRepository()))->deleteAttachedService($request->id);

        return $this->sendResponse(200, __('messages.create_asset'));
    }

    public function deleteAsset(GetAssetRequest $request) {
        (new AssetService(new AssetRepository()))->deleteAsset($request->id);

        return $this->sendResponse(200, __('messages.create_asset'));
    }
}
