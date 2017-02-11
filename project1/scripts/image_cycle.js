/*
* Lini Tan
*
* swap images in the index page
*
*/

// variables
var index = 1;
var pic = ["p5.png", "p6.png", "p7.png"];
//p5.jpg,p6.jpg, p7.jpg are photoed by myself (Lini Tan)
var main_image = document.getElementById('top_image');

// functions
function img_change() {
    "use strict";
    if (index < pic.length) {
        main_image.src = 'images/' + pic[index];
        index += 1;
    } else {
        index = 0;
        main_image.src = 'images/' + pic[index];
        index += 1;
    }
}

function pic_cycle() {
    "use strict";
    setInterval(img_change, 3000);
}

// function call
pic_cycle();
