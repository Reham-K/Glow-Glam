/**
 * Task 13: Client-side Form Validation
 * This script ensures all required fields are filled correctly before submission.
 */

// Function to validate the Admin Login form
function validateLoginForm() {
    const user = document.getElementById('username').value.trim();
    const pass = document.getElementById('password').value.trim();

    if (user === "" || pass === "") {
        alert("Error: Username and Password are required.");
        return false;
    }
    return true;
}

// Function to validate Admin Add/Edit Product forms
function validateProductForm() {
    const name = document.getElementsByName('name')[0].value.trim();
    const price = document.getElementsByName('price')[0].value;
    const stock = document.getElementsByName('stock')[0].value;

    if (name === "" || price <= 0 || stock < 0) {
        alert("Error: Please provide a valid Name, Price (>0), and Stock (>=0).");
        return false;
    }
    return true;
}

// Function to validate the Checkout form
function validateCheckoutForm() {
    const name = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    const address = document.getElementById('address').value.trim();
    
    // Simple Email Regular Expression
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name === "" || email === "" || address === "") {
        alert("Error: All shipping fields are mandatory.");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Error: Please enter a valid email address format.");
        return false;
    }

    return true;
}

// Function for Cart Quantity validation
function validateQuantity(input, maxStock) {
    if (input.value <= 0) {
        alert("Quantity must be at least 1.");
        input.value = 1;
    } else if (input.value > maxStock) {
        alert("Error: Only " + maxStock + " items available in stock.");
        input.value = maxStock;
    }
}