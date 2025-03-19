<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    use ImageTrait;

    public function completeProfile(Request $request)
    {
        $validated = $request->validate([
            'age' => ['required', 'int'],
            'profile_picture' => ['nullable', 'image'],
            'gender' => ['required', 'in:male,female'],
            'name' => ['required', 'string']
        ]);
        try {
            $user = auth()->user();

            $year_of_birth = Carbon::now()->format('Y') - $validated['age'];

            if($request->has('profile_picture')){
                if($user->profile_picture){
                    $this->deleteImage($user->profile_picture);
                }
                $image_path = $this->storeImage($validated['profile_picture'], 'images/profile_pictures');
            }

            $user->update([
                'year_of_birth' => $year_of_birth,
                'profile_picture' => $image_path ?? null,
                'gender' => $validated['gender'],
                'name' => $validated['name'],
                'profile_completion_status' => 'completed',
            ]);
            return $this->withSuccess(message: __('api.operation_done_successfully'));
        } catch (\Exception $e) {
            return $this->withError(__('api.Something_went_wrong'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        if ($user->trashed()) {
            return $this->withSuccess(message: __('api.This account has been deleted'));
        }
        $user->delete();
        return $this->withSuccess(message: __('api.This account has been deleted'));
    }

    public function forceDelete(User $user)
    {
        if (!$user->trashed()) {
            $user->delete();
            return $this->withSuccess(message: __('api.This account has been deleted'));
        }
        $user->forceDelete();
        return $this->withSuccess(message: __('api.This account has been deleted for ever'));
    }
}
