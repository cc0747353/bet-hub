<div id="loginModal" class="modal fade " role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Login Required</h3>
                <button type="button" class="btn fa fa-close fs-4 text-primary border border-primary" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-3 text-center text-gray-500">
                        <h5 class="mb-3">Placing Bet Requires Login</h5>
                        <span>If you are already with us then please</span> 
                        <span>Login</span> 
                        <span>otherwise</span> 
                        <span>Register</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <a href="{{ route('login') }}"><button type="button" class="btn bg-blue-200 m-0 text-white" id="loginModalBtn">{{ __('messages.common.login')}}</button></a>
                <a href="{{ route('register') }}"><button type="button" class="btn bg-blue-200 m-0 text-white">Register</button></a>
            </div>
        </div>
    </div>
</div>
