// Get the modal
document.addEventListener('DOMContentLoaded', function() {
    // var modal = document.getElementById("myModal");
// // Get the button that opens the modal
//     var btn = document.getElementById("myBtn");
// // Get the <span> element that closes the modal
//     var span = document.getElementsByClassName("close")[0];


    // function openModal() {
    //     var modal = document.getElementById('myModal');
    //     modal.style.display = "block";
    // }
    // function openLogModal() {
    //     var modal = document.getElementById('logModal');
    //     modal.style.display = "block";
    // }
    // function openSingleModal() {
    //     var modal = document.getElementById('singleModal');
    //     modal.style.display = "block";
    // }


//
// // Get the modal
// var modal2 = document.getElementById("logModal");
// // Get the button that opens the modal
// var btn2 = document.getElementById("logBtn");
// // Get the <span> element that closes the modal
// var span2 = document.getElementsByClassName("close2")[0];
//
// //
// // // Get the modal
// var modal3 = document.getElementById("singleModal");
// // Get the button that opens the modal
// var btn3 = document.getElementById("singleModalbtn");
// // Get the <span> element that closes the modal
// var span3 = document.getElementsByClassName("close3")[0];

// When the user clicks on the button, open the modal
// window.onload = function () {
//
//     btn.onclick = function () {
//         modal.style.display = "block";
//     }
// }
// // When the user clicks on the button, open the modal
// btn2.onclick = function() {
//     modal2.style.display = "block";
// }
// // When the user clicks on the button, open the modal
// btn3.onclick = function() {
//     modal3.style.display = "block";
// }
//
// When the user clicks on <span> (x), close the modal
//     span.onclick = function () {
//         modal.style.display = "none";
//     }
// span2.onclick = function() {
//     modal2.style.display = "none";
// }
// span3.onclick = function() {
//     modal3.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
//     window.onclick = function (event) {
//         if (event.target === modal) {
//             modal.style.display = "none";
//             // modal2.style.display = "none";
//         }
//     }
// window.onclick = function(event) {
//     if (event.target === modal2) {
//         modal2.style.display = "none";
//     }
// }
// window.onclick = function(event) {
//     if (event.target === modal3) {
//         modal3.style.display = "none";
//     }
// }
// Turnoro istorijos modalas


// // Get the <span> element that closes the modal
// var span2 = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// btn2.onclick = function() {
//     modal2.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span2.onclick = function() {
//     modal2.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal2) {
//         modal2.style.display = "none";
//     }
// }

// matcho save buttonui
// $(document).ready(function () {
//
//     $("#matchForm").submit(function (e) {
//
//         //stop submitting the form to see the disabled button effect
//         e.preventDefault();
//
//         //disable the submit button
//         $("#matchSave").attr("disabled", true);
//         //
//         // //disable a normal button
//         // $("#btnTest").attr("disabled", true);
//         // $("#quantity1").attr("disabled", true);
//         // $("#quantity2").attr("disabled", true);
//         return true;
//
//     });
// });


    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }

    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("somedate")[0].setAttribute('min', today);
});
