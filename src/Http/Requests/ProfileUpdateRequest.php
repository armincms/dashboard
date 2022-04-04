<?php

namespace Armincms\Dashboard\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;  
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{     
    /**
     * User metadata fields.
     * 
     * @var array
     */
    public $metadatas = [ 
        'firstname',
        'lastname',
        'mobile',
        'phone',
        'birthday',
        'gender',
    ];  
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('updateProfile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ 
            'email' => 'required|email|unique:users,id,' . $this->user()->getKey(),
            'name' => 'required|string|unique:users,id,' . $this->user()->getKey(),
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile' => ['nullable', function($attribute, $value, $fail) {
                $query = $this->user()->query();
                $found = $query
                            ->whereKeyNot($this->user()->getKey())
                            ->whereHas('metadatas', function($query) use ($value) {
                                return $query->where([
                                    'key' => 'mobile',
                                    'value' => $value,
                                ]);
                            })->exists();

                if ($found) return $fail(__('This mobile number already taken.'));
            }],
            'phone' => 'nullable|numeric',
            'gender' => 'required|in:male,female',
            'birthday' => 'sometimes|date', 
            'avatar' => 'nullable|image',
            'old_password' => [ 
                'nullable',
                'required_with:password',
                function($attribute, $value, $fail) {
                    if (! Hash::check($value, $this->user()->password)) {
                        return $fail(__('The old password is wrong.'));
                    }
                }
            ],
            'password' => [
                'nullable', 
                'confirmed', 
                \Illuminate\Validation\Rules\Password::defaults()
            ],
        ];
    }

    /**
     * Update user profile.
     * 
     * @return void
     */
    public function updateUserProfile()
    {
        $this->user()->forceFill($this->only('email', 'name')); 

        if ($this->password) {
            $this->user()->forceFill(['password' => Hash::make($this->password)]); 
        }

        $this->user()->save();

        if (! $this->filled('hasAvatar') || ! intval($this->input('hasAvatar'))) {
            $this->user()->clearMediaCollection('avatar');
        }

        if ($this->hasFile('avatar')) {
            $this->user()->addMedia($this->file('avatar'))->toMediaCollection('avatar');
        }

        $this->user()->updateMetadatas($this->only($this->metadatas));

        return $this->user()->refresh();     
    } 
}
