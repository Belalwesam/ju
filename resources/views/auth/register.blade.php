@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-12 col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <div class="errors-container">
                        <ul class="text-danger errors-list">

                        </ul>
                    </div>
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="name">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="submit-btn" type="button">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('docuemnt').ready(function() {
            $('body').on('click', '#submit-btn', function(e) {
                $.ajax({
                    type: 'POST',
                    url: @json({{ route('user.register') }}),
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        password: $('#password').val()
                    },
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        localStorage.setItem('token' , JSON.stringify(response.token))
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors
                        console.log(errors)
                        Object.entries(errors).forEach(error => {
                            console.log(error)
                            $('.errors-list').append(`<li> ${error[1]}</li>`);
                        })
                    }
                })
            })
        })
    </script>
@endsection
