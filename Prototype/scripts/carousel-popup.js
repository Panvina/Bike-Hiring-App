/* Reference = https://www.w3schools.com/howto/howto_css_modal_images.asp */
/* Code completed by Aadesh Jagannathan - 102072344*/  
   
    /* Retreiving all image modals by ID */
    var imgOne = document.getElementById("img-one");
    var imgTwo = document.getElementById("img-two");
    var imgThree = document.getElementById("img-three");
    var imgFour = document.getElementById("img-four");
    var imgFive = document.getElementById("img-five");
    var imgSix = document.getElementById("img-six");
    var imgSeven = document.getElementById("img-seven");
    
    /* Retreiving all images by ID */
    var cell1 = document.getElementById("img1");
    var cell2 = document.getElementById("img2");
    var cell3 = document.getElementById("img3");
    var cell4 = document.getElementById("img4");
    var cell5 = document.getElementById("img5");
    var cell6 = document.getElementById("img6");
    var cell7 = document.getElementById("img7");
    
     /* Functions to display modal onclick */
    cell1.onclick = function()
    {
        imgOne.style.display = "block";
    }
    cell2.onclick = function()
    {
        imgTwo.style.display = "block";
    }
    cell3.onclick = function()
    {
        imgThree.style.display = "block";
    }
    cell4.onclick = function()
    {
        imgFour.style.display = "block";
    }
    cell5.onclick = function()
    {
        imgFive.style.display = "block";
    }
    cell6.onclick = function()
    {
        imgSix.style.display = "block";
    }
    cell7.onclick = function()
    {
        imgSeven.style.display = "block";
    }
    
    // Get the <span> element that closes the modal
    var close = document.getElementsByClassName("close-btn");

    for (let i = 0; i < close.length; i++)
    {
        close[i].onclick = function()
        {
            closeModal(imgOne);
            closeModal(imgTwo);
            closeModal(imgThree);
            closeModal(imgFour);
            closeModal(imgFive);
            closeModal(imgSix);
            closeModal(imgSeven);
        }
    }
    function closeModal(modal)
    {
        modal.style.display = "none";
    }
