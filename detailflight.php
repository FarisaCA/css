<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop-Out Box Example</title>
   <style>
    body {
    font-family: Arial, sans-serif;
     }

    .modal-toggle {
    display: none; /* Hide the checkbox */
}

.open-modal {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    display: inline-block;
    text-decoration: none;
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    position: relative;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
}

.modal-toggle:checked + .modal {
    display: block; /* Show the modal when the checkbox is checked */
}

    </style>
</head>
<body>

<!-- Hidden checkbox to toggle the modal -->
<input type="checkbox" id="modalToggle" class="modal-toggle" />

<!-- Button to open the modal -->
<label for="modalToggle" class="open-modal">Open Pop-Out Box</label>

<!-- Modal structure -->
<div class="modal">
    <div class="modal-content">
        <label for="modalToggle" class="close">&times;</label>
        <h2>Pop-Out Box</h2>
        <p>This is a simple pop-out box created with PHP and CSS!</p>
    </div>
</div>

</body>
</html>
