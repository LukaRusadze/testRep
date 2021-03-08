// Waiting for the website to be loaded until doing anything
$(document).ready(() => {

    // Handling the form submit event
    $("#submitForm").submit((event) => {

        // Cancelling the default event so the website doesn't refresh on submit
        event.preventDefault();

        let submitData = document.getElementById("submitForm")

        // Storing form data in an object to be easily accessable
        // and usable when it comes to sending http requests
        let formData = {
            firstName: submitData[0].value,
            lastName: submitData[1].value,
            email: submitData[2].value
        }

        // Sending form data with post request to proccessSubmit.php
        // so it can be added to the database
        $.ajax({
            type: "POST",
            url: "processSubmit.php",
            data: formData,
            dataType: "json"
        }).done((data) => {

            // Handling the return data from proccessSubmit.php
            if (data.success) {
                $("#response").html(data.dbCallback);
            } else {
                $("#response").html(data.errors.join("<br>"));
            }
        }).fail((error) => {
            console.log(error);
        })


    })
})