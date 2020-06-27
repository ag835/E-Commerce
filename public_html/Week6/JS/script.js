function validate(form){
    errors = [];
    if(form.hasOwnProperty("name") && form.hasOwnProperty("category")
        && form.hasOwnProperty("quantity") && form.hasOwnProperty("price")){
        if (form.name.value == null ||
            form.name.value == undefined ||
            form.name.value.length == 0) {
            errors.push("Name must not be empty");
        }
        if (form.category.value == null ||
            form.category.value == undefined ||
            form.category.value.length == 0) {
            errors.push("Category must not be empty");
        }
        if (form.quantity.value == null ||
            form.quantity.value == undefined ||
            form.quantity.value.length == 0 || form.quantity.value < 0) {
            errors.push("Quantity must be positive number and not empty");
        }
        if (form.price.value == null ||
            form.price.value == undefined ||
            form.price.value.length == 0 || form.price.value < 0) {
            errors.push("Price must be positive number and not empty");
        }
    }
    if(errors.length > 0){
        alert(errors);
        return false;//prevents form submission
    }
    return  true;//allows form submission
}