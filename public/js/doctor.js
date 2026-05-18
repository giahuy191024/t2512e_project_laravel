// const doctorsData = {
//
//     north: [
//         {
//             name: "BS. Phan Hồng Tiến",
//             image: "../img/doctor1.png",
//             specialty: "Chuyên gia Implant",
//             info: "Hơn 12 năm kinh nghiệm Implant và phục hình răng."
//         },
//
//         {
//             name: "BS. Nguyễn Linh Trang",
//             image: "../img/doctor2.png",
//             specialty: "Bác sĩ chỉnh nha",
//             info: "Chuyên niềng răng Invisalign."
//         },
//
//         {
//             name: "BS. Vũ Thị Phương",
//             image: "../img/doctor3.png",
//             specialty: "Nha khoa tổng quát",
//             info: "Điều trị nha khoa trẻ em."
//         },
//
//         {
//             name: "BS. Triệu Thúy Nga",
//             image: "../img/doctor4.png",
//             specialty: "Răng sứ thẩm mỹ",
//             info: "Chuyên phục hình răng sứ cao cấp."
//         }
//     ],
//
//     central: [
//         {
//             name: "BS. Lê Minh Tâm",
//             image: "../img/doctor5.png",
//             specialty: "Chỉnh nha",
//             info: "Hơn 10 năm kinh nghiệm chỉnh nha."
//         },
//
//         {
//             name: "BS. Võ Thanh Hà",
//             image: "../img/doctor6.png",
//             specialty: "Implant",
//             info: "Điều trị Implant công nghệ cao."
//         },
//
//         {
//             name: "BS. Trần Quốc Khánh",
//             image: "../img/doctor7.png",
//             specialty: "Nha khoa trẻ em",
//             info: "Điều trị nha khoa trẻ em nhẹ nhàng."
//         }
//     ],
//
//     south: [
//         {
//             name: "BS. Hoàng Thu Hiền",
//             image: "../img/doctor8.png",
//             specialty: "Răng sứ",
//             info: "Phục hình răng thẩm mỹ."
//         },
//
//         {
//             name: "BS. Đặng Hữu Long",
//             image: "../img/doctor9.png",
//             specialty: "Implant",
//             info: "Chuyên Implant toàn hàm."
//         },
//
//         {
//             name: "BS. Nguyễn Kim Anh",
//             image: "../img/doctor10.png",
//             specialty: "Niềng răng",
//             info: "Điều trị Invisalign."
//         },
//
//         {
//             name: "BS. Lý Minh Đức",
//             image: "../img/doctor11.png",
//             specialty: "Nha khoa tổng quát",
//             info: "Điều trị tổng quát chuyên sâu."
//         },
//
//         {
//             name: "BS. Trần Bảo Vy",
//             image: "../img/doctor12.png",
//             specialty: "Thẩm mỹ răng",
//             info: "Thiết kế nụ cười chuẩn thẩm mỹ."
//         }
//     ]
// };

const doctorsGrid = document.getElementById("doctorsGrid");

function changeRegion(region, button) {

    document.querySelectorAll(".doctor-tab")
        .forEach(tab => tab.classList.remove("active"));

    button.classList.add("active");

    document.querySelectorAll(".doctor-region")
        .forEach(section => {
            section.style.display = "none";
        });

    document.getElementById(region).style.display = "grid";
}

function openDoctorModal(name, info) {

    document.getElementById("doctorModal").style.display = "flex";

    document.getElementById("modalDoctorName").innerText = name;

    document.getElementById("modalDoctorInfo").innerText = info;
}

function closeDoctorModal() {

    document.getElementById("doctorModal").style.display = "none";
}
// mặc định hiện miền Bắc
document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("north").style.display = "grid";

});
// renderDoctors("north");
