@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Add</div>
                    <div class="card-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="">title</label>
                                <input type="text" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">duration</label>
                                <input type="text" name="duration" id="duration" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">description</label>
                                <textarea name="description" id="description" cols="30" class="form-control" rows="7"></textarea>
                            </div>
                            <div class="form-group questions-list">
                                <div class="single-question">
                                    <label for="">Q1</label>
                                    <input type="text" class="form-control" id="question">
                                    <div class="row answers-container my-2">
                                        <div class="col-3">
                                            <input type="text" name="answer_1" id="answer_1" class="form-control"
                                                placeholder="first answer">
                                            <input type="checkbox" class="correct" value="0">
                                        </div>
                                        <div class="col-3"> <input type="text" name="answer_1" id="answer_2"
                                                class="form-control" placeholder="first answer">
                                            <input type="checkbox" class="correct" value="1">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" name="answer_1" id="answer_3" class="form-control"
                                                placeholder="first answer">
                                            <input type="checkbox" class="correct" value="2">
                                        </div>
                                        <div class="col-3"> <input type="text" name="answer_1" id="answer_4"
                                                class="form-control" placeholder="first answer">
                                            <input type="checkbox" class="correct" value="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="submit" id="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('docuemnt').ready(function() {

            $('body').on('click', '#submit', function(e) {
                e.preventDefault();
                let quiz_info = {
                    title: $('#title').val(),
                    duration: $('#duration').val(),
                    description: $('#description').val(),
                    questions: [{
                        question: $('#question').val(),
                        answers: [
                            $('#answer_1').val(),
                            $('#answer_2').val(),
                            $('#answer_3').val(),
                            $('#answer_4').val()
                        ],
                        correct: $('.correct').val()
                    }]
                };
                $.ajax({
                    type: 'POST',
                    url: '/api/quiz',
                    data: quiz_info,
                    headers: {
                        "Authorization": `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjY0ODY5ODU4LCJleHAiOjE2NjQ4NzM0NTgsIm5iZiI6MTY2NDg2OTg1OCwianRpIjoiekVZZlZjMFVWWno4MGtwYSIsInN1YiI6IjI1IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.PhX76z-eTJ_KY-23gHigWv1hLZ2Q7JTgqSZFXzNwUs0`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    console.log(response)
                })
            })
        })
    </script>
@endsection
