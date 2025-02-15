<div class="ms-auto">
    <div class="dropdown d-flex align-items-center me-4 me-md-2">
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button" id="filterBtn"                           data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <p class="text-center">
                <i class='fas fa-filter'></i>
            </p>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{__('messages.common.filter_option')}}</h3>
            </div>
            <div class="p-5">
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{__('messages.common.status')}}:</label>
                    {{ Form::select('status',\App\Models\User::STATUS, null,['class' => 'form-select io-select2', 'data-control'=>"select2", 'id' => 'userStatus']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-5 userStatusApply">{{__('messages.common.apply')}}</button>
                    <button type="button" class="btn btn-secondary" id="userStatusResetFilter">{{__('messages.common.reset')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<a type="button" class="btn btn-primary ms-auto" href="{{ route('users.create')}}">
    <span class="svg-icon svg-icon-2"></span>
    {{__('messages.user.add_user')}}</a>
