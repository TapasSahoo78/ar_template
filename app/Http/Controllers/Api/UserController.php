<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Hobbies;
use App\Models\Location;
use App\Models\UserView;
use App\Models\UserImage;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use App\Models\FamilyDetails;
use App\Models\UserDocuments;
use App\Models\UserFavourite;
use App\Models\UserShortlist;
use App\Models\UserPreference;
use App\Models\ProfileBasicDetail;
use App\Http\Controllers\Controller;
use App\Models\ReligiousInformation;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfessionalInformation;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\User\ProfileCollection;
use App\Http\Resources\Api\User\UserImageCollection;
use App\Http\Resources\Api\User\UserDocumentCollection;
use App\Http\Resources\Api\User\ViewedProfileCollection;
use App\Http\Resources\Api\User\MatchedProfileCollection;
use App\Http\Resources\Api\User\FavouriteProfileCollection;
use App\Http\Resources\Api\User\ShortlistProfileCollection;

class UserController extends BaseController
{

    public function updateProfileFirstStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_type' => 'required|in:0,1',
            // 'about_me' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'marital_status' => 'required',
            'mother_tongue' => 'required',
            'physical_status' => 'required',
            'body_type' => 'required',
            'gender' => 'required',
            'eating_habits' => 'required',
            'profile_created_by' => 'required',
            'smoking_habits' => 'required',
            'drinking_habits' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $user_data = [
                    'profile_type' => $request->profile_type ?? 0,
                    'about_me' => $request->about_me ?? NULL
                ];

                $basic_info_data = [
                    'height' => $request->height ?? NULL,
                    'weight' => $request->weight ?? NULL,
                    'marital_status' => $request->marital_status ?? NULL,
                    'mother_tongue' => $request->mother_tongue ?? NULL,
                    'physical_status' => $request->physical_status ?? NULL,
                    'body_type' => $request->body_type ?? NULL,
                    'gender' => $request->gender ?? NULL,
                    'eating_habits' => $request->eating_habits ?? NULL,
                    'profile_created_by' => $request->profile_created_by ?? NULL,
                    'smoking_habits' => $request->smoking_habits ?? NULL,
                    'drinking_habits' => $request->drinking_habits ?? NULL,
                ];

                $user_update = User::where('id', Auth::user()->id)->update($user_data);
                $basic_info_update = ProfileBasicDetail::updateOrCreate(['user_id' => Auth::user()->id], $basic_info_data);

                if ((!empty($user_update)) || (!empty($basic_info_update))) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'Basic Information saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'Basic Information not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }
    public function updateProfileSecondStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caste' => 'required',
            'gotra' => 'required',
            'zodiac' => 'required',
            'star' => 'required',
            'rassi' => 'required',
            'dosh' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'citizenship' => 'required',
            'ancestral_origin' => 'required'
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $religious_data = [
                    'caste' => $request->caste ?? NULL,
                    'gotra' => $request->gotra ?? NULL,
                    'zodiac' => $request->zodiac ?? NULL,
                    'star' => $request->star ?? NULL,
                    'rassi' => $request->rassi ?? NULL,
                    'dosh' => $request->dosh ?? NULL
                ];

                $location_data = [
                    'country' => $request->country ?? NULL,
                    'state' => $request->state ?? NULL,
                    'city' => $request->city ?? NULL,
                    'citizenship' => $request->citizenship ?? NULL,
                    'ancestral_origin' => $request->ancestral_origin ?? NULL
                ];

                $religious_update = ReligiousInformation::updateOrCreate(['user_id' => Auth::user()->id], $religious_data);
                $location_update = Location::updateOrCreate(['user_id' => Auth::user()->id], $location_data);

                if ((!empty($religious_update)) || (!empty($location_update))) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'Religious and Location Information saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'Religious and Location  not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }
    public function updateProfileThirdStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'education_category' => 'required',
            'college' => 'required',
            'organization' => 'required',
            'employed_in' => 'required',
            'annual_income' => 'required'
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $professional_data = [
                    'education_category' => $request->education_category ?? 0,
                    'college' => $request->college ?? NULL,
                    'occupation' => auth()->user()->occupation ?? NULL,
                    'organization' => $request->organization ?? NULL,
                    'employed_in' => $request->employed_in ?? NULL,
                    'annual_income' => $request->annual_income ?? NULL
                ];

                $professional_update = ProfessionalInformation::updateOrCreate(['user_id' => Auth::user()->id], $professional_data);

                if (!empty($professional_update)) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'Professional Information saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'Religious and Location  not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }
    public function updateProfileFourthStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'family_values' => 'required',
            'family_type' => 'required',
            'family_status' => 'required',
            'fathers_occupation' => 'required',
            'mothers_occupation' => 'required',
            'about_my_family' => 'required'
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $user_data = [
                    'email' => $request->email ?? NULL
                ];

                $family_data = [
                    'family_values' => $request->family_values ?? NULL,
                    'family_type' => $request->family_type ?? NULL,
                    'family_status' => $request->family_status ?? NULL,
                    'fathers_occupation' => $request->fathers_occupation ?? NULL,
                    'mothers_occupation' => $request->mothers_occupation ?? NULL,
                    'about_my_family' => $request->about_my_family ?? NULL
                ];

                $user_update = User::where('id', Auth::user()->id)->update($user_data);
                $family_update = FamilyDetails::updateOrCreate(['user_id' => Auth::user()->id], $family_data);

                if ((!empty($user_update)) || (!empty($family_update))) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'Family Information saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'Family Information not saved', (object) []);
                }
            } catch (\Throwable $th) {
                // dd($th);
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }
    public function updateProfileFifthStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hobbies' => 'required',
            'music' => 'required',
            'reading' => 'required',
            'moving_and_tv_shows' => 'required',
            'sports_and_fitness' => 'required',
            'food' => 'required',
            'spoken_languages' => 'required'
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $hobbies_data = [
                    'hobbies' => $request->hobbies ?? NULL,
                    'music' => $request->music ?? NULL,
                    'reading' => $request->reading ?? NULL,
                    'moving_and_tv_shows' => $request->moving_and_tv_shows ?? NULL,
                    'sports_and_fitness' => $request->sports_and_fitness ?? NULL,
                    'food' => $request->food ?? NULL,
                    'spoken_languages' => $request->spoken_languages ?? NULL,
                ];

                $hobbies_update = Hobbies::updateOrCreate(['user_id' => Auth::user()->id], $hobbies_data);

                if (!empty($hobbies_update)) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'Hobbies Information saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'Hobbies Information not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function userProfile(Request $request)
    {
        try {
            if (!empty($request->user_id)) {
                $user = User::find($request->user_id);
            } else {
                $user = auth()->user();
            }

            if (!empty($user)) {
                return $this->apiResponseJson(true, 200, 'User Profile Found', new ProfileCollection($user));
            } else {
                return $this->apiResponseJson(true, 200, 'No User Found', (object) []);
            }
        } catch (\Throwable $th) {
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }

    public function userUploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048', // Example rules
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $image = uniqid() . "." . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(public_path('storage/user_images'), $image);

                $user_image_data = [
                    'user_id' => auth()->user()->id,
                    'file' => $image,
                ];

                $user_data = ['profile_photo' => $image];

                $image_store = UserImage::create($user_image_data);
                $user_profile_image = User::where('id', Auth::user()->id)->update($user_data);

                if ((!empty($image_store)) && (!empty($user_profile_image))) {
                    $user_image_list = UserImage::where('user_id', Auth::user()->id)->get();
                    return $this->apiResponseJson(true, 200, 'User image successfully saved', UserImageCollection::collection($user_image_list));
                } else {
                    return $this->apiResponseJson(false, 422, 'User image not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function userImageList(Request $request)
    {
        try {
            $user_image_list = UserImage::where('user_id', auth()->user()->id)->get();
            if ($user_image_list->count() > 0) {
                return $this->apiResponseJson(true, 200, 'User Image List Found', UserImageCollection::collection($user_image_list));
            } else {
                return $this->apiResponseJson(true, 200, 'No User Image Found', []);
            }
        } catch (\Throwable $th) {
            return $this->apiResponseJson(false, 500, 'Something went wrong', []);
        }
    }

    public function userRemoveImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_id' => 'required', // Example rules
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $image_info = UserImage::where(['id' => $request->image_id, 'user_id' => auth()->user()->id])->first();

                if ($image_info) {
                    if ($image_info->file == auth()->user()->profile_photo) {
                        $remove_image = UserImage::where('id', $request->image_id)->delete();
                        $update_user = User::where('id', auth()->user()->id)->update(['profile_photo' => NULL]);
                        $message = "Profile Picture has been removed";
                    } else {
                        $remove_image = UserImage::where('id', $request->image_id)->delete();
                        $message = "Image has been removed";
                    }

                    $user_image_list = UserImage::where('user_id', Auth::user()->id)->get();
                    if ($user_image_list) {
                        return $this->apiResponseJson(true, 200, $message, UserImageCollection::collection($user_image_list));
                    } else {
                        return $this->apiResponseJson(true, 200, "No image found for this user", []);
                    }
                } else {
                    return $this->apiResponseJson(true, 200, "No Image Found", []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', []);
            }
        }
    }

    public function userMakeProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $image_info = UserImage::where(['id' => $request->image_id, 'user_id' => auth()->user()->id])->first();

                if ($image_info) {
                    $update_user = User::where('id', auth()->user()->id)->update(['profile_photo' => $image_info->file]);

                    if ($image_info->file == auth()->user()->profile_photo) {
                        $message = "Profile image remains same";
                    } else {
                        $message = "Profile image updated successfully";
                    }

                    $user_image_list = UserImage::where('user_id', Auth::user()->id)->get();
                    if ($user_image_list->count() > 0) {
                        return $this->apiResponseJson(true, 200, $message, UserImageCollection::collection($user_image_list));
                    } else {
                        return $this->apiResponseJson(true, 200, "No image found for this user", []);
                    }
                } else {
                    return $this->apiResponseJson(true, 200, "No Image Found", []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', []);
            }
        }
    }

    public function userFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $feedback_arr = [
                    'user_id' => auth()->user()->id,
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ];

                $feedback = UserFeedback::updateOrCreate(['user_id' => auth()->user()->id], $feedback_arr);

                if (!empty($feedback)) {
                    return $this->apiResponseJson(true, 200, 'Feedback saved successfully', (object) []);
                } else {
                    return $this->apiResponseJson(false, 422, 'Feedback not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function userUploadDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_file_type' => 'required|in:0,1',
            'id_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'photo_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'salary_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                if (!empty($request->file('id_file'))) {
                    $user_id_file = uniqid() . "." . $request->file('id_file')->getClientOriginalExtension();
                    $request->file('id_file')->move(public_path('storage/user_documents/id_file'), $user_id_file);
                    $id_status = 1;
                } else {
                    $id_status = 0;
                }

                if (!empty($request->file('photo_file'))) {
                    $user_photo_file = uniqid() . "." . $request->file('photo_file')->getClientOriginalExtension();
                    $request->file('photo_file')->move(public_path('storage/user_documents/photo_file'), $user_photo_file);
                    $photo_status = 1;
                } else {
                    $photo_status = 0;
                }

                if (!empty($request->file('salary_file'))) {
                    $user_salary_file = uniqid() . "." . $request->file('salary_file')->getClientOriginalExtension();
                    $request->file('salary_file')->move(public_path('storage/user_documents/salary_file'), $user_salary_file);
                    $salary_status = 1;
                } else {
                    $salary_status = 0;
                }

                $user_document_data = [
                    'user_id' => auth()->user()->id,
                    'id_file_type' => $request->id_file_type,
                    'id_file' => $user_id_file ?? NULL,
                    'id_status' => $id_status,
                    'photo_file' => $user_photo_file ?? NULL,
                    'photo_status' => $photo_status,
                    'salary_file' => $user_salary_file ?? NULL,
                    'salary_status' => $salary_status,
                ];

                $document_store = UserDocuments::updateorcreate(['user_id' => auth()->user()->id], $user_document_data);

                if (!empty($document_store)) {
                    $user_document_list = UserDocuments::where('user_id', auth()->user()->id)->get();
                    return $this->apiResponseJson(true, 200, 'User documents successfully saved', UserDocumentCollection::collection($user_document_list));
                } else {
                    return $this->apiResponseJson(false, 422, 'User documents not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function updateUserPreference(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'required',
            'height' => 'required',
            'marital_status' => 'required',
            'mother_tongue' => 'required',
            'physical_status' => 'required',
            'eating_habits' => 'required',
            'smoking_habits' => 'required',
            'drinking_habits' => 'required',
            'religion' => 'required',
            'community' => 'required',
            'caste' => 'required',
            'star' => 'required',
            'dosh' => 'required',
            'education_category' => 'required',
            'employed_in' => 'required',
            'occupation' => 'required',
            'annual_income' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'special_preference' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $user_preference_data = [
                    'age' => $request->age ?? NULL,
                    'height' => $request->height ?? NULL,
                    'marital_status' => $request->marital_status ?? NULL,
                    'mother_tongue' => $request->mother_tongue ?? NULL,
                    'physical_status' => $request->physical_status ?? NULL,
                    'eating_habits' => $request->eating_habits ?? NULL,
                    'smoking_habits' => $request->smoking_habits ?? NULL,
                    'drinking_habits' => $request->drinking_habits ?? NULL,
                    'religion' => $request->religion ?? NULL,
                    'community' => $request->community ?? NULL,
                    'caste' => $request->caste ?? NULL,
                    'star' => $request->star ?? NULL,
                    'dosh' => $request->dosh ?? NULL,
                    'education_category' => $request->education_category ?? NULL,
                    'employed_in' => $request->employed_in ?? NULL,
                    'occupation' => $request->occupation ?? NULL,
                    'annual_income' => $request->annual_income ?? NULL,
                    'country' => $request->country ?? NULL,
                    'state' => $request->state ?? NULL,
                    'city' => $request->city ?? NULL,
                    'special_preference' => $request->special_preference ?? NULL,
                ];

                $user_preference_update = UserPreference::updateOrCreate(['user_id' => Auth::user()->id], $user_preference_data);

                if (!empty($user_preference_update)) {
                    $user = User::find(Auth::user()->id);
                    return $this->apiResponseJson(true, 200, 'User preference saved successfully', new ProfileCollection($user));
                } else {
                    return $this->apiResponseJson(false, 422, 'User preference not saved', (object) []);
                }
            } catch (\Throwable $th) {
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function getUserRecommendation(Request $request)
    {
        try {
            $user_preference = auth()->user()->getUserPreference;
            if (!empty($user_preference)) {
                $age_arr = explode('-', $user_preference->age);
                $query = User::with(['getProfileBasicDetails', 'getFamilyDetails', 'getReligiousInformation', 'getProfessionalInformation', 'getLocation'])->where('id', '!=', auth()->user()->id);

                $query->where(function ($query) use ($user_preference, $age_arr) {
                    if ((!empty($age_arr[0])) && (!empty($age_arr[1]))) {
                        $query->whereBetween('age', [$age_arr[0], $age_arr[1]]);
                    }
                    $query->orWhere('religion', $user_preference->religion);
                    $query->orWhere('community', $user_preference->community);
                });

                $query->whereHas('getProfileBasicDetails', function ($query) use ($user_preference) {
                    $query->orWhere('height', $user_preference->height);
                    $query->orWhere('marital_status', $user_preference->marital_status);
                    $query->orWhere('mother_tongue', $user_preference->mother_tongue);
                    $query->orWhere('physical_status', $user_preference->physical_status);
                    $query->orWhere('eating_habits', $user_preference->eating_habits);
                    $query->orWhere('smoking_habits', $user_preference->smoking_habits);
                });

                $query->whereHas('getReligiousInformation', function ($query) use ($user_preference) {
                    $query->orWhere('caste', $user_preference->caste);
                    $query->orWhere('star', $user_preference->star);
                    $query->orWhere('dosh', $user_preference->dosh);
                });

                $query->whereHas('getProfessionalInformation', function ($query) use ($user_preference) {
                    $query->orWhere('education_category', $user_preference->education_category);
                    $query->orWhere('employed_in', $user_preference->employed_in);
                    $query->orWhere('occupation', $user_preference->occupation);
                    $query->orWhere('annual_income', $user_preference->annual_income);
                });

                $query->whereHas('getLocation', function ($query) use ($user_preference) {
                    $query->orWhere('country', $user_preference->country);
                    $query->orWhere('state', $user_preference->state);
                    $query->orWhere('city', $user_preference->city);
                });

                $matched_user = $query->get();

                if ($matched_user->count() > 0) {
                    return $this->apiResponseJson(true, 200, 'User match found successfully', MatchedProfileCollection::collection($matched_user));
                } else {
                    return $this->apiResponseJson(false, 422, 'User match found not found', []);
                }
            } else {
                return $this->apiResponseJson(true, 200, 'No preference found', []);
            }
        } catch (\Throwable $th) {
            // dd($th);
            return $this->apiResponseJson(false, 500, 'Something went wrong', []);
        }
    }

    public function addFavourite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favourite_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $favourite_exist = UserFavourite::where(['user_id' => auth()->user()->id, 'favourite_user_id' => $request->favourite_user_id])->first();

                if (!empty($favourite_exist)) {
                    if ($favourite_exist->is_active == 1) {
                        return $this->apiResponseJson(true, 200, 'User already added as favourite', (object) []);
                    } else {
                        $update_favourite = UserFavourite::where('id', $favourite_exist->id)->update(['is_active' => true]);
                        if (!empty($update_favourite)) {
                            return $this->apiResponseJson(true, 200, 'User updated as favourite', (object) []);
                        } else {
                            return $this->apiResponseJson(true, 200, 'No user updated as favourite', (object) []);
                        }
                    }
                } else {
                    $favourite_arr = [
                        'user_id' => auth()->user()->id,
                        'favourite_user_id' => $request->favourite_user_id
                    ];

                    $favourite_store = UserFavourite::create($favourite_arr);
                    if (!empty($favourite_store)) {
                        return $this->apiResponseJson(true, 200, 'User added to favourite list', (object) []);
                    } else {
                        return $this->apiResponseJson(true, 200, 'No user added', (object) []);
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function removeFavourite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favourite_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $favourite_inactive = UserFavourite::where('id', $request->favourite_id)->update(['is_active' => false]);
                if (!empty($favourite_inactive)) {
                    return $this->apiResponseJson(true, 200, 'User removed from favourite list', (object) []);
                } else {
                    return $this->apiResponseJson(true, 200, 'No user removed from favourite list', (object) []);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function favouriteList(Request $request)
    {
        try {
            $favourite_list = UserFavourite::where(['user_id' => auth()->user()->id, 'is_active' => true])->orderBy('id', 'desc')->get();
            if ($favourite_list->count() > 0) {
                return $this->apiResponseJson(true, 200, 'User favourite list found', FavouriteProfileCollection::collection($favourite_list));
            } else {
                return $this->apiResponseJson(true, 200, 'No user in favourite list', []);
            }
        } catch (\Throwable $th) {
            return $this->apiResponseJson(false, 500, 'Something went wrong', []);
        }
    }

    public function addShortlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shortlisted_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $shortlist_exist = UserShortlist::where(['user_id' => auth()->user()->id, 'shortlisted_user_id' => $request->shortlisted_user_id])->first();

                if (!empty($shortlist_exist)) {
                    if ($shortlist_exist->is_active == 1) {
                        return $this->apiResponseJson(true, 200, 'User already shortlisted', (object) []);
                    } else {
                        $update_shortlist = UserShortlist::where('id', $shortlist_exist->id)->update(['is_active' => true]);
                        if (!empty($update_shortlist)) {
                            return $this->apiResponseJson(true, 200, 'User shortlisted', (object) []);
                        } else {
                            return $this->apiResponseJson(true, 200, 'No user shortlisted', (object) []);
                        }
                    }
                } else {
                    $favourite_arr = [
                        'user_id' => auth()->user()->id,
                        'shortlisted_user_id' => $request->shortlisted_user_id
                    ];

                    $favourite_store = UserShortlist::create($favourite_arr);
                    if (!empty($favourite_store)) {
                        return $this->apiResponseJson(true, 200, 'User shortlisted successfully', (object) []);
                    } else {
                        return $this->apiResponseJson(true, 200, 'No user shortlisted', (object) []);
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function removeShortlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shortlist_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $shortlist_inactive = UserShortlist::where('id', $request->shortlist_id)->update(['is_active' => false]);
                if (!empty($shortlist_inactive)) {
                    return $this->apiResponseJson(true, 200, 'User removed from shortlisted list', (object) []);
                } else {
                    return $this->apiResponseJson(true, 200, 'No user removed from shortlisted list', (object) []);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }

    public function ShortlistedList(Request $request)
    {
        try {
            $shortlisted_list = UserShortlist::where(['user_id' => auth()->user()->id, 'is_active' => true])->orderBy('id', 'desc')->get();
            if ($shortlisted_list->count() > 0) {
                return $this->apiResponseJson(true, 200, 'User shortlisted list found', ShortlistProfileCollection::collection($shortlisted_list));
            } else {
                return $this->apiResponseJson(true, 200, 'No user in shortlisted list', []);
            }
        } catch (\Throwable $th) {
            return $this->apiResponseJson(false, 500, 'Something went wrong', []);
        }
    }

    public function addViewed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'viewed_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->apiResponseJson($status, $code, $message, $response);
        } else {
            try {
                $viewed_exist = UserView::where(['user_id' => auth()->user()->id, 'viewed_user_id' => $request->viewed_user_id])->first();

                if (!empty($viewed_exist)) {
                    $count_arr = ['visit_count' => (int)((int)($viewed_exist->visit_count) + 1)];
                    $update_viewed = UserView::where('id', $viewed_exist->id)->update($count_arr);
                    if (!empty($update_viewed)) {
                        return $this->apiResponseJson(true, 200, 'User updated as viewed', (object) []);
                    } else {
                        return $this->apiResponseJson(true, 200, 'No user updated as viewed', (object) []);
                    }
                } else {
                    $favourite_arr = [
                        'user_id' => auth()->user()->id,
                        'viewed_user_id' => $request->viewed_user_id,
                        'visit_count' => 1
                    ];

                    $favourite_store = UserView::create($favourite_arr);
                    if (!empty($favourite_store)) {
                        return $this->apiResponseJson(true, 200, 'User added to view list', (object) []);
                    } else {
                        return $this->apiResponseJson(true, 200, 'No user added', (object) []);
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
            }
        }
    }
    public function ViewedList(Request $request)
    {
        try {
            $viewed_list = UserView::where(['user_id' => auth()->user()->id, 'is_active' => true])->orderBy('id', 'desc')->get();

            if ($viewed_list->count() > 0) {
                return $this->apiResponseJson(true, 200, 'User viewed list found', ViewedProfileCollection::collection($viewed_list));
            } else {
                return $this->apiResponseJson(true, 200, 'No user in viewed list', []);
            }
        } catch (\Throwable $th) {
            return $this->apiResponseJson(false, 500, 'Something went wrong', []);
        }
    }
}
