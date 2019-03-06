window.onload=function(){
    autoRowSpan(document.getElementById("userActivityTimeTableResult"));
}

function cancelAuthorization(obj, url) {
    obj.action = url;
    obj.submit();
}

function autoRowSpan(table){
    console.log(table);
    var rows = table.rows.length;
    var cols = table.rows[0].cells.length;
    for(var col = cols - 1; col >= 0; col-- ){
        for(var  row =rows - 2; row >= 0; row--){
            if( table.rows[row].cells[col].innerHTML == table.rows[row+1].cells[col].innerHTML ){
               if( table.rows[row+1].cells[col].rowSpan )
                   table.rows[row].cells[col].rowSpan = table.rows[row+1].cells[col].rowSpan;
               else
                   table.rows[row].cells[col].rowSpan = 1;
               table.rows[row+1].deleteCell(col);
               table.rows[row].cells[col].rowSpan += 1;
            }
        }
    }
}