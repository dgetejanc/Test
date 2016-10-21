@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			<img src ="/uploads/pictures/{{ $user->picture }}" style="width:150px; height:150px;">
			<form enctype="multipart/form-data" action="/profile" method="POST">
				<label>Update Profile Image</label>
				<input type="file" name="picture" />
				<input type="hidden" name="_token" value = "{{ csrf_token() }}" />
				<input type="submit" class="btn" />
			</form>
			</br></br>
			<form action="/profile/update" method='POST' ajax="true" class="form">
			  {{ method_field('PUT') }} <!-- hidden _method to use PUT in forms -->
			  <label for="name">Name:</label>
			  <input type="text" id="name" name="name" placeholder="{{ $user->name }}" required data-required-message="Name is required."><br>  <!-- HTML validation -->

			  <label for="email">Email:</label>
			  <input type="text" id="email" name="email" placeholder="{{ $user->email }}" required data-required-message="email is required."><br>

			  <label for="Phone">Phone:</label>
			 <input type="text" id="phone" name="phone" maxlength="14" placeholder="{{ $user->phone }}" required data-required-message="Phone is required."><br>

			  <input type="hidden" id="token" name="_token" value = "{{ csrf_token() }}" />
			  <label for="Interests">My Interests:</label></br>
			  <!-- Apparently, which is news to me. Laravel will automatically put checkbox selections into an array and that selection gets passed on a submit -->
			  	@foreach ($interests as $interest)
					 <input type="checkbox" class="interestCheckBox" name="interests[]" value="{{ $interest->name }}"> {{ $interest->name }}<br>
				@endforeach
			  <input type="submit" class="btn" value="Submit" />
			</form>
        </div>
    </div>
</div>

<!-- TODO Move this javascript before to a file. Keeping it here just so you can see it without moving between files, but I normally would move this to a js file-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">
$(document).ready(function(e) {

	/*I don't really need this, because Laravel does it already but here is the code I would use:
	var checkboxArr=[];
	$('input[type=checkbox]').each(function(){
	    checkboxArr.push(this);
	}); */

	$("form[ajax=true]").submit(function(e) {
		e.preventDefault();

		var token = $('#token').val(); //Token is requried on Laravel requests to protect agains CSRF
		$.ajax({
			url: '/profile/update',
			type: 'PUT',
				data: {
					name:$('#name').val(),
					email:$('#email').val(),
					phone:$('#phone').val(),
					_token:token
				},
			success: function(){

			}
		});

	});

});
</script>
<script>
$('.interestCheckBox')
	.on('change', function() {
		if($('.interestCheckBox:checked').length > 3) {
			this.checked = false;
		}
	});

$('#phone')
	.keydown(function (e) {
		var key = e.charCode || e.keyCode || 0;
		$phone = $(this);

		// Don't expose the mask
		if (key !== 8 && key !== 9) {
			if ($phone.val().length === 4) {
				$phone.val($phone.val() + ')');
			}
			if ($phone.val().length === 5) {
				$phone.val($phone.val() + ' ');
			}
			if ($phone.val().length === 9) {
				$phone.val($phone.val() + '-');
			}
		}

		// Allow numeric keys only
		return (key == 8 ||
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
	})

	.bind('focus click', function () {
		$phone = $(this);

		if ($phone.val().length === 0) {
			$phone.val('(');
		}
		else {
			var val = $phone.val();
			$phone.val('').val(val); // Make sure the cursor is at the end
		}
	})

	.blur(function () {
		$phone = $(this);

		if ($phone.val() === '(') {
			$phone.val('');
		}
	});

</script>



@endsection
