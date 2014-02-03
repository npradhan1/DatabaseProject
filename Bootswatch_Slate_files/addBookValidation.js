$return_val = true;

function formValidation(){
	var title = document.addBook.title;
	var author = document.addBook.author;
	var isbn = document.addBook.isbn;
	var quantity = document.addBook.quantity;
	var subject = document.addBook.subject;
	
	if(checkTitle(title)){
		if(checkAuthor(author)){
			if(checkISBN(isbn)){
				if(checkQuantity(quantity)){
					if(checkSubject(subject)){
						return true;
					} 
				}
			}		
		}
	}
	return return_val;
} 

function checkTitle(name){ 
	var letters = /^[A-Za-z ]+$/;
	if(name.value.match(letters)){
		return true;
	}else{
		alert('Title must have alphabet characters only');
		name.focus();
		return_val = false;
		return false;
	}
}

function checkAuthor(name){ 
	var letters = /^[A-Za-z ]+$/;
	if(name.value.match(letters)){
		return true;
	}else{
		alert('Author name must have alphabet characters only');
		name.focus();
		return_val = false;
		return false;
	}
}

function checkSubject(name){ 
	var letters = /^[A-Za-z ]+$/;
	if(name.value.match(letters)){
		return true;
	}else{
		alert('Subject must have alphabet characters only');
		name.focus();
		return_val = false;
		return false;
	}
}

function checkQuantity(quantity){ 
	var numbers = /^[0-9]+$/;
	if(quantity.value.match(numbers))	{
		return true;
	}
	else{
		alert('Quantity must have numeric characters only');
		quantity.focus();
		return_val = false;
		return false;
	}
}

function checkISBN(quantity){ 
	var numbers = /^[0-9]+$/;
	if(quantity.value.match(numbers))	{
		return true;
	}
	else{
		alert('ISBN must have numeric characters only');
		quantity.focus();
		return_val = false;
		return false;
	}
}