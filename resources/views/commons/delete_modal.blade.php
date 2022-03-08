<form id="delete_form" class="ui modal form" method="POST">
	<i class="close icon"></i>

	<div class="header">
		Remove <span class="delete_modal_name"></span>
	</div>

	<div class="content">
		<p>Are you sure you want to remove the selected <span class="delete_modal_name"></span>? <b style="color: red;"><u>This cannot be undone.</u></b></p>

		<br>

		{{ csrf_field() }}
		{{ method_field('DELETE') }}

		<div class="fields">
			<div class="four wide field"></div>

			<div class="eight wide field">
				<label>Confirm your password before deleting:</label>
				<input type="password" name="password" required="">
			</div>
		</div>
	</div>

	<div class="actions">
		<div class="ui black deny button">
			No
		</div>

		<button class="ui red button" type="submit">Yes</button>
	</div>
</form>