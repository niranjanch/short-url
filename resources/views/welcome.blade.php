@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Simple URL Shortener using Laravel 5</h1>
    </div>

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            @include('layouts.partials.error')
            @include('layouts.partials.success')

            <form class="form-horizontal" id="short-url">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div id="response"></div>
                <div class="input-group form-group-lg">
                    <input type="text" name="url" id="url" class="form-control"
                           placeholder="http://your-website.com"
                           value="@if (Session::has('link')) {{ config('urlshortener.domain') . Session::get('link') }} @endif"
                    >
                          <span class="input-group-btn">
                                  <button  type="submit" class="btn btn-success btn-lg">Shorten !</button>
                          </span>
                </div><!-- /input-group -->
            </form>
            <button class="btn btn-warning btn-lg clipboard" data-clipboard-target="#url" type="button">
                                      COPY URL
                                  </button>
        </div>
    </div>
@stop

@section('scripts')
<script>
  new Clipboard('.clipboard');
  $(function(){
    $('#short-url').on('submit',function(e){
      $.ajaxSetup({
          header:$('input[name="_token"]').attr('content')
      })
      e.preventDefault(e);
      $.ajax({
          type:"POST",
          url:"{{ route('save') }}",
          data:$(this).serialize(),
          dataType: 'json',
          success: function(data){
              console.log(data);
          },
          error: function(data){
            var errors = data.responseJSON;
            //show them somewhere in the markup
            errorsHtml = '<div class="alert alert-danger">';
            $.each( errors, function( key, value ) {
                errorsHtml += value[0] ; //showing only the first error.
            });
            errorsHtml += '</div>';
            $('#response').show().html(errorsHtml); //this is my div with messages
          }
      })
    });
  });
</script>
@endsection