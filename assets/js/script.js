window.onload = function() {
    //Get the elements looking for their Id
    let sendLastName = document.getElementById('sendLastName');
    let sendStudent = document.getElementById('sendStudent');
    let findAll = document.getElementById('findAll');
    let individualTable = document.getElementById('attendanceChart');

    //Evaluate if the element exist
    if (sendLastName != null) {
        sendLastName.addEventListener('click', ShowInformation);
    }
    if (sendStudent != null) {
        sendStudent.addEventListener('click', ShowRegisterForm);
    }
    if (individualTable) {
        individualTable.addEventListener('click', ShowIndividualTable);
    }
    if (findAll) {
        findAll.addEventListener('click', ShowAllRecords);
    }

}

function ShowInformation() {
    let lastname = document.getElementById('txtLastName').value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("infoTable").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/iot/tableStudent?txtLastName=" + lastname, true);
    xhttp.send();
}

function ShowRegisterForm() {
    let lastname = document.getElementById('studentOption').value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('updatedForm').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/iot/formStudent?studentOption=" + lastname, true);
    xhttp.send();
}

function ShowIndividualTable(evt) {
    var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
    var firstPoint = activePoints[0];
    var label = myChart.data.labels[firstPoint._index];
    var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('attendanceTable').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/record/attendance?student=" + label, true);
    xhttp.send();
}

function ShowAllRecords() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('attendanceTable').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/record/attendance", true);
    xhttp.send();
}