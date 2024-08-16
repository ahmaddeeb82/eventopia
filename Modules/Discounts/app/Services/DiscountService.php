<?php

namespace Modules\Discounts\app\Services;

use App\Traits\DateFormatter;
use Modules\Discounts\Transformers\GetDiscountResource;
use Modules\Notification\Services\NotificationService;

class DiscountService {
    use DateFormatter;

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($info) {
        $info['duration'] = $this->calcDuration($info['start_date'], $info['end_date']);
        $info['disconted_price'] = 0;
        $discount = $this->repository->add($info);
        $info['disconted_price'] = $discount->serviceAsset->price * (100 -$info['percentage'])/ 100;
        $discount->update([
            'disconted_price' => $info['disconted_price'],
        ]);

        NotificationService::send('dV-8JstFTLSjOy30SDMc0W:APA91bG-0I-eRAORSTSF-FaOS4wuxIAybU2GlQ53kMOFMkr5xuO5iwm1uOfjYslEWMcXJjZ-5Nr1LNNOYobpMAKsTTHgw-7ihjR0FBAZ20b6MKxm-SFNpICdnDdwfOYF7IYNJBIu9zDz', __('messages.add_discount_notification_name'),__('messages.add_discount_notification_content', ['name' => $discount->serviceAsset->asset->hall?$discount->serviceAsset->asset->hall->name:$discount->serviceAsset->asset->user->first_name]));
    }

    public function list() {
        return GetDiscountResource::collection($this->repository->list());
    }

}
