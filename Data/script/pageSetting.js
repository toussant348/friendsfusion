/**************Get Global Values***********/
let side_bar_height = window.innerHeight;

const header_height = 20;
const footer_height = 10;


setSideBarHeight(){
    side_bar_height-=(header_height + footer_height);
    document.getElementsByClassName("sideBar")[0].setAttribute
}
console.log(side_bar_height);