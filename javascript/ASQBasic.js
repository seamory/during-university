// 创建radio标签
// 实现input标签元素value值的自定义修改
// 问卷调查用户自定义基础
function creatRadio(obj, name){
    var div = document.createElement("div");
    div.setAttribute("class", "radio-inline");

    var label = document.createElement("label");

    input = function(_type) {
        var Node = document.createElement("input");
        input.setAttribute("type", _type);
        input.setAttribute("value","");
        return Node;
    }

    var radio = input("radio");
    var text = input("text");
    radio.setAttribute("name", name);
    text.setAttribute("onblur", "finshRadio(this)");

    label.appendChild(radio);
    label.appendChild(text);
    div.appendChild(label);

    obj.parentNode.appendChild(div);
}

function changeRadio(obj){
    var parent = obj.parentNode;
    var childNodes = parent.childNodes;
    for(var i = 0; i< childNodes.length; i++)
        if( obj == childNodes[i] )
            parent.removeChild(childNodes[i]);
    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("onblur", "finshRadio(this)");
    parent.appendChild(input);
}

function finshRadio(obj){
    console.log(obj);
    var parent = obj.parentNode;
    var childNodes = parent.childNodes;
    var radio = obj.previousElementSibling;
    var span = document.createElement("span");
    span.setAttribute("ondblclick", "changeRadio(this)");
    span.innerHTML = obj.value;
    parent.appendChild(span);
    radio.value = obj.value;
    for(var i = 0; i< childNodes.length; i++)
        if( obj == childNodes[i] )
            parent.removeChild(childNodes[i]);
}