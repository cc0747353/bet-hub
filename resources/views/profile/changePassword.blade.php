<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.user.change_password') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{Form::open(['id'=>'changePasswordForm'])}}
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="mb-7">
                    {{Form::label('current_password',__('messages.user.current_password').':',['class' => 'required form-label'] )}}
                    <div class="mb-3 position-relative">
                        {{Form::password('current_password',['class' => 'form-control userPassword','placeholder' => __('messages.user.current_password'),'autocomplete' => 'off','required','aria-label'=>"Password",'data-toggle'=>"password"])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600"> <i class="bi bi-eye-slash-fill"></i> </span>
                    </div>
                </div>
                <div class="mb-7">
                    {{Form::label('new_password',__('messages.user.new_password').':',['class' => 'required form-label'] )}}
                    <div class="mb-3 position-relative">
                        {{Form::password('new_password',['class' => 'form-control userPassword','placeholder' => __('messages.user.new_password'),'autocomplete' => 'off','required','aria-label'=>"Password",'data-toggle'=>"password"])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600"> <i class="bi bi-eye-slash-fill"></i> </span>
                    </div>
                </div>
                <div>
                    {{Form::label('confirm_password',__('messages.user.password_confirmation').':',['class' => 'required form-label'] )}}
                    <div class="mb-3 position-relative">
                        {{Form::password('confirm_password',['class' => 'form-control userPassword','placeholder' => __('messages.user.password_confirmation'),'autocomplete' => 'off','required','aria-label'=>"Password",'data-toggle'=>"password"])}}
                        <span class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600"> <i class="bi bi-eye-slash-fill"></i> </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'passwordChangeBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>
