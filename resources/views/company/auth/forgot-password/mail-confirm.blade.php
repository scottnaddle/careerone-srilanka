<h1 class="dark:text-white">{{trans('auth.reset_password_title')}}</h1>

<p class="dark:text-white">{{trans('auth.reset_password_message')}}</p>
<a class="dark:text-white" href="{{ route('company.auth.resetPassword', $token) }}">{{trans('system.form.reset_password')}}</a>
