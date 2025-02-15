<div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('first_name', __('messages.user.first_name').':', ['class' => 'required form-label']) }}
            {{ Form::text('first_name',null, ['class' => 'form-control ', 'placeholder' => __('messages.user.first_name'), 'required']) }}
        </div>
        <div class="col-6">
            {{ Form::label('last_name', __('messages.user.last_name').':', ['class' => 'required   form-label ']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('messages.user.last_name'), 'required']) }}
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('email', __('messages.user.email').':', ['class' => 'required fs-5  form-label']) }}
            {{ Form::text('email', null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.user.email'), 'required']) }}
        </div>
        <div class="col-6">
            {{ Form::label('user_name', __('messages.user.user_name').':', ['class' => 'required fs-5  form-label']) }}
            {{ Form::text('user_name', null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.user.user_name'), 'required']) }}
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('password',__('messages.user.password').':' ,['class' => 'form-label required']) }}
            <span data-bs-toggle="tooltip" title="{{ __('messages.flash.user_8_or') }}">
                <i class="fa fa-question-circle mb-1"></i>
            </span>
            <div class="position-relative">
                {{Form::password('password',['class' => 'form-control userPassword','placeholder' => __('messages.user.password'),'autocomplete' => 'off','required','aria-label'=>"Password",'data-toggle'=>"password"])}}
                <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon userInput input-password-hide cursor-pointer text-gray-600"> 
                    <i class="bi bi-eye-slash-fill userPasswordIcon"></i>
                </span>
            </div>
        </div>
        <div class="col-6">
            {{ Form::label('Confirm Password',__('messages.user.password_confirmation').':' ,['class' => 'form-label required']) }}
            <span data-bs-toggle="tooltip" title="{{ __('messages.flash.user_8_or') }}">
                <i class="fa fa-question-circle mb-1"></i>
            </span>
            <div class="position-relative">
                {{Form::password('password_confirmation',['class' => 'form-control','placeholder' => __('messages.user.password_confirmation'),'autocomplete' => 'off','required','aria-label'=>"Password",'data-toggle'=>"password"])}}
                <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600"> <i class="bi bi-eye-slash-fill"></i> </span>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('role', __('messages.role.role').':', ['class' => 'form-label']) }}
                {{ Form::select('role',getAllRole(), null, ['class' => 'form-control','io-select2' ,'data-control'=>'select2']) }}
            </div>
        </div>
        <div class=" col-6">
            {{ Form::label('contact', __('messages.user.contact_no').':', ['class' => 'form-label required']) }}
            <br>
            {{ Form::tel('contact', null, ['class' => 'form-control w-100', 'placeholder' => __('messages.user.contact_no'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
            {{ Form::hidden('region_code', null,['id'=>'prefix_code']) }}
            <span id="valid-msg"
                  class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
            <span id="error-msg"
                  class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-5">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputImage" class="form-label">{{__('messages.common.profile')}}:</label>
                    <div class="d-block">
                        <div class="image-picker">
                            @php
                                $imageCss = 'style="background-image: url('.asset('images/avatar.png').')"';
                            @endphp
                            <div class="image previewImage" id="exampleInputImage"{!! $imageCss !!}></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{ __('messages.user.edit_profile') }}">
                        <label> 
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i> 
                            <input type="file" id="profilePicture" name="profile" class="image-upload d-none"
                                   accept="image/*"/> 
                        </label> 
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <label class="form-label">{{__('messages.common.status')}}:</label>
            <div class="col-lg-8">
                <div class="form-check form-check-solid form-switch">
                    <input tabindex="12" name="status" value="0" class="form-check-input" type="checkbox"
                           id="allowmarketing" checked="checked">
                    <label class="form-check-label" for="allowmarketing"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="fw-bolder fs-3 rotate collapsible mb-7">
        {{__('messages.user.address_information')}}
    </div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('address_1', __('messages.user.address_1').':', ['class' => 'form-label']) }}
            {{ Form::text('address_1',null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.user.address_1'),]) }}
        </div>
        <div class="col-6">
            {{ Form::label('address_2', __('messages.user.address_2').':', ['class' => 'form-label']) }}
            {{ Form::text('address_2', null, ['class' => 'form-control form-control-solid', 'placeholder' => __('messages.user.address_2')]) }}
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('country_id',__('messages.user.country').':' ,['class' => 'form-label required']) }}
            {{ Form::select('country_id', getCountries(), null,['class' => 'io-select2 form-select', 'data-control'=>"select2", 'id'=>'countryId','placeholder' => __('messages.common.select_country'), 'required']) }}
        </div>
        <div class="col-6">
            {{ Form::label('state', __('messages.user.state').':', ['class' => 'form-label ']) }}
            {{ Form::select('state', [], null, ['class' => 'io-select2 form-select', 'data-control'=>"select2", 'placeholder' => __('messages.common.select_state'), 'id' => 'stateId']) }}
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            {{ Form::label('city', __('messages.user.city').':', ['class' => 'form-label']) }}
            {{ Form::select('city', [], null, ['class' => 'io-select2 form-select', 'data-control'=>"select2", 'placeholder' => __('messages.common.select_city'), 'id' => 'cityId']) }}
        </div>
        <div class="col-6">
            {{ Form::label('zip', __('messages.user.zip').':', ['class' => 'form-label']) }}
            {{ Form::text('zip', null, ['class' => 'form-control', 'placeholder' => __('messages.user.zip'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        </div>
    </div>
</div>
<div class="d-flex">
    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2']) }}
    <a href="{{route('users.index')}}" type="reset"
       class="btn btn-secondary">{{__('messages.common.discard')}}</a>
</div>
