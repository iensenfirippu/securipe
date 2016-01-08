var lastid = "";

function SelectComment(divid)
{
	if (divid != lastid) {
		if (window.lastid != "") {
			GetFirstChildOfClass(document.getElementById(lastid), "commentinfo selected").className = "commentinfo";
		}
		window.lastid = divid;
		
		if (divid == "") {
			document.getElementById("Comments").removeAttribute("class");
			document.getElementById("CommentInput").value = "";
		} else {
			document.getElementById("Comments").className = "hasselection";
			GetFirstChildOfClass(document.getElementById(divid), "commentinfo").className = "commentinfo selected";
		}
		
		document.getElementById("CommentSelect").value = divid;
		document.getElementById("CommentInput").focus();
	}
}

function GetFirstChildOfClass(element, classname)
{
	var child = false;
	var children = element.children;
	for (var i = 0; i < children.length; i++) {
		if (children[i].className == classname) {
			child = children[i];
			break;
		}
	}
	return child;
}

/*function CommentHere(divid)
{
	if (divid != lastid) {
		UpdateLastId(divid);
		
		var target = GetChildWithClass(document.getElementById(divid), "commentinput");
		var input = document.getElementById(inputid);
		//message.removeAttribute("id");
		document.getElementById(parentid).className = "hasselection";
		
		input.parentNode.removeChild(input);
		target.appendChild(input);
	}
}

function CommentReset()
{
	UpdateLastId("");
	
	var target = document.getElementById(originid);
	var input = document.getElementById(inputid);
	
	document.getElementById(parentid).removeAttribute("class");
	GetChildWithClass(document.getElementById(lastid), "commentmessage").id = "selected";
	
	input.parentNode.removeChild(input);
	target.appendChild(input);
}

function UpdateLastId(divid)
{
	if (window.lastid != "") {
		//var last = document.getElementById(lastid);
		//var message = GetChildWithClass(last, "commentmessage");
		//message.removeAttribute("id");
		GetChildWithClass(document.getElementById(lastid), "commentmessage").removeAttribute("id");
		
		//GetChildWithClass(document.getElementById(divid), "commentmessage").id = "selected";
	}
	window.lastid = divid;
}

function GetChildWithClass(element, classname)
{
	var child = false;
	var children = element.children;
	for (var i = 0; i < children.length; i++) {
		if (children[i].className !== classname) {
			child = children[i];
			break;
		}
	}
	return child;
}*/
