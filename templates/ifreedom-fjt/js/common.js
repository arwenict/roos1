function openPopUp() {
    document.getElementById("overlay").style.display = "block"; 
}

function closePopUp() {
    document.getElementById("overlay").style.display = "none";
}

function openEditPopUp(id) {
    var $ = new jQuery.noConflict();
    document.getElementById("edit-overlay").style.display = "block";
    $("#editPopup").load("/main/kendoui/reports/data/ajaxHandler.php", "action=edit_instructor&instructorID="+id);
}

function closeEditPopUp() {
    document.getElementById("edit-overlay").style.display = "none";
}