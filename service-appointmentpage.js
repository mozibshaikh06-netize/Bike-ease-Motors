// =======================================
// SELECTING HTML ELEMENTS
// =======================================

// Customer Details

const fullName = document.getElementById("fullname");

const email = document.getElementById("email");

const phone = document.getElementById("phone");

const company = document.getElementById("company");

const model = document.getElementById("model");

const bikeNumber = document.getElementById("bike_number");

const date = document.getElementById("date");

const time = document.getElementById("time");


// Booking Summary

const totalPrice = document.getElementById("totalPrice");

const totalTime = document.getElementById("totalTime");

const serviceCount = document.getElementById("serviceCount");


// Confirm Button

const confirmButton = document.querySelector(".confirm-btn");

// SELECT ALL CHECKBOXES

const services = document.querySelectorAll(
'.service-card input[type="checkbox"]'
);



// SERVICE DATA
// Price and Time


const serviceData = {

    "General Bike Service": {

        price:1200,

        time:150

    },

    "Engine Oil Change": {

        price:500,

        time:30

    },

    "Bike Wash": {

        price:200,

        time:20

    },

    "Brake Adjustment": {

        price:200,

        time:20

    },

    "Air Filter Cleaning": {

        price:150,

        time:20

    },

    "Tyre Replacement": {

        price:2500,

        time:60

    },

    "Battery Replacement": {

        price:2000,

        time:30

    },

    "Chain Cleaning": {

        price:150,

        time:20

    },

    "Brake Pad Replacement": {

        price:700,

        time:45

    },

    "Spark Plug Replacement": {

        price:250,

        time:15

    },

    "Tyre Puncture Repair": {

        price:150,

        time:30

    },

    "Battery Check": {

        price:100,

        time:10

    },

    "Clutch Adjustment": {

        price:200,

        time:20

    },

    "Engine Tuning": {

        price:700,

        time:60

    }

};



// DEFAULT VALUES


let totalServicePrice = 0;

let totalServiceTime = 0;

let selectedServices = 0;


// CALCULATE BOOKING SUMMARY


function calculateTotal() {

    // Reset values

    totalServicePrice = 0;

    totalServiceTime = 0;

    selectedServices = 0;

// Check every service

    services.forEach(function(service){

        if(service.checked){

            // Get service name

            let serviceName = service.value;


            // Add price

            totalServicePrice += serviceData[serviceName].price;


            // Add time

            totalServiceTime += serviceData[serviceName].time;


            // Count selected service

            selectedServices++;

        }

    });


    // Show values on screen

    serviceCount.innerText = selectedServices;

    totalPrice.innerText = "₹" + totalServicePrice;

    totalTime.innerText = totalServiceTime + " Minutes";

}




// EVENT LISTENER
// Whenever checkbox changes


services.forEach(function(service){

    service.addEventListener("change",calculateTotal);

});




// LOAD DEFAULT VALUES


calculateTotal();


// CONFIRM APPOINTMENT


confirmButton.addEventListener("click", function () {

    // Check customer details

    if(fullName.value==""){

        alert("Please enter your Full Name");

        fullName.focus();

        return;

    }


    if(email.value==""){

        alert("Please enter your Email Address");

        email.focus();

        return;

    }


    if(phone.value==""){

        alert("Please enter your Phone Number");

        phone.focus();

        return;

    }


    if(company.value=="Select Company"){

        alert("Please select Bike Company");

        company.focus();

        return;

    }


    if(model.value==""){

        alert("Please enter Bike Model");

        model.focus();

        return;

    }


    if(bikeNumber.value==""){

        alert("Please enter Bike Registration Number");

        bikeNumber.focus();

        return;

    }


    if(date.value==""){

        alert("Please select Appointment Date");

        date.focus();

        return;

    }


    if(time.value=="Select Time"){

        alert("Please select Time Slot");

        time.focus();

        return;

    }



    // Check Service

    if(selectedServices==0){

        alert("Please select at least one service.");

        return;

    }



    // Success

    alert(

"Appointment Booked Successfully!\n\n"

+

"Selected Services : "

+

selectedServices

+

"\n"

+

"Estimated Time : "

+

totalServiceTime

+

" Minutes\n"

+

"Total Amount : ₹"

+

totalServicePrice

    );



    
    // FUTURE PHP
   

    // Later you can write

    // document.getElementById("appointmentForm").submit();

});
