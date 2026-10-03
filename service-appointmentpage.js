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

// Form
const appointmentForm = document.getElementById("appointmentForm");

// =======================================
// SELECT ALL CHECKBOXES
// =======================================
const services = document.querySelectorAll(
    '.service-card input[type="checkbox"]'
);

// =======================================
// SERVICE DATA
// Price and Time
// =======================================
const serviceData = {
    "General Bike Service": {
        price: 1200,
        time: 150
    },
    "Engine Oil Change": {
        price: 500,
        time: 30
    },
    "Bike Wash": {
        price: 200,
        time: 20
    },
    "Brake Adjustment": {
        price: 200,
        time: 20
    },
    "Air Filter Cleaning": {
        price: 150,
        time: 20
    },
    "Tyre Replacement": {
        price: 2500,
        time: 60
    },
    "Battery Replacement": {
        price: 2000,
        time: 30
    },
    "Chain Cleaning": {
        price: 150,
        time: 20
    },
    "Brake Pad Replacement": {
        price: 700,
        time: 45
    },
    "Spark Plug Replacement": {
        price: 250,
        time: 15
    },
    "Tyre Puncture Repair": {
        price: 150,
        time: 30
    },
    "Battery Check": {
        price: 100,
        time: 10
    },
    "Clutch Adjustment": {
        price: 200,
        time: 20
    },
    "Engine Tuning": {
        price: 700,
        time: 60
    }
};

// =======================================
// DEFAULT VALUES
// =======================================
let totalServicePrice = 0;
let totalServiceTime = 0;
let selectedServices = 0;

// =======================================
// CALCULATE BOOKING SUMMARY
// =======================================
function calculateTotal() {
    // Reset values
    totalServicePrice = 0;
    totalServiceTime = 0;
    selectedServices = 0;

    // Check every service
    services.forEach(function(service) {
        if (service.checked) {
            // Get service name
            let serviceName = service.value;

            // Safely read price & time if match exists in serviceData
            if (serviceData[serviceName]) {
                totalServicePrice += serviceData[serviceName].price;
                totalServiceTime += serviceData[serviceName].time;
            }

            // Count selected service
            selectedServices++;
        }
    });

    // Show values on screen
    if (serviceCount) serviceCount.innerText = selectedServices;
    if (totalPrice) totalPrice.innerText = "₹" + totalServicePrice;
    if (totalTime) totalTime.innerText = totalServiceTime + " Minutes";
}

// =======================================
// EVENT LISTENER
// Whenever checkbox changes
// =======================================
services.forEach(function(service) {
    service.addEventListener("change", calculateTotal);
});

// =======================================
// LOAD DEFAULT VALUES
// =======================================
calculateTotal();

// =======================================
// CONFIRM APPOINTMENT
// =======================================
if (confirmButton) {
    confirmButton.addEventListener("click", function() {
        // Check Customer Details
        if (fullName && fullName.value.trim() === "") {
            alert("Please enter your Full Name");
            fullName.focus();
            return;
        }

        if (email && email.value.trim() === "") {
            alert("Please enter your Email Address");
            email.focus();
            return;
        }

        if (phone && phone.value.trim() === "") {
            alert("Please enter your Phone Number");
            phone.focus();
            return;
        }

        if (company && company.value === "Select Company") {
            alert("Please select Bike Company");
            company.focus();
            return;
        }

        if (model && model.value.trim() === "") {
            alert("Please enter Bike Model");
            model.focus();
            return;
        }

        if (bikeNumber && bikeNumber.value.trim() === "") {
            alert("Please enter Bike Registration Number");
            bikeNumber.focus();
            return;
        }

        if (date && date.value === "") {
            alert("Please select Appointment Date");
            date.focus();
            return;
        }

        if (time && time.value === "Select Time") {
            alert("Please select Time Slot");
            time.focus();
            return;
        }

        // Check Services
        if (selectedServices === 0) {
            alert("Please select at least one service.");
            return;
        }

        // Get Selected Service Names
        const selectedServiceNames = [];

        services.forEach(function(service) {
            if (service.checked) {
                selectedServiceNames.push(service.value);
            }
        });

        if (appointmentForm) {
            // Create Hidden Input: Services
            let servicesInput = document.createElement("input");
            servicesInput.type = "hidden";
            servicesInput.name = "services";
            servicesInput.value = selectedServiceNames.join(", ");
            appointmentForm.appendChild(servicesInput);

            // Create Hidden Input: Total Price
            let priceInput = document.createElement("input");
            priceInput.type = "hidden";
            priceInput.name = "total_price";
            priceInput.value = totalServicePrice;
            appointmentForm.appendChild(priceInput);

            // Create Hidden Input: Total Time
            let timeInput = document.createElement("input");
            timeInput.type = "hidden";
            timeInput.name = "total_time";
            timeInput.value = totalServiceTime;
            appointmentForm.appendChild(timeInput);

            // Submit Form
            appointmentForm.submit();
        }
    });
}