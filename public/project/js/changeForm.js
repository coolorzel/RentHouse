var formEdit = [];
var divNode = document.getElementById("editData");
var inputNodes = divNode.getElementsByTagName('INPUT');
function editButtonData() {
    for(var i = 0; i < inputNodes.length; i++){
        formEdit.push({
            name: inputNodes[i].name,
            value: inputNodes[i].value
        });
    }
    formEdit.forEach((index) => {
        const element = document.getElementsByName(index.name)[0];
        element.readOnly = false;
        element.classList.remove('form-control-plaintext');
        element.classList.add('form-control');
    });

    document.getElementById('editButtonSelect').style.display = 'none';
    document.getElementById('cancelButtonSelect').style.display = '';
    document.getElementById('saveButtonSelect').style.display = '';
}

function cancelButtonData() {
    formEdit.forEach((index) => {
        const element = document.getElementsByName(index.name)[0];
        element.value = index.value;
        element.readOnly = true;
        element.classList.remove('form-control');
        element.classList.add('form-control-plaintext');
    });

    document.getElementById('editButtonSelect').style.display = '';
    document.getElementById('cancelButtonSelect').style.display = 'none';
    document.getElementById('saveButtonSelect').style.display = 'none';
    formEdit = [];
}
