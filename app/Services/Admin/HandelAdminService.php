<?php

namespace App\Services\Admin;

use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use Illuminate\Support\Facades\Auth;
use App\Services\Trainee\NotificationManager as NotificationManagerTrainee;
use App\Services\Cgo\NotificationManager as NotificationManagerCgo;
use App\Services\Company\NotificationManager as NotificationManagerCompany;

class HandelAdminService
{
    protected NotificationManagerCgo $notificationManagerCgo;

    public function __construct()
    {
        $this->notificationManagerCgo = app(NotificationManagerCgo::class);
    }

    public function approve($model, $modelId)
    {
        $adminId = Auth::id();
        $instance = $model::find($modelId);

        if (!$instance) {
            return false;
        }
        $this->notificationManagerCgo->sendMembershipApprovalEmail($instance);
        $instance->update([
            'verify_at' => now(),
            'verify_by' => $adminId,
            'active' => true
        ]);
        return true;
    }
    public function approveTrainee($model, $modelId)
    {
        $instance = $model::find($modelId);

        if (!$instance) {
            return false;
        }

        $this->notificationManagerCgo->sendMembershipApprovalEmail($instance);

        $instance->update([
            'email_verify_at' => now(),
            'active' => true,
        ]);

        return true;
    }

    public function block($model, $modelId)
    {
        $adminId = Auth::id();
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $this->notificationManagerCgo->sendMembershipBlockEmail($instance);
        $instance->update([
            'verify_at' => null,
            'verify_by' => $adminId,
            'email_verify_at' => null,
            'active' => false
        ]);

        return true;
    }
    public function rejectCgo($model, $modelId,$reason){
        $adminId = Auth::id();
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $this->notificationManagerCgo->sendMembershipRejectEmail($instance, $reason);
        $instance->update([
            'verify_at' => null,
            'verify_by'=>$adminId,
            'email_verified_at'=>null,
            'active' => false,
            'reason'=>$reason
        ]);
        return true;
    }
    public function rejectTrainee($model, $modelId,$reason){
        $adminId = Auth::id();
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $this->notificationManagerCgo->sendMembershipRejectEmail($instance, $reason);
        $instance->update([
            'active' => false,
            'email_verified_at'=>null,
            'reason'=>$reason
        ]);
        return true;
    }
    public function rejectCompany($model, $modelId,$reason){
        $adminId = Auth::id();
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $this->notificationManagerCgo->sendMembershipRejectEmail($instance, $reason);
        $instance->update([
            'verified_at' => null,
            'verified_by'=>$adminId,
            'active' => false,
            'reason'=>$reason
        ]);
        return true;
    }
    public function blockContent($model, $modelId)
    {
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $instance->update([
            'status' => \App\Enums\StatusEnumsManagement::NON_APPROVAL->value,
        ]);
        return true;
    }
    public function approveContent($model, $modelId)
    {
        $instance = $model::find($modelId);
        if($instance->system=='cgo'){
            $user=CgoUser::find($instance->created_by);
        }else if($instance->system=='company'){
            $user=CompanyRecruiter::find($instance->created_by);
        }else if($instance->system=='admin'){
            $user=AdminUser::find($instance->created_by);
        }
        $this->notificationManagerCgo->approvalContentSendToCgo( $user,$instance);
        if (!$instance) {
            return false;
        }
        $instance->update([
            'status' => \App\Enums\StatusEnumsManagement::APPROVED->value,
        ]);
        return true;
    }
    public function approveCompany($model, $modelId)
    {
        $adminId = Auth::id();
        $instance = $model::find($modelId);

        if (!$instance) {
            return false;
        }
        $instance->update([
            'verified_at' => now(),
            'verified_by' => $adminId,
            'active' => true
        ]);
        return true;
    }
    public function blockCompany($model, $modelId)
    {
        $instance = $model::find($modelId);
        if (!$instance) {
            return false;
        }
        $instance->update([
            'verified_at' => null,
            'verified_by' => null,
            'active' => false
        ]);
        return true;
    }

}
