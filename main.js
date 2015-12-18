$(document).ready(function() {
	//to generate a token
	$('#btnGetToken').on("click", function() {
		var pass = $('#password').val();

		var result = $.ajax({
			url: "confirmLogin.php",
			method: "POST",
			data: {"password": pass},
			success: function(result) {
				$('#token').text(result);
			}
		});
	})
	//to get all records
	$('#btnGetAll').on("click", function() {
		var token = $('#allItemsToken').val();
		$('#getAllItemsResults').empty();
		$.ajax({
			url: "items.php",
			method: "GET",
			headers: {"token": token},
			success: function(result) {
				result = jQuery.parseJSON(result);
				var tableHtml = "<table><tr><th>ID</th><th>Description</th><th>Price</th><th>Quantity</th></tr>";
				$.each(result, function(i, item) {
					tableHtml += "<tr><td>";
					tableHtml += item.id + "</td><td>";
					tableHtml += item.description + "</td><td>";
					tableHtml += "$" + item.price + "</td><td>";
					tableHtml += item.qty + "</td></tr>";
				})
				tableHtml += "</table>";
				$('#getAllItemsResults').replaceWith(tableHtml);
			}
		});
	})
	//to add a new record
	$('#btnNewItem').on("click", function() {
		var token = $('#newItemToken').val();
		var desc = $('#newItemDesc').val();
		var price = $('#newItemPrice').val();
		var quantity = $('#newItemQuantity').val();
		$('#newItemResults').empty();
		$.ajax({
			url: "items.php",
			method: "PUT",
			data: {
				"desc": desc,
				"price": price,
				"quantity": quantity
			},
			headers: {"token": token},
			success: function(result) {
				$('#newItemResults').text(result);
			}
		});
	})
	//to update a record
	$('#btnUpdateItem').on("click", function() {
		var token = $('#updateItemToken').val();
		var id = $('#updateItemId').val();
		var desc = $('#updateItemDesc').val();
		var price = $('#updateItemPrice').val();
		var quantity = $('#updateItemQuantity').val();
		$('#updateItemResults').empty();
		$.ajax({
			url: "items.php",
			method: "POST",
			data: {
				"id": id,
				"desc": desc,
				"price": price,
				"quantity": quantity
			},
			headers: {"token": token},
			success: function(result) {
				$('#updateItemResults').text(result);
			}
		});
	})
	//to get item by id
	$('#btnGetById').on("click", function() {
		var token = $('#getItemByIdToken').val();
		var id = $('#getById').val();
		$('#getByIdResults').empty();
		$.ajax({
			url: "items.php",
			method: "GET",
			data: {"id": id},
			headers: {"token": token},
			success: function(result) {
				result = jQuery.parseJSON(result);
				var resultHtml = "ID: " + result.id;
				resultHtml += "<br />Description: "+ result.description;
				resultHtml += "<br />Price: $" + result.price;
				resultHtml += "<br />Quantity: " + result.qty;
				$('#getByIdResults').replaceWith(resultHtml);
			}
		});
	})
	//to delete an item
	$('#btnDeleteItem').on("click", function() {
		var token = $('#deleteItemToken').val();
		var id = $('#deleteItem').val();
		$('#deleteResults').empty();
		$.ajax({
			url: "items.php", 
			method: "DELETE",
			data: {"id": id},
			headers: {"token": token},
			success: function(result) {
				$('#deleteResults').text(result);
			}
		});
	})
})