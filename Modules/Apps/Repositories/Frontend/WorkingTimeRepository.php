<?php

namespace Modules\Apps\Repositories\Frontend;

use Carbon\Carbon;
use Modules\Apps\Entities\DeliveryWorkingDay;
use Modules\Apps\Entities\PickupWorkingDay;

class WorkingTimeRepository
{
    protected $pickupWorkDay;
    protected $deliveryWorkDay;

    public function __construct(PickupWorkingDay $pickupWorkDay, DeliveryWorkingDay $deliveryWorkDay)
    {
        $this->pickupWorkDay = $pickupWorkDay;
        $this->deliveryWorkDay = $deliveryWorkDay;
    }

    public function getActivePickupWorkingDays($day_code = null)
    {
        $query = $this->pickupWorkDay->active()->with(['pickupWorkingTimes'=>function($with){
            $with->orderBy('from','asc');
        }])->where('is_full_day', 0);

        if($day_code){
            $query = $query->where('day_code', $day_code);
        }

        return $query->get();
    }

    public function getActiveDeliveryWorkingDays($day_code = null)
    {
        $query = $this->deliveryWorkDay->active()->with(['deliveryWorkingTimes'=>function($with){
            $with->orderBy('from','asc');
        }])->where('is_full_day', 0);

        if($day_code){
            $query = $query->where('day_code', $day_code);
        }

        return $query->get();

    }

    public function getPickUpDayDetails($id)
    {
        return $this->pickupWorkDay->active()->whereHas('pickupWorkingTimes' , function($q) use ($id){
            $q->where('id',$id);
        })
        ->with(['pickupWorkingTimes'=>function($with) use($id){
            $with->where('id',$id);
        }])->where('is_full_day', 0)->first();
    }

    public function getDeliveryDayDetails($id)
    {
        return $this->deliveryWorkDay->active()->whereHas('deliveryWorkingTimes' , function($q) use ($id){
            $q->where('id',$id);
        })
        ->with(['deliveryWorkingTimes'=>function($with) use($id){
            $with->where('id',$id);
        }])->where('is_full_day', 0)->first();
    }
}
