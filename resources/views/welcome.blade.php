@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>URL Shortner Service</h1>
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
                           placeholder="http://your-website.com" >
                          <span class="input-group-btn">
                                  <input class="btn btn-secondary btn-lg" type="reset" id="reset" value="X">
                                  <button  type="submit" class="btn btn-success btn-lg" id="shorten">Shorten !</button>
                                  <button class="btn btn-warning btn-lg clipboard" id="copyUrl" data-clipboard-target="#url" type="button" style="display: none;">Copy URL</button>
                          </span>
                </div><!-- /input-group -->
            </form>
            <div class="btn-group">
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
  // copy the url Intialize
  new Clipboard('.clipboard');

  $(function(){

    //On click reset change the buttons visibility
    $("#reset").click(function(){
        $('#shorten').show();
        $('#copyUrl').hide();
    });

    // On Submit form handle ajax call
    $('#short-url').on('submit',function(e){
      //for the CSRF set header
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
              $('#shorten').hide();
              $('#copyUrl').show();
              $('#url').val(data.shortUrl);
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