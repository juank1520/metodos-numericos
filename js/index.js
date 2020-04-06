jsMatrix = document.getElementsByClassName('js-matrix')[0];
jsResult = document.getElementsByClassName('js-result')[0];
jsRow = jsMatrix.getElementsByClassName('js-row');
jsMatrixInput = document.getElementsByClassName('js-input-matrix')[0];

function numberOfRows(){
    return jsRow.length;
}

function numberOfColumns(){
    return jsRow[0].getElementsByTagName('input').length;
}

function addRow(){
    const newRow = document.createElement('div');
    newRow.className = 'row js-row';

    for(let i=0; i < numberOfColumns() ; i++ ){
        const element = document.createElement("input");
        element.type = 'number';
        element.className = 'mini';
        newRow.appendChild(element);
        if(i === 0){
            jsResult.appendChild(newRow.cloneNode(true));
        }
    }
    jsMatrix.appendChild(newRow);
}

function addColumn(){
    const newColumn = document.createElement('input');
    newColumn.type = 'number';
    newColumn.className = 'mini';
    for(let row of jsRow){
        row.appendChild(newColumn.cloneNode(true));
    }
}

function getMatrix(){
    let matrix = [];
    for (let i = 0; i < jsRow.length; i++) {
        const elements = jsRow[i].getElementsByTagName('input');
        const matrixRow = [];
        for (let j = 0; j < elements.length ; j++ ) {
            matrixRow[j] = Number(elements[j].value);
        }
        matrix.push(matrixRow);

    }
    return matrix;
}

function getResults(){
    let matrix = [];
    const element = jsResult.getElementsByTagName('input');
    for (let i = 0; i < element.length; i++) {
        matrix[i] = Number(element[i].value);
    }
    return matrix;
}



async function result(){

    const matrix = JSON.stringify(getMatrix());
    const results = JSON.stringify( getResults());

    const formData = new FormData;
    formData.append("name", "jacobi");
    formData.append("matrix", matrix);
    formData.append("results", results);


    const response = await fetch('ecuaciones-lineales/form.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.text();
    jsMatrixInput.innerHTML = data;
}
