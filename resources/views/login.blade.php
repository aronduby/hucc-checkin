@extends('app')

@section('content')

    <div class="view-login">
        <a href="{{route('saml2_login', 'gsuite')}}" class="google-btn">
            <div class="google-icon-wrapper">
                <img class="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"/>
            </div>
            <p class="btn-text">Sign in with Google</p>
        </a>
    </div>

@endsection
