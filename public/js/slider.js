// Get slider items | Array.from [ES6]
let sliderImages = Array.from(document.querySelectorAll('.slider-container img'));

// Get number of slides
let slidesCount = sliderImages.length;

// Set current slide
let currentSlide = 1;

let slideNumber = document.getElementById('slider-number'),
    previous = document.getElementById('prev'),
    next = document.getElementById('next');

// Hand click on prev and next Buttons

next.onclick = nextSlide;
previous.onclick = previousSlide;

// create the main UL element
let paginationElement = document.createElement('ul');
paginationElement.setAttribute('id', 'pagination-ul');

for (let i = 1; i <= slidesCount; i++) {
    // create the li
    let paginationItem = document.createElement('li');
    paginationItem.setAttribute('data-index', i);
    paginationItem.appendChild(document.createTextNode(i));
    paginationElement.appendChild(paginationItem);
}

// add to the page
document.querySelector('.indicator').appendChild(paginationElement);

// get the new created element
let paginationCreatedUl = document.getElementById('pagination-ul');
let paginationBullets = Array.from(document.querySelectorAll('#pagination-ul li'));

for (let i = 0; i < paginationBullets.length; i++) {
    paginationBullets[i].onclick = function() {
        currentSlide = parseInt(this.getAttribute('data-index'));
        theChecker();
    }
}

// Trigger the checker function
theChecker();

autoSlide();

// get next slide
function nextSlide() {
    if (currentSlide < slidesCount) {
        currentSlide++;
        theChecker();
    }
}

// get previous slide
function previousSlide() {
    if (currentSlide > 1) {
        currentSlide--;
        theChecker();
    }
}

// Create the checker function
function theChecker() {
    slideNumber.textContent = 'Slide # ' + (currentSlide) + ' of ' + (slidesCount);
    removeAllAcitives();
    sliderImages[currentSlide - 1].classList.add('active');
    paginationCreatedUl.children[currentSlide - 1].classList.add('active');

    // if the currentSlide is the first
    currentSlide === 1 ?
        previous.classList.add('disabled') : previous.classList.remove('disabled');
    currentSlide === slidesCount ?
        next.classList.add('disabled') : next.classList.remove('disabled');
}

function removeAllAcitives() {
    sliderImages.forEach(image => image.classList.remove('active'));
    paginationBullets.forEach(child => child.classList.remove('active'));
}

function autoSlide() {
    setInterval(function() {
        currentSlide++;
        if (currentSlide > slidesCount)
            currentSlide = 1;
        theChecker();
    }, 5000);
}