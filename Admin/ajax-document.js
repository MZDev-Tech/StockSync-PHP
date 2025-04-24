//function to update category using ajax
function bindUpdateForm() {
$("#updateForm").on("submit", function (e) {
e.preventDefault();
let formdata = new FormData(this);
formdata.append("save_data", true);
console.log("Form data being sent:", formdata);

$.ajax({
url: "update-document.php",
method: "POST",
data: formdata,
contentType: false,
processData: false,
dataType: "json", // Expect a JSON response
success: function (response) {
if (response.status === "success") {
Swal.fire({
title: "Success",
text: response.message,
icon: "success",
showConfirmButton: false,
timer: 2000,
}).then(() => {
window.location.href = response.redirect; // Redirect after success
});
} else {
Swal.fire("Error", response.message, "error");
}
},
error: function (error) {
console.log("Error occurred:", error);
Swal.fire("Error", "Something went wrong!", "error");
},
});
});
}
//make function global
window.bindUpdateForm = bindUpdateForm;

//insert catgroy data from
function bindInsertForm() {
$("#insertForm").on("submit", function (e) {
e.preventDefault();
var addformData = new FormData(this);
addformData.append("save_data", true);

$.ajax({
url: "AddDocument.php",
method: "POST",
data: addformData,
contentType: false, // Required when sending FormData (prevents jQuery from setting a content type)
processData: false, // Ensures data is sent as FormData, not URL-encoded
dataType: "json",

success: function (respond) {
if (respond.status === "success") {
Swal.fire({
title: "Success",
text: respond.message,
icon: "success",
timer: 2000,
showConfirmButton: false,
}).then(() => {
window.location.href = respond.redirect;
});
} else {
Swal.fire("Error", respond.message, "error");
}
},
error(error) {
console.error("Invalid JSON response:", error);
Swal.fire("Error", "Invalid server response.", "error");
},
});
});
}
window.bindInsertForm = bindInsertForm;