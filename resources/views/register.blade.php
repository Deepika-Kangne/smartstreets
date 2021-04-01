@extends('layout')
@section('title','Register')
@section('menu_register', 'active')
@push('link')
@endpush

@section('mycontent')
<h1>Registration</h1>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    {{ Session::get('success') }}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    {{ Session::get('error') }}
</div>
@endif
<div class="row">
    <div class="col"></div>
    <div class="col">
        <form action="User/RegisterUser" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <input type="text" name="name" placeholder="Name" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" name="email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" name="mobile" placeholder="Mobile" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" name="street" id="address_search" placeholder="Street" class="form-control">
                <ul id="searchResult"></ul>
            </div>
            <div class="form-group">
                <input type="text" name="city" id="city" placeholder="City" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" name="state" id="state" placeholder="State" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode" class="form-control">
            </div>
            <!-- here I have mentioned mt-2 for proper spacing between two elements :) -->
            <div class="mt-2 form-group">
                <input type="submit" value="submit" class="btn btn-primary">
                <input type="reset" value="reset" class="btn btn-secondary">
            </div>
            <!-- This must be submitted to store method in controller as per resource rule 
				so let's create it there :) -->
        </form>
    </div>
    <div class="col"></div>
</div>
<!-- Script -->
<script type="text/javascript">
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {


        $("#address_search").keyup(function() {
            var search = $(this).val();

            if (search != "") {

                $.ajax({
                    url: "https://us-autocomplete-pro.api.smartystreets.com/lookup?key=82995000829989713&search=" + search + "",
                    method: "GET",
                    timeout: 0,
                    headers: {

                    },
                    success: function(response) {

                        var len = response.suggestions.length;
                        $("#searchResult").empty();
                        for (var i = 0; i < len; i++) {
                            //console.log(response.suggestions[i].street_line);
                            $("#searchResult").append("<li value='" + response.suggestions[i].street_line + "' city=" +
                                response.suggestions[i].city + " state=" +
                                response.suggestions[i].state + " zipcode=" + response.suggestions[i].zipcode + ">" + response.suggestions[i].street_line + "</li>");

                        }

                        $("#searchResult li").bind("click", function() {
                            setText(this);
                        });

                    }
                });
            }

        });

        function setText(element) {

            var value = $(element).text();

            $("#address_search").val(value);
            $("#city").val((element).getAttribute('city'));
            $("#state").val((element).getAttribute('state'));
            $("#zipcode").val((element).getAttribute('zipcode'));
            $("#searchResult").empty();


        }


    });
</script>
@endsection